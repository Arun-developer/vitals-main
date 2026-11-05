

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Villgro MIS</title>
        <?php // echo base_url().'source/portfolio_assets/css/new-portfolio.css'; ?>
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
        <!-- Library css -->
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    </head>

    <body>
        <div class="fixed-headervi">
            <header>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="vil-logo">
                                <a href="<?php echo base_url(); ?>">
                                    <img src="<?php echo base_url() . 'source/portfolio_assets/img/logo.jpg'; ?>" class="responsive" alt="Villgro Logo" />
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-2 offset-xl-4 offset-md-2 col-md-4 order-10 col-12">
                            <small>Welcome,</small>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo $this->session->userdata['emp_name']; ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="<?php echo base_url() . 'index.php/login/admin_portfolio'; ?>"><i class="fas fa-retweet"></i> Switch to user</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-key"></i> Change password</a>
                                    <a class="dropdown-item" href="<?php echo base_url() . 'index.php/login/logout'; ?>"><i class="fas fa-sign-out-alt"></i> Sign out</a>
                                </div>
                            </div>
                            <a href="<?php echo base_url() . 'index.php/login/admin_portfolio'; ?>" class="admin_linker">( Switch to user )</a>
                        </div>
                    </div>
                </div>
            </header>
            <div class="villgro-breadcrumb container-fluid">
                <div class="row">
                    <div class="col-md-12 col-12">
                        <ul>
                            <li><a href="dashboard" class="active">Home</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="v-menu">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <ul>
                                <li><a href="<?php echo base_url() . 'index.php/portfolio/mydeals'; ?>">Deals</a></li>
                                <li><a href="<?php echo base_url() . 'index.php/login/approvals'; ?>">Approve</a></li>
                                <li><a href="<?php echo base_url() . 'index.php/login/portfolio'; ?>">Portfolio</a></li>
                                <li><a href="<?php echo base_url() . 'index.php/login/resources'; ?>">Resources</a></li>
                                <li><a href="<?php echo base_url() . 'index.php/login/master'; ?>">Masters</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $userName = strstr($this->session->userdata['emp_name'] . ' ', ' ', true);
        ?>

        <!-- Inner Dashboard-->
        <div class="vi-dashboard">
            <div class="msg success"><strong>Welcome <span><?php echo $userName; ?>,</span></strong>
                <p>You have <span>3</span> new updates since you last visit</p>
            </div>
            <div class="container-fluid">
                <div class="topper-dashvil">
                    <div class="row">
                        <div class=" col-xl-6 col-lg-6 col-md-6 col gray-background">
                            <div class="row">
                                <div class="col-xs-4 col-lg-4 col-md-4 col">
                                    <a href="<?= base_url() . 'index.php/portfolio/portfolioui/configurationlist'; ?>">
                                        <div class="dash-card">
                                            <h6>5</h6>
                                            <p>Configuration <i class="fas fa-chevron-circle-right"></i></p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-4 col-lg-4 col-md-4 col">
                                    <a href="<?= base_url() . 'index.php/portfolio/portfolioui/pendinginputlist'; ?>">
                                        <div class="dash-card">
                                            <h6>2</h6>
                                            <p>Pending Input <i class="fas fa-chevron-circle-right"></i></p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xs-4 col-lg-4 col-md-4 col">
                                    <a href="<?= base_url() . 'index.php/portfolio/portfolioui/update_sales'; ?>">
                                        <div class="dash-card">
                                            <h6>1</h6>
                                            <p>Plan Approval <i class="fas fa-chevron-circle-right"></i></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class=" col-xl-6 col-lg-6 col-md-6 col">
                            <div class="title-label">Company Summary</div>
                            <div class="table-responsive">
                                <table class="summary_table ">
                                    <tr>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>1. Target cos :</td>
                                                    <td>50/650</td>
                                                </tr>
                                                <tr>
                                                    <td>2. Application :</td>
                                                    <td><?php echo $countDetails[0]['Application'] . ' / ' . $countDetails[0]['Total_count'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>3. PA/RD :</td>
                                                    <td><?php echo $countDetails[0]['PA_RD'] . ' / ' . $countDetails[0]['Total_count'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>4. IIC Approved :</td>
                                                    <td><?php echo $countDetails[0]['IIC_Approved'] . ' / ' . $countDetails[0]['Total_count'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>5. EIC Approved :</td>
                                                    <td><?php echo $countDetails[0]['EIC_Approved'] . ' / ' . $countDetails[0]['Total_count'] ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <div class="cmy-vil-summary">
                                                <div class="title-label-sub">Exits & Graduates</div>
                                                <table>
                                                    <tr>
                                                        <td>Target :</td>
                                                        <td>50</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Actual :</td>
                                                        <td>63</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="cmy-vil-summary">
                                                <div class="title-label-sub">Overview</div>
                                                <table>
                                                    <tr>
                                                        <td>Current Incubatees :</td>
                                                        <td>256</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Incubatees :</td>
                                                        <td>1768</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Incubatees on board:</td>
                                                        <td>1248</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col">
                        <div class="title-cart-vi">
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12">
                                    <h4>Incubatees</h4>
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 text-right">
                                    <a href="">
                                        <i class="fas fa-external-link-alt"></i><br>
                                        <span>Export</span>
                                    </a>
                                    <a href="">
                                        <i class="fas fa-expand-arrows-alt"></i><br>
                                        <span>Maximize</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="comapny-graph">
                            <div class="row">
                                <div class="col">
                                    <div class="company_chartvi">
                                        <p>Total</p>
                                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/total-companies.png'; ?>">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="company_chartvi">
                                        <p>New</p>
                                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/new-companie.png'; ?>">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="company_chartvi brd-none">
                                        <p>Graduates&amp;Exits</p>
                                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/graduates.png'; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="top_perfomer">
                            <div class="title-label">Top Performer</div>
                            <p class="tp_title_brd">Sri enterprises, Agriculture, chennai</p>
                            <div class="top-performer-grph">
                                <div class="row">
                                    <div class="col-xl-4 col-md-4">
                                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/not-profit.png'; ?> ">
                                    </div>
                                    <div class="col-xl-4 col-md-4">
                                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/not-profit.png'; ?>">
                                    </div>
                                    <div class="col-xl-4 col-md-4">
                                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/not-profit.png'; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="#">More <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="vil-milestone">
                            <div class="title-label">Top Performer</div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Incubatee</th>
                                        <th>Milestone</th>
                                        <th>Task</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Sri sai Enterprises</td>
                                        <td>Milestone 1</td>
                                        <td>Task 1</td>
                                        <td>
                                            <p class="text-danger">mm/dd/yyyy</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Ethiraj Motors</td>
                                        <td>Milestone 2</td>
                                        <td>Task 2</td>
                                        <td>
                                            <p class="text-success">mm/dd/yyyy</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Donquadtech</td>
                                        <td>Milestone 3</td>
                                        <td>Task 3</td>
                                        <td>
                                            <p class="text-success">mm/dd/yyyy</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Openlance</td>
                                        <td>Milestone 4</td>
                                        <td>Task 4</td>
                                        <td>
                                            <p class="text-success">mm/dd/yyyy</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Ethiraj Motors</td>
                                        <td>Milestone 5</td>
                                        <td>Task 5</td>
                                        <td>
                                            <p class="text-success">mm/dd/yyyy</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Donquadtech</td>
                                        <td>Milestone 6</td>
                                        <td>Task 6</td>
                                        <td>
                                            <p class="text-success">mm/dd/yyyy</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer id="bottom">
            <section class="container clearfix">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-12">
                        <a href="#"></a>
                        <a href="#"></a>
                        <a href="#"></a>
                        <a href="#"></a>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 text-right">
                        Copyright © 2019 <a href="<?= base_url(); ?>">mis.villgroapps.org</a>
                    </div>
                </div>
            </section>
        </footer>

        <!-- script -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>

</html>
