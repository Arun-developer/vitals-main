<?php
$split_empname = explode(' ', $this->session->userdata['emp_name']);
$first_name = array_shift($split_empname);
$partner_str = preg_replace('/\s+/', '', $this->session->userdata['partner_name']);
$gtag_user = $first_name . '_' . $partner_str . '_' . $this->session->userdata['emp_number'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sector Plan Approval List</title>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23930880-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-23930880-2', {'user_id': '<?= $gtag_user; ?>'});
    </script>
    <link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
</head>

<?php
$form_name = 'searchPage';
$stage_val = array("7" => "Application", "8" => "PA/RD", "9" => "Detailed Diligence");
?>

<body>
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
                    if (php72_cmp($this->session->userdata('role_id')) == 2 && $this->session->userdata['user_type'] == 'admin') {
                        $switch_type = 'Switch to user';
                    } else if (php72_cmp($this->session->userdata('role_id')) == 2 && $this->session->userdata('user_type') == 'employee') {
                        $switch_type = 'Switch to admin';
                    }
                    ?>

                    <div class="col-xl-2 offset-xl-4 offset-md-2 col-md-4 order-10 col-12">
                        <small>Welcome,</small>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php
                            if ($this->session->userdata('user_type') == 'superadmin') {
                             echo "Super Admin";
                         } else if ($this->session->userdata('user_type') == 'admin' and php72_cmp($this->session->userdata('role_id')) == 2) {
                             echo ucfirst($this->session->userdata('emp_name'));
                         } else if ($this->session->userdata('user_type') == 'employee' and php72_cmp($this->session->userdata('role_id')) == 2) {
                             echo ucfirst($this->session->userdata('emp_name'));
                         } else if ($this->session->userdata('user_type') == 'admin' and php72_cmp($this->session->userdata('role_id')) == 1) {
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
                        <a class="dropdown-item" href="<?php echo base_url() . 'index.php/login/logout'; ?>"><i
                            class="fas fa-sign-out-alt"></i> Sign out</a>
                        </div>
                    </div>
                    <!-- <a href="admin-dashboard.html" class="admin_linker">( Switch to admin )</a> -->
                </div>
            </div>
        </div>
    </header>
    <div class="villgro-breadcrumb container-fluid">
        <div class="row">
            <div class="col-md-12 col-12">
                <ul>
                    <li><a href="<?= base_url() . 'index.php/portfolio/dashboard'; ?>">Home </a></li> <i
                    class="fa fa-angle-double-right"></i>
                    <li><a class="active">Sector Approval List</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="vil-sub_menu deal-bread">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-md-3 col-sm-3 col-12">
                    <h4>Sector Approval List</h4>
                </div>
                <div class="col-xl-9 col-md-9 col-sm-9 col-12 text-right">
                    <div class="form-group">
                        <ul>
                            <li>
<!--                                        <form id="search" action="<?= base_url() . 'index.php/portfolio/addportfolio'; ?>"
                                              method="post" name="<?= $form_name ?>" autocomplete="off">
                                            <div id="custom-search-input">
                                                <div class="input-group">
                                                    <input type="text" class="search-query form-control" name="search_value"
                                                           placeholder="Search by incubatees #ID" value="<?php echo (isset($search_value)) ? $search_value : ''; ?>" />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-danger" type="submit">
                                                            <i class="fas fa-search"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </form>-->
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Inner Dashboard-->
        <div class="vi-dashboard">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <?php if ($search_value != '') { ?>
                            <p class="aprvd-deals">Showing search results for '<?= $search_value; ?>'</p>
                        <?php } else { ?>
                            <p class="aprvd-deals"></p>
                        <?php } ?>
                        <div class="Diagnostic-graph">
                            <div id="accordion" class="vil-Deals table-responsive input-pending portfolio-table">
                                <table class="table" id="sectorplan_approval">
                                    <thead>
                                        <tr>
                                            <th width="10%">S.No</th>
                                            <th width="30%">Sector ID</th>
                                            <th width="30%">Sector</th>
                                            <th width="30%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div class="pull-right">
                            <?php echo $this->pagination->create_links_new($form_name); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-1.9.1.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/main.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    </body>

    <script>
        $(document).ready(function () {
            $('#sectorplan_approval').DataTable({
                "bProcessing": true,
                "bServerSide": true,
                "paging": true,
                "ordering": true,
                "info": false,
                "searching": false,
                "pageLength": 10,
                "lengthChange": false,
                "stateSave": false,
                            //                            responsive: {
                            //                                details: {
                            //                                    type: 'column',
                            //                                    target: -1
                            //                                }
                            //                            },
                            "ajax": {
                                "url": "<?php echo base_url(); ?>index.php/portfolio/DTsectorplan_approval",
                                "data": {"search_value": "<?php echo $search_value; ?>"},
                                "type": "POST"
                            },
                            //                            fixedColumns: true
                            //                            "displayStart": 2
                        });
        });

        $('[data-toggle="collapse"]').click(function () {
            $('.collapse.in').collapse('hide');
        });
    </script>
    <style>
        a[aria-expanded="true"] {
            background: transparent !important;
            border-left: none !important;
        }
    </style>

    </html>