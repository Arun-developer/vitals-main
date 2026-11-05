<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villgro MIS</title>
    <!-- <link rel="stylesheet" href="http://192.168.1.200:8095/vital/source/portfolio_assets/css/new-portfolio.css"> -->
    <link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.4/css/dataTables.responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

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
    </div>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">
            <div class="Vital-Newmenu">
                <div class="row">
                    <div class="col">
                        <ul>
                            <li><a href=""><i class="fas fa-home"></i> Home</a></li>
                            <li><a href=""><i class="fas fa-tag"></i> Deals</a></li>
                            <li class="active"><a href=""><i class="fas fa-sync-alt"></i> Requests</a></li>
                            <li><a href=""><i class="far fa-check-square"></i> Approve</a></li>
                            <li><a href=""><i class="far fa-chart-bar"></i> Portfolio</a></li>
                            <li><a href=""><i class="fas fa-archive"></i> Resources</a></li>
                            <li><a href=""><i class="fas fa-suitcase"></i> Reports</a></li>
                            <!-- <li><a href="">Master's</a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="dataconfig-content page-wrapper vitals_mainContent ">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('UI/request/request_sidemenu.php', array('monthlist' => $monthlist, 'actual_month' => $actual_month, 'quater_month' => $quater_month, 'get_yearMonth' => $get_yearMonth, 'class_name' => $current_month, 'pending_month' => $pending_month, 'module' => 'channel', 'curfin_year' => $current_financial, 'fin_year' => $fin_year)); ?>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                    <h4>Apply</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                    <ul class="vitals-links">
                                        <li><a href="" class="NewbtnVitalgrn" data-toggle="modal" data-target="#exampleModal">Leave Balance</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="inputplan-structureall plan-structure-new">
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="wdt-80">
                                            <div class="form-group">
                                                <label>Leave Type</label>
                                                <select class="form-control">
                                                    <option>Work From Home</option>
                                                    <option>Assets</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Leave Type</label>
                                                <select class="form-control">
                                                    <option>Full Time</option>
                                                    <option>Part Time</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Select Date</label>
                                                <input type="text" class="form-control" placeholder="14-05-2020" />
                                            </div>
                                            <div class="form-group">
                                                <label>Comments</label>
                                                <textarea class="form-control"></textarea>
                                            </div>
                                            <div>
                                                <ul class="vitals-links">
                                                    <li><a href="" class="NewbtnVitalgrn">Apply</a></li>
                                                    <li><a href="" class="NewbtnVitaldefault">Cancel</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Leave Allocation for 2020</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                            <table class="table table-hover dt-responsive">
                                <thead>
                                    <tr>
                                        <th>Leave Type</th>
                                        <th>Leave Entitled <small>(days)</small></th>
                                        <th>Leave Scheduled <small>(days)</small></th>
                                        <th>Leave Takens <small>(days)</small></th>
                                        <th>Leave Carry Forward <small>(days)</small></th>
                                        <th>Leave Encashed <small>(days)</small></th>
                                        <th>Leave Remaining <small>(days)</small></th>
                                        <th>Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Casual</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Medical</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Earned</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Maternity</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Paternity</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Adoption</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Additional Leave</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Comp off</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Work from home</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Casual</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Medical</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Earned</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Maternity</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>0.00</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
<script>
    $('table').DataTable();
</script>
</body>

</html>