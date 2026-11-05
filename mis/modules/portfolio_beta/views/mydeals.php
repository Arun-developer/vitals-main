<?php
$page_title = 'Deals';
$load_count = 25;
$deals_check = $tab_name = '';
if ($currentTab == 'assigned') {
    $page_title = 'Only Deals';
    $load_count = 50;
    $deals_check = 'checked';
    $tab_name = 'mydeals';
} else if ($currentTab == 'all') {
    $page_title = 'All Deals';
    $load_count = 25;
    $tab_name = 'alldeals';
}
$nullLink = "javascript:void(0);";
$form_name = "innovation_pool";

$isAssign = false;
$isExport = false;
$isAssignCycle = false;
$isDetails = true;
if (in_array($this->session->userdata('user_type'), array('superadmin', 'admin', 'ceo', 'cio'))) {
    $isAssign = true;
    $isExport = true;
    $isAssignCycle = true;
}

if (isset($_POST['txtSubmit']) && $_POST['txtSubmit']) {
    if ($_POST['created_date'] != '') {
        $_POST['created_date'] = str_replace('/', '_', $_POST["created_date"]);
    }
    if ($_POST['created_date_to'] != '') {
        $_POST['created_date_to'] = str_replace('/', '_', $_POST["created_date_to"]);
    }
    if ($_POST['submitted_date'] != '') {
        $_POST['submitted_date'] = str_replace('/', '_', $_POST["submitted_date"]);
    }
    if ($_POST['submitted_date_to'] != '') {
        $_POST['submitted_date_to'] = str_replace('/', '_', $_POST["submitted_date_to"]);
    }
    if ($_POST['email'] != '') {
        $_POST['email'] = str_replace('@', '^at^', $_POST['email']);
    }
    if ($_POST['stage'] != '') {
        $_POST['stage'] = str_replace("-", "^", $_POST['stage']);
    }
    if ($_POST['status'] != '') {
        $_POST['status'] = implode('_', $_POST['status']);
    }
    if ($_POST['copy_id']) {
        $_POST['copy_id'] = str_replace("_", "ab", $_POST['copy_id']);
    }

    $url_post = '';
    $post = implode(':', array_map(function ($key, $val) {
        return $key . '-' . $val;
    }, array_keys($_POST), $_POST)
);
    $url_post .= '"' . $post . '"';
}

$name = (isset($_REQUEST['branch_name']) && !empty($_REQUEST['branch_name'])) ? $_REQUEST['branch_name'] : $this->session->userdata['partner_id'];
if ($name == '10') {
    $program = isset($_REQUEST['program']) && $_REQUEST['program'] != '' ? '4' : '';
    $getSectorList = array("99" => 'Agriculture & Fish', "100" => 'Textile', "101" => 'Dairy', "102" => 'Fishery', "103" => 'Others');
} else {
    $program = isset($_REQUEST['program']) ? $_REQUEST['program'] : '';
    $getSectorList = array("1" => 'Agri-business', "2" => 'CleanTech', "4" => 'Climate Action', "3" => 'Education & Employability', '64' => 'Employability', "5" => 'Health', "10" => 'Livelihoods & Job creation', "7" => 'Skill Development', "182" => 'Gender Inclusion', "12" => 'Others');
}
$copy_id = isset($_REQUEST['copy_id']) ? $_REQUEST['copy_id'] : '';
$branch_sel = isset($_REQUEST['branch']) ? $_REQUEST['branch'] : $this->session->userdata('partner_id');
$branch_name = isset($_REQUEST['branch_name']) ? $_REQUEST['branch_name'] : $this->session->userdata('partner_id');
$name_of_enterprise = isset($_REQUEST["name_of_enterprise"]) ? $_REQUEST["name_of_enterprise"] : '';
$name_of_entrepreneur = isset($_REQUEST["name_of_entrepreneur"]) ? $_REQUEST["name_of_entrepreneur"] : '';
$source_type = isset($_REQUEST['source_type']) ? $_REQUEST['source_type'] : '';
$source = isset($_REQUEST['source']) ? $_REQUEST['source'] : '';
$sector = isset($_REQUEST['sector']) ? $_REQUEST['sector'] : '';
$stage_post = isset($_REQUEST['stage']) ? $_REQUEST['stage'] : "";

if (isset($_REQUEST['status']) && $_REQUEST['status'] != '') {
    $status_post = implode(',', $_REQUEST['status']);
} else {
    $status_post = "";
}

$status_array_post = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";
$created_date = isset($_REQUEST['created_date']) ? $_REQUEST['created_date'] : '';
$created_date_to = isset($_REQUEST['created_date_to']) ? $_REQUEST['created_date_to'] : '';
$submitted_date = isset($_REQUEST['submitted_date']) ? $_REQUEST['submitted_date'] : "";
$submitted_date_to = isset($_REQUEST['submitted_date_to']) ? $_REQUEST['submitted_date_to'] : "";
$geography = isset($_REQUEST['geography']) ? $_REQUEST['geography'] : '';
$city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';
$lis = isset($_REQUEST['lis']) ? $_REQUEST['lis'] : '';
$donors = isset($_REQUEST['donor_fit']) ? $_REQUEST['donor_fit'] : '';
$assigned_incharge = (isset($_REQUEST['assigned_incharge'])) ? $_REQUEST['assigned_incharge'] : '';
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
$mobile = isset($_REQUEST['mobile']) ? $_REQUEST['mobile'] : '';

$branch_n = !empty($this->session->branchdetails['admin_branch']) ? $this->session->branchdetails['admin_branch'] : $this->session->userdata('partner_id');

$incomplete_val = $register_val = $deleted_val = '';
if (isset($_REQUEST['ordertype'])) {
    if (isset($_REQUEST['incomplete'])) {
        $incomplete_val = 1;
    }
    if (isset($_REQUEST['register'])) {
        $register_val = 1;
    }
    if (isset($_REQUEST['deleted'])) {
        $deleted_val = 1;
    }
}
?>

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
    <title><?= $page_title; ?></title>
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

<body>
    <?php $form_name = 'searchPage'; ?>
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
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <a class="dropdown-item" href="<?php echo base_url() . 'index.php/login/logout'; ?>"><i
                            class="fas fa-sign-out-alt"></i> Sign out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="villgro-breadcrumb container-fluid">
        <div class="row">
            <div class="col-md-12 col-12">
                <ul>
                    <li><a href="<?= base_url() . 'index.php/portfolio/dashboard'; ?>">Home</a></li> <i
                    class="fa fa-angle-double-right"></i>
                    <li><a class="active"><?= $page_title; ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="vil-sub_menu deal-bread ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                    <ul class="milestone-links">
                        <li><h6 class="reduce_space"><?= $cpagetitle ?> - <?php
                        foreach ($branch as $partner) {
                            if ($partner['id'] == $name) {
                                echo $partner['branch_name'];
                            }
                            ?>
                            <?php
                        }
                        if ($currentTab == 'similar') {
                            echo '( ' . $name_of_enterprise . ' )';
                        }
                        ?> </h6></li>
                        <li>
                            <?php
                            if ($this->session->userdata('user_type') == 'superadmin') {
                                ?>
                                - <select name="branch" id="branch" onchange="innovation(this.value);">
                                    <?php foreach ($branch as $partner) { ?>
                                        <option value="<?php echo $partner['id']; ?>" <?php echo ($partner['id'] == $branch_n ? 'selected' : ''); ?>>
                                            <?php echo $partner['branch_name']; ?> </option>
                                        <?php } ?>
                                    </select>
                                    <?php
                                } else if (($this->session->userdata('user_type') == 'employee' || $this->session->userdata('user_type') == 'ceo' || $this->session->userdata('user_type') == 'cio' || $this->session->userdata('user_type') == 'abi' || $this->session->userdata('user_type') == 'icm') && $this->session->userdata('accessTo') != '') {
                                    ?>
                                    - <select name="branchname" id="branchname" onchange="innovation(this.value);">
                                        <option value="">--Select Partner--</option>
                                        <?php foreach ($partnerS as $partner) { ?>
                                            <option value="<?php echo $partner['id']; ?>" <?php echo ($partner['id'] == $branch_n ? 'selected' : ''); ?>>
                                                <?php echo $partner['branch_name']; ?> </option>
                                            <?php } ?>
                                        </select>
                                        <?php
                                    } else if ($this->session->userdata('user_type') == 'admin' && $this->session->userdata('accessTo') != '') {
                                        ?>
                                        - <select name="branchname" id="branchname" onchange="innovation(this.value);">
                                            <option value="">--Select partner--</option>
                                            <?php foreach ($partnerS as $partner) { ?>
                                                <option value="<?php echo $partner['id']; ?>" <?php echo ($partner['id'] == $branch_n ? 'selected' : ''); ?>>
                                                    <?php echo $partner['branch_name']; ?> </option>
                                                <?php } ?>
                                            </select>
                                        <?php } else { ?>
                                            <input type="hidden" name="branchname" id="branchname" value=<?php echo $this->session->userdata['partner_id']; ?>>
                                        <?php } ?>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xl-7 col-lg-7 col-md-6 col-sm-6 col-12 text-right">
                                <div class="form-group">
                                    <ul>
                                        <?php
                                        $allowed_partner = array("1", "9");
                                        ?>
                                        <?php if (in_array($this->session->userdata['partner_id'], $allowed_partner)) { ?>
                                            <li><a href="<?= base_url() . 'index.php/scouting/new_innovation'; ?>" class="btn btn-success"><i class="fas fa-plus-circle"></i>&nbsp;Add Deal</a></li>
                                        <?php } ?>
                                        <li><a href="addportfolio" class="btn btn-success"><i class="fas fa-plus-circle"></i>&nbsp;Add to Portfolio</a></li>
                                        <?php
                                        if (($this->session->userdata('user_type') == 'admin' && $this->session->userdata('partner_id') == $branch_n) || $this->session->userdata('user_type') == 'superadmin') {
                                            ?>
                                            <li><a href="javascript:void(0)" id="assign_incharge"  class="btn btn-success"><i class="fas fa-user-tie"></i>
                                                Assign Incharge</a></li> <?php } ?>
                                                <li>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-search"></i>  Search
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" id='showSearch' onclick="showsearch();">Show Search</a>
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#globalModal">Global Search</a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-upload"></i> Export
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" id="Export_link" href="#">Export Summary</a>
                                                            <a class="dropdown-item" id="Export_link_all" href="#">Export Applications</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inner Dashboard-->
                    <div class="vi-dashboard newdealbody">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="Diagnostic-graph">
                                        <div id="accordion" class="vil-Deals table-responsive portfolio-table">
                                            <?php if ($this->session->userdata('user_type') != 'superadmin') { ?>
                                                <div class="onlyDeals">
                                                    <input type="checkbox" <?= $deals_check; ?> id="loadDeals" style="margin:5px;vertical-align:top">Show my deals only
                                                </div>
                                            <?php } ?>
                                            <table id="table1" class="gtable sortable">
                                                <thead>
                                                    <tr>
                                                        <?php if ($currentTab == 'lead') { ?>
                                                            <th><input type="checkbox" class="checkall" /></th>
                                                        <?php } ?>
                                                        <?php if (($this->session->userdata('user_type') == 'admin' && $this->session->userdata('partner_id') == $name)) { ?>
                                                            <th width="2%">Select</th>
                                                        <?php } else if ($this->session->userdata('user_type') == 'superadmin') { ?>
                                                            <th>Select</th>
                                                        <?php } ?>
                                                        <th nowrap="nowrap">INV ID</th>
                                                        <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
                                                            <th nowrap="nowrap">Partner</th>
                                                        <?php } ?>
                                                        <th nowrap="nowrap">Enterprise</th>
                                                        <th nowrap="nowrap">Entrepreneur</th>
                                                        <th>Source Type</th>
                                                        <th>Sector</th>
                                                        <th>Program</th>
                                                        <th>Stage</th>
                                                        <th>Status</th>
                                                        <th nowrap="nowrap">Registered Date</th>
                                                        <th>City</th>
                                                        <th nowrap="nowrap">Applied to Partners</th>
                                                        <th nowrap="nowrap">Assign in-Charge</th>
                                                        <th nowrap="nowrap">Email</th>
                                                        <th nowrap="nowrap">Phone Number</th>
                                                        <th nowrap="nowrap">Submitted Date</th>
                                                        <?php if (($this->session->userdata('user_type') == 'admin' && $this->session->userdata('partner_id') == $branch_n) || $this->session->userdata('user_type') == 'superadmin') { ?>
                                                            <th>Delete</th>
                                                        <?php } ?>
                                                        <th align="left"></th>
                                                        <?php if (($this->session->userdata('partner_id') == $branch_n) || $this->session->userdata('user_type') == 'superadmin') { ?>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <!--<center>Processing...</center>-->
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="pull-right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--export forms-->

                    <form name="export" id="export" action="<?= site_url('portfolio/' . $tab_name); ?>" method="post">
                        <input type="hidden" name="ordertype" value="<?= $ordertype ?>" />
                        <input type="hidden" name="orderby" value="<?= $orderby ?>" />
                        <input type="hidden" name="branch_id" value="<?php echo $name; ?>" />
                        <input type="hidden" name="branch_name" value="<?= $branch_name ?>" />
                        <input type="hidden" name="copy_id" value="<?= $copy_id ?>" />
                        <input type="hidden" name="name_of_enterprise" value="<?= $name_of_enterprise ?>" />
                        <input type="hidden" name="name_of_entrepreneur" value="<?= $name_of_entrepreneur ?>" />
                        <input type="hidden" name="source_type" value="<?= $source_type ?>" />
                        <input type="hidden" name="source" value="<?= $source ?>" />
                        <input type="hidden" name="sector" value="<?= $sector ?>" />
                        <input type="hidden" name="program" value="<?= $program ?>" />
                        <input type="hidden" name="stage" value="<?= $stage_post ?>" />
                        <input type="hidden" name="status" value="<?= $status_post ?>" />
                        <input type="hidden" name="created_date" value="<?= $created_date ?>" />
                        <input type="hidden" name="created_date_to" value="<?= $created_date_to ?>" />
                        <input type="hidden" name="submitted_date" value="<?= $submitted_date ?>" />
                        <input type="hidden" name="submitted_date_to" value="<?= $submitted_date_to ?>" />
                        <input type="hidden" name="geography" value="<?= $geography ?>" />
                        <input type="hidden" name="city" value="<?= $city ?>" />
                        <input type="hidden" name="lis" value="<?= $lis ?>" />
                        <input type="hidden" name="donor_fit" value="<?= $donors ?>" />
                        <input type="hidden" name="export_serch" value="1" />
                        <input type="hidden" name="assigned_incharge" value="<?= $assigned_incharge ?>" />
                        <input type="hidden" name="email" value="<?= $email ?>" />
                        <input type="hidden" name="mobile" value="<?= $mobile ?>" />
                        <input type="hidden" id="eincomplete" name="incomplete" value="<?= $incomplete_val ?>" />
                        <input type="hidden" id="eregister" name="register" value="<?= $register_val ?>" />
                        <input type="hidden" id="edeleted" name="deleted" value="<?= $deleted_val ?>" />
                        <input type="hidden" name="txtExport" value="1" />
                    </form>

                    <form name="export_all" id="export_all" action="<?= site_url('portfolio/' . $tab_name); ?>"
                      method="post">
                      <input type="hidden" name="ordertype" value="<?= $ordertype ?>" />
                      <input type="hidden" name="orderby" value="<?= $orderby ?>" />
                      <input type="hidden" name="branch_id" value="<?php echo $name; ?>" />
                      <input type="hidden" name="branch_name" value="<?= $branch_name ?>" />
                      <input type="hidden" name="copy_id" value="<?= $copy_id ?>" />
                      <input type="hidden" name="name_of_enterprise" value="<?= $name_of_enterprise ?>" />
                      <input type="hidden" name="name_of_entrepreneur" value="<?= $name_of_entrepreneur ?>" />
                      <input type="hidden" name="source_type" value="<?= $source_type ?>" />
                      <input type="hidden" name="source" value="<?= $source ?>" />
                      <input type="hidden" name="sector" value="<?= $sector ?>" />
                      <input type="hidden" name="program" value="<?= $program ?>" />
                      <input type="hidden" name="stage" value="<?= $stage_post ?>" />
                      <input type="hidden" name="status" value="<?= $status_post ?>" />
                      <input type="hidden" name="created_date" value="<?= $created_date ?>" />
                      <input type="hidden" name="created_date_to" value="<?= $created_date_to ?>" />
                      <input type="hidden" name="submitted_date" value="<?= $submitted_date ?>" />
                      <input type="hidden" name="submitted_date_to" value="<?= $submitted_date_to ?>" />
                      <input type="hidden" name="geography" value="<?= $geography ?>" />
                      <input type="hidden" name="city" value="<?= $city ?>" />
                      <input type="hidden" name="lis" value="<?= $lis ?>" />
                      <input type="hidden" name="donor_fit" value="<?= $donors ?>" />
                      <input type="hidden" name="export_serch" value="1" />
                      <input type="hidden" name="assigned_incharge" value="<?= $assigned_incharge ?>" />
                      <input type="hidden" name="email" value="<?= $email ?>" />
                      <input type="hidden" name="mobile" value="<?= $mobile ?>" />
                      <input type="hidden" id="exincomplete" name="incomplete" value="<?= $incomplete_val ?>" />
                      <input type="hidden" id="exregister" name="register" value="<?= $register_val ?>" />
                      <input type="hidden" id="exdeleted" name="deleted" value="<?= $deleted_val ?>" />
                      <input type="hidden" name="txtExport_all" value="1" />
                  </form>
                  <!--end export forms-->

                  <div class="modal fade newdealmodal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <form id="<?= $form_name; ?>" action="<?= site_url('portfolio/' . $tab_name) ?>" method="post" name="<?= $form_name; ?>" class="searchForm" autocomplete="off">
                                <input type="hidden" name="ordertype" value="<?= $ordertype ?>" id="ordertype" />
                                <input type="hidden" name="orderby" value="<?= $orderby ?>" id="orderby" />
                                <input type="hidden" name="export" value="" />
                                <input type="hidden" name="branch_name" id="branch_name" value="<?= $branch_name ?>" />
                                <input type="hidden" name="branch" id="branch" value="<?php echo $name; ?>" />
                                <input type="hidden" name="app_draft" id="app_draft" value="" />
                                <input type="hidden" name="app_regist" id="app_regist" value="" />
                                <input type="hidden" name="app_delet" id="app_delet" value="" />
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Innovation Pool - All Innovations -
                                        <?php
                                        foreach ($branch as $partner) {
                                            if ($partner['id'] == $name) {
                                                echo $partner['branch_name'];
                                            }
                                        }
                                        ?>  From Partner</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <table class="tableresponsive">
                                                    <tbody>
                                                        <tr>
                                                            <td width="40%" class="text-right"><label>Innovation Id</label></td>
                                                            <td width="60%" class="pad-lt15px">
                                                                <div class="form-group">
                                                                    <input type="text" name="copy_id" value="<?= $copy_id ?>" class="form-control form-control-sm" id="copy_id" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="40%" class="text-right"><label>Enterprise</label></td>
                                                            <td width="60%" class="pad-lt15px">
                                                                <div class="form-group">
                                                                    <input type="text" value="<?= $name_of_enterprise ?>" name="name_of_enterprise" id="name_of_enterprise"
                                                                    class="form-control form-control-sm" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="40%" class="text-right"><label>Entrepreneur</label></td>
                                                            <td width="60%" class="pad-lt15px">
                                                                <div class="form-group">
                                                                    <input type="text" value="<?= $name_of_entrepreneur; ?>" name="name_of_entrepreneur"
                                                                    id="name_of_entrepreneur" class="form-control form-control-sm" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="40%" class="text-right"><label>Source Type</label></td>
                                                            <td width="60%" class="pad-lt15px">
                                                                <div class="form-group">
                                                                    <select class="form-control form-control-sm" name="source_type" id="source_type">
                                                                        <option value="">-Select-</option>
                                                                        <option value="0" <?php echo ($source_type == '0') ? 'selected' : ''; ?>>Website</option>
                                                                        <option value="1" <?php echo ($source_type == '1') ? 'selected' : ''; ?>>User Added</option>
                                                                        <!--<option value="2" <?php echo ($source_type == '2') ? 'selected' : ''; ?>>F6S</option>-->
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="40%" class="text-right"><label>Sector</label></td>
                                                            <td width="60%" class="pad-lt15px">
                                                                <div class="form-group" id="sectordiv">
                                                                    <select class="form-control form-control-sm" name="sector" id="sectorList">
                                                                        <option value="">-Select-</option>
                                                                        <?php foreach ($getSectorList as $key => $value) { ?>
                                                                            <option value="<?php echo $key; ?>" <?php echo ($sector == $key) ? 'selected' : ''; ?>><?php echo $value; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="40%" class="text-right"><label>Program</label></td>
                                                            <td width="60%" class="pad-lt15px">
                                                                <div class="form-group">
                                                                    <select class="form-control form-control-sm" name="program" id="program">
                                                                        <option value="">-Select-</option>
                                                                        <option value="1" <?= ($program == '1') ? 'selected' : ''; ?>>EIR</option>
                                                                        <option value="0" <?= ($program == '0' || $program == '4') ? 'selected' : ''; ?>>Incubation</option>
                                                                        <option value="2" <?= ($program == '2') ? 'selected' : ''; ?>>SEED</option>
                                                                        <option value="3" <?= ($program == '3') ? 'selected' : ''; ?>>Unc Pitch</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="40%" class="text-right"><label>Stage</label></td>
                                                            <td width="60%" class="pad-lt15px">
                                                                <div class="form-group">
                                                                    <select class="form-control form-control-sm" name="stage" id="stage">
                                                                        <option value="">-Select-</option>
                                                                        <?php
                                                                        foreach ($stage as $key => $value):
                                                                            ?><option value="<?= $key ?>" <?= ((string) $key == $stage_post) ? 'selected' : ''; ?>><?= $value ?></option>
                                                                            <?php
                                                                        endforeach;
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <table class="tableresponsive">
                                                    <tbody>
                                                        <tr>
                                                            <td width="40%" class="text-right"><label>Status</label></td>
                                                            <td width="60%" class="pad-lt15px">
                                                                <div class="form-group">
                                                                    <select class="form-control form-control-sm" name="status[]" id="status" multiple="multiple">
                                                                        <option value="">-Select-</option>
                                                                        <?php
                                                                        foreach ($status as $key => $value):
                                                                            if ($key != 21 && $key != 22) {
                                                                                ?>
                                                                                <option value="<?= $key ?>"
                                                                                    <?php
                                                                                    if (in_array($key, $status_array_post)) {
                                                                                        echo 'selected';
                                                                                    }
                                                                                    ?>>
                                                                                    <?= $value ?>
                                                                                </option>
                                                                                <?php
                                                                            }
                                                                        endforeach;
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="40%" class="text-right"><label>Date Registered</label></td>
                                                            <td width="60%" class="pad-lt15px">
                                                                <div class="form-group">
                                                                    <input type="text" name="created_date" value="<?= $created_date ?>" class="startDat form-control form-control-sm dateCalendar modified-datepicker" onclick="datepickerRegistered();" onchange="emptyRegEndDate();" id="fromdate" />&nbsp;-&nbsp;
                                                                    <input type="text" name="created_date_to" value="<?= $created_date_to ?>" class="endDat form-control form-control-sm dateCalendar modified-datepicker" onclick="datepickerRegistered();" id="todate" />
                                                                    <input type="hidden" name="dealsearch" value="1" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="40%" class="text-right"><label>Date Submitted</label></td>
                                                            <td width="60%" class="pad-lt15px">
                                                                <div class="form-group">
                                                                    <?php
                                                                    $currentdate = date("d/m/Y");
                                                                    $year = (date("Y") - 1);
                                                                    $preyear = date('d/m') . "/" . $year;
                                                                    ?>
                                                                    <input type="text" name="submitted_date" value="<?= $submitted_date ?>" class="submitStartDat form-control form-control-sm dateCalendar" onclick="datepickerSubmitted();emptySubEndDate();" id="submitteddate" />&nbsp;-&nbsp;
                                                                    <input type="text" name="submitted_date_to" value="<?= $submitted_date_to ?>" class="submitEndDat form-control form-control-sm dateCalendar" onclick="datepickerSubmitted();" id="submitted_date_to" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="40%" class="text-right"><label>Geography</label></td>
                                                            <td width="60%" class="pad-lt15px">
                                                                <div class="form-group">
                                                                    <input type="text" name="geography" value="<?= $geography ?>" class="form-control form-control-sm" id="geography" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                                <table class="tableresponsive">
                                                    <tbody>
                                                        <tr>
                                                            <td width="40%" class="text-right"><label>City</label></td>
                                                            <td width="60%" class="pad-lt15px">
                                                                <div class="form-group">
                                                                    <input type="text" name="city" value="<?= $city ?>" class="form-control form-control-sm" id="city" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="40%" class="text-right"><label>LIS</label></td>
                                                            <td width="60%" class="pad-lt15px">
                                                                <div class="form-group">
                                                                    <select class="form-control form-control-sm" name="lis" id="lis">
                                                                        <option value="">-Select-</option>
                                                                        <option value="1" <?php echo ($lis == '1') ? 'selected' : ''; ?>>Yes</option>
                                                                        <option value="0" <?php echo ($lis == '0') ? 'selected' : ''; ?>>No</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="40%" class="text-right"><label>Donor Fit</label></td>
                                                            <td width="60%" class="pad-lt15px">
                                                                <div class="form-group">
                                                                    <select class="form-control form-control-sm" name="donor_fit" id="donor_fit">
                                                                        <option value="">-Select-</option>
                                                                        <?php
                                                                        foreach ($donor_fit as $donor) {
                                                                            ?>
                                                                            <option value="<?php echo $donor['id']; ?>" <?= ($donor['id'] == $donors) ? 'selected' : ''; ?>>
                                                                                <?php echo $donor['name']; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="40%" class="text-right"><label>Assigned Incharge</label></td>
                                                                <td width="60%" class="pad-lt15px">
                                                                    <div class="form-group">
                                                                        <select class="form-control form-control-sm" id="assigned_incharge" data-placeholder="Select Employee" name="assigned_incharge">
                                                                            <option value="">Select</option>
                                                                            <?php
                                                                            foreach ($usersList as $row) {
                                                                                ?>
                                                                                <option value="<?= $row['emp_number'] ?>"
                                                                                    <?= (isset($_REQUEST['assigned_incharge']) && $_REQUEST['assigned_incharge'] == $row['emp_number']) ? 'selected' : ''; ?>>
                                                                                    <?= $row['emp_name'] ?></option>
                                                                                <?php }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td width="40%" class="text-right"><label>Email-Id</label></td>
                                                                    <td width="60%" class="pad-lt15px">
                                                                        <div class="form-group">
                                                                            <input type="text" name="email" value="<?= $email ?>" class="form-control form-control-sm" id="email" />
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="40%" class="text-right"><label>Phone no</label></td>
                                                                    <td width="60%" class="pad-lt15px">
                                                                        <div class="form-group">
                                                                            <input type="text" name="mobile" value="<?= $mobile ?>" class="form-control form-control-sm" id="mobile" />
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="reset" id="txtReset" class="button white btn btn-success" onclick="setTimeout(function () {
                                                    window.location = '<?php echo $_SERVER["PHP_SELF"] ?>'
                                                }, 500)" >Reset</button>
                                                <button type="submit" class="btn btn-success" value="Search" id="txtSubmit" name="txtSubmit">Deals Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade newdealmodal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <form name="otherPartners" id="otherPartners" action="" autocomplete="off" method="post">
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="exampleModalLabel">Innovation Pool - All Innovations - GlobalSearch</h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h6>Search Across Partners</h6>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="tableresponsive">
                                                        <tbody>
                                                            <tr>
                                                                <td width="40%" class="text-right">Name of the Enterprise</td>
                                                                <td width="60%" class="pad-lt15px">
                                                                    <div class="form-group">
                                                                        <?php $partners_entreprise = isset($_REQUEST["partners_enterprise"]) ? $_REQUEST["partners_enterprise"] : ''; ?>
                                                                        <input type="text" value="<?= $partners_entreprise; ?>" name="partners_enterprise"
                                                                        id="partners_enterprise" class="form-control form-control-sm" style="width: 250px !important;" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="40%" class="text-right">Name of the Entrepreneur</td>
                                                                <td width="60%" class="pad-lt15px">
                                                                    <div class="form-group">
                                                                        <?php $partners_entrepreneur = isset($_REQUEST["partners_entrepreneur"]) ? $_REQUEST["partners_entrepreneur"] : ''; ?>
                                                                        <input type="text" value="<?= $partners_entrepreneur; ?>" name="partners_entrepreneur"
                                                                        id="partners_entrepreneur" class="form-control form-control-sm"style="width: 250px !important;" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="40%" class="text-right">Email ID</td>
                                                                <td width="60%" class="pad-lt15px">
                                                                    <div class="form-group">
                                                                        <?php $partnersemail = isset($_REQUEST['partners_email']) ? $_REQUEST['partners_email'] : ''; ?>
                                                                        <input type="text" name="partners_email" value="<?= $partnersemail; ?>" class="form-control form-control-sm"
                                                                        style="width: 250px !important;" id="partners_email" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="reset" class="btn btn-success" onclick='rmvPartners();'>Reset</button>
                                                <button type="button" class="btn btn-success" value="Search" id="partnerSubmit" name="partnerSubmit">Search Across Partners</button>
                                            </div>
                                        </form>
                                        <div class="modal-body">
                                            <div class="global_result" id="ajax_load_partners"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade newdealmodal" id="form_employeelist" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form action="<?php echo site_url('portfolio/assign_multi_incharge'); ?>" id="assign" method="post">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <?php
                                                $associate_employee = isset($_REQUEST["associate_employee"]) ? $_REQUEST["associate_employee"] : array();

                                                if ($_POST['branch_name'] != '') {
                                                    $userSetup1 = $this->Mmaster->getUserSetup_branch($_POST['branch_name']);
                                                    if ($userSetup1['abi'] != '') {
                                                        $usersList_incharge = $this->Muser->getUsersList($userSetup1['abi']);
                                                    }
                                                    ?>
                                                    <select id="associate_employee" data-placeholder="Select Employee" multiple class=""
                                                    style="width:350px;height:330px;" tabindex="1" name="associate_employee[]">

                                                    <?php
                                                    foreach ($usersList_incharge as $row) {
                                                        ?>
                                                        <option value="<?= $row['emp_number'] ?>"><?= $row['emp_name'] ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            <?php } else { ?>
                                                <select id="associate_employee" data-placeholder="Select Employee" multiple class=""
                                                style="width:350px;height:330px;" tabindex="1" name="associate_employee[]">
                                                <?php
                                                foreach ($usersList as $row) {
                                                    ?>
                                                    <option value="<?= $row['emp_number'] ?>"><?= $row['emp_name'] ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        <?php } ?>
                                        <input type="hidden" name="innovations" id="innovation_id" />
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" name="txtSubmit" class="btn btn-success" value="Submit" id="txtsub" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade newdealmodal" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="<?php echo site_url('portfolio/copy_innovation'); ?>" id="assignpartner" method="post">
                                    <div class="modal-header">
                                        <h6 class="modal-title text-center" id="exampleModalLabel">Copy</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" value="" name="newpartner" id="newpartner">
                                        <table class="tableresponsive">
                                            <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
                                                <tr>
                                                    <td><label for="program"> To Partner</label></td>
                                                    <td><select  class="form-control form-control-sm" name="branchname1" id="branchname1">
                                                        <?php foreach ($branch as $partner) { ?>
                                                            <option value="<?php echo $partner['id']; ?>"
                                                                <?php echo ($partner['id'] == $_POST['branch_name'] ? 'selected' : ''); ?>>
                                                                <?php echo $partner['branch_name']; ?> </option>
                                                            <?php } ?>
                                                        </select></td>
                                                    </tr>
                                                    <?php
                                                } else if (($this->session->userdata('user_type') == 'employee' || $this->session->userdata('user_type') == 'ceo' || $this->session->userdata('user_type') == 'cio' || $this->session->userdata('user_type') == 'abi' || $this->session->userdata('user_type') == 'icm')) {
                                                    ?>
                                                    <tr>
                                                        <td><label for="program"> To Partner </label></td>
                                                        <td><select class="form-control form-control-sm" name="branchname1" id="branchname1">
                                                            <option value="">--Select Partner--</option>
                                                            <?php foreach ($partnerList as $partner) { ?>
                                                                <option value="<?php echo $partner['id']; ?>"
                                                                    <?php echo ($partner['id'] == $_POST['branch_name'] ? 'selected' : ''); ?>>
                                                                    <?php echo $partner['branch_name']; ?> </option>
                                                                <?php } ?>
                                                            </select></td>
                                                        </tr>
                                                        <?php
                                                    } else if ($this->session->userdata('user_type') == 'admin') {
                                                        ?>
                                                        <tr>
                                                            <td><label for="program"> To Partner </label></td>
                                                            <td><select class="form-control form-control-sm" name="branchname1" id="branchname1">
                                                                <option value="">--Select partner--</option>
                                                                <?php foreach ($partnerList as $partner) { ?>
                                                                    <option value="<?php echo $partner['id']; ?>"
                                                                        <?php echo ($partner['id'] == $_POST['branch_name'] ? 'selected' : ''); ?>>
                                                                        <?php echo $partner['branch_name']; ?> </option>
                                                                    <?php } ?>
                                                                </select></td>
                                                            </tr>
                                                        <?php } ?>
                                                        <br>
                                                        <tr>
                                                            <td class="pad-tp12"><label for="program">Comment</label></td>
                                                            <td class="pad-tp12"><textarea class="form-control form-control-sm" name='comment'></textarea></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" name="invSubmit1" class="btn btn-success" id="txtsubc" value="Submit" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal" id="welcomeModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
                                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body onboarding-permission text-center">
                                                <div class="text-right">
                                                    <a class="portfolioclose" data-dismiss="modal">Close</a>
                                                </div>
                                                <div class="popup-content">
                                                    <p>Do you want to download attached documents as well?</p>
                                                    <button type="button" class="btn btn-secondary" onclick="attachedfileNo();" data-dismiss="modal">No</button>
                                                    <button type="button" class="btn btn-secondary" onclick="attachedfileYes();" data-dismiss="modal">Yes</button>
                                                    <input type="hidden" value="" id="download_id">
                                                    <input type="hidden" value="" id="program_id">
                                                    <input type="hidden" value="" id="doc1_id">
                                                    <input type="hidden" value="" id="doc2_id">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                                <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>"></script>
                                <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
                                <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
                                <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
                                <script src="<?php echo base_url(); ?>source/chosen/chosen.jquery.js" type="text/javascript"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

                                <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
                                <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
                                <script src="<?php echo base_url() . 'source/portfolio_assets/js/additional-methods.js'; ?>"></script>
                                <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>

                                <script type="text/javascript">
                                    $("#draft_hint").hover(function () {
                                        $('#draft').show();
                                    }, function () {
                                        $('#draft').hide();
                                    });
                                //     jQuery( document ).ready(function( $ ) {
                                //     $("#draft_hint").mouseover(function () {
                                //         $("#draft").dialog({
                                //             modal: true,
                                //             width: 460,
                                //             maxWidth: 500,
                                //             resizable: false,
                                //             dialogClass: "dialogaddSeasons"
                                //         });
                                //     });
                                // });

                                $(document).ready(function () {
                                    $('#status').multiselect();
                                    datepickerRegistered();
                                    datepickerSubmitted();
                                });

                                function emptyRegEndDate() {
                                    $(".endDat").val('');
                                }

                                function emptySubEndDate() {
                                    $(".submitEndDat").val('');
                                }

                                function datepickerRegistered() {
                                    $('.startDat, .endDat').datepicker({dateFormat: 'dd/mm/yy'});
                                    $(".startDat").datepicker({
                                        onSelect: function (selected) {
                                            $(".startDat").datepicker("option", "dateFormat", 'dd/mm/yy');
                                            $(".endDat").val('');
                                            var dt = new Date(selected);
                                            var dateval = dt.getDate();
                                            var monthval = dt.getMonth() + 1;
                                            var yearval = dt.getFullYear();
                                            if (monthval < 10) {
                                                monthval = "0" + monthval;
                                            } else {
                                                monthval = monthval;
                                            }
                                            if (dateval < 10) {
                                                dateval = "0" + dateval;
                                            } else {
                                                dateval = dateval;
                                            }
                                            var fulldatevalue = dateval + '/' + monthval + '/' + yearval;
                                            $(".startDat").val(fulldatevalue);
                                            dt.setDate(dt.getDate() + 1);
                                            $(".endDat").datepicker("option", {minDate: dt});
                                        }
                                    });

                                    $(".endDat").datepicker({
                                        onSelect: function (selected) {
                                            var dt = new Date(selected);
                                            var dateval = dt.getDate();
                                            var monthval = dt.getMonth() + 1;
                                            var yearval = dt.getFullYear();
                                            if (monthval < 10) {
                                                monthval = "0" + monthval;
                                            } else {
                                                monthval = monthval;
                                            }
                                            if (dateval < 10) {
                                                dateval = "0" + dateval;
                                            } else {
                                                dateval = dateval;
                                            }
                                            var fulldatevalue = dateval + '/' + monthval + '/' + yearval;
                                            $(".endDat").val(fulldatevalue);
                                            dt.setDate(dt.getDate() - 1);
                                        }
                                    });
                                }

                                function datepickerSubmitted() {
                                    $('.submitStartDat, .submitEndDat').datepicker({dateFormat: 'dd/mm/yy'});
                                    $(".submitStartDat").datepicker({
                                        onSelect: function (selected) {
                                            $(".submitStartDat").datepicker("option", "dateFormat", 'dd/mm/yy');
                                            $(".submitEndDat").val('');
                                            var dt = new Date(selected);
                                            var dateval = dt.getDate();
                                            var monthval = dt.getMonth() + 1;
                                            var yearval = dt.getFullYear();
                                            if (monthval < 10) {
                                                monthval = "0" + monthval;
                                            } else {
                                                monthval = monthval;
                                            }
                                            if (dateval < 10) {
                                                dateval = "0" + dateval;
                                            } else {
                                                dateval = dateval;
                                            }

                                            var fulldatevalue = dateval + '/' + monthval + '/' + yearval;
                                            $(".submitStartDat").val(fulldatevalue);
                                            dt.setDate(dt.getDate() + 1);
                                            $(".submitEndDat").datepicker("option", {minDate: dt});
                                        }
                                    });

                                    $(".submitEndDat").datepicker({
                                        onSelect: function (selected) {
                                            var dt = new Date(selected);
                                            var dateval = dt.getDate();
                                            var monthval = dt.getMonth() + 1;
                                            var yearval = dt.getFullYear();
                                            if (monthval < 10) {
                                                monthval = "0" + monthval;
                                            } else {
                                                monthval = monthval;
                                            }
                                            if (dateval < 10) {
                                                dateval = "0" + dateval;
                                            } else {
                                                dateval = dateval;
                                            }
                                            var fulldatevalue = dateval + '/' + monthval + '/' + yearval;
                                            $(".submitEndDat").val(fulldatevalue);
                                            dt.setDate(dt.getDate() - 1);
                                        }
                                    });
                                }

                                $('#loadDeals').click(function () {
                                    if ($("#loadDeals").is(':checked')) {
                                        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/mydeals';
                                    } else {
                                        window.location.href = '<?= base_url(); ?>' + 'index.php/portfolio/alldeals';
                                    }
                                });
                            </script>

                            <script type="text/javascript">
                                function innovation(id) {
                                    $("#branch_name").val(id);
                                    $("#txtSubmit").click();
                                }

                                function showsearch() {
                                    $('#exampleModal').modal('show');
                                }

                                function Partner() {
                                    var vals = "<?php echo $this->session->userdata('accessTo'); ?>";
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo base_url(); ?>index.php/portfolio/getPartner",
                                        data: {
                                            id: vals
                                        },
                                        dataType: 'json',
                                        success: function (msg) {
                                            var arr = msg;
                                            $("#openModal").modal('show');

                                        },
                                    });
                                }

                            </script>

                            <script type="text/javascript">
                                $(document).ready(function () {
                                    loadInnovationList();

                                    $("#source_type").change(function () {
                                        var form_data = {
                                            source_type: $(this).val(),
                                            ajax: '4'
                                        };
                                        $.ajax({
                                            url: '<?php echo site_url("master/source/get_source_combo"); ?>',
                                            type: 'POST',
                                            data: form_data,
                                            success: function (msg) {
                                                $('#source').html(msg);
                                                <?php if (isset($_REQUEST['source']) && $_REQUEST['source'] != '') { ?>
                                                    $("#source option[value='<?php echo $_REQUEST['source']; ?>']").attr(
                                                        "selected", "selected");
                                                <?php } ?>
                                            }
                                        });
                                    });

                                    if ($("#source_type").val() != '') {
                                        $("#source_type").change();
                                    }

                                    $("#source").click(function () {
                                        if ($("#source_type").val() == '') {
                                            alert("Select Source type to select source");
                                        }
                                    });

                                    $(document).on('click', '#assign_incharge', function () {
                                        var val = [];
                                        $('.chk_box:checkbox:checked').each(function (i) {
                                            val[i] = $(this).val();
                                        });
                                        if ($('.chk_box:checkbox:checked').length > 0) {
                                            $('#form_employeelist').modal('show');
                                            $('#associate_employee').val('');
                                            Populate();
                                        } else {
                                            alert('Please select atleast one');
                                        }
                                    });

                                    $('#txtsub').click(function () {
                                        var ids = $('#innovation_id').val();
                                        if (ids == '') {
                                            alert('Please select atleast one deal!');
                                            return false;
                                        }

                                    });

                                    function Populate() {
                                        var vals = $('.chk_box:checkbox:checked').map(function () {
                                            return this.value;
                                        }).get().join(',');
                                        var myresult = vals.split(',');
                                        if (myresult != "")
                                            var count = myresult.length;
                                        else
                                            var count = 0;
                                        if (count == 1) {
                                            $.ajax({
                                                type: "POST",
                                                url: "<?php echo base_url(); ?>index.php/portfolio/getassemployee",
                                                data: {
                                                    id: vals
                                                },
                                                dataType: 'json',
                                                success: function (msg) {
                                                    var arr = msg;
                                                    for (var prop in arr) {
                                                        $('#associate_employee option').map(function () {
                                                            if (arr[prop]['associate_employee'] == $(this).val()) {
                                                                $(this).prop("selected", 'selected');
                                                            }
                                                        });
                                                    }
                                                },
                                            });
                                        } else {
                                            $('#associate_employee option').map(function () {
                                                $(this).attr("selected", false);
                                            });
                                        }
                                        $('#innovation_id').val(vals);
                                    }
                                    $(".chk_box").trigger("liszt:updated");
                                    $('input[type="checkbox"]').on('click', function () {
                                    }).change();
                                });

function loadInnovationList() {
    var load_items = "<?php echo $load_count; ?>";
    var table_view, url;
    <?php
    if (isset($url_post)) {
        ?>
        url = "<?php echo base_url(); ?>index.php/portfolio/getInnovationList/<?php echo $currentTab; ?>/" +
        <?php echo $url_post; ?>;
        <?php
    } else {
        ?>
        url = "<?php echo base_url(); ?>index.php/portfolio/getInnovationList/<?php echo $currentTab; ?>";
        <?php
    }
    ?>

    <?php if (($this->session->userdata('user_type') == 'admin' && $this->session->userdata('partner_id') == $name)) { ?>

        table_view = [
        {className: 'none', "targets": 4},
        {className: 'none', "targets": 9},
        {className: 'none', "targets": 10},
        {className: 'none', "targets": 12},
        {className: 'none', "targets": 13},
        {className: 'none', "targets": 14},
        {
            className: 'control',
            orderable: false,
            targets: -1
        }];

    <?php } else if ($this->session->userdata('user_type') == 'superadmin') { ?>

        table_view = [
        {className: 'none', "targets": 5},
        {className: 'none', "targets": 10},
        {className: 'none', "targets": 11},
        {className: 'none', "targets": 13},
        {className: 'none', "targets": 14},
        {className: 'none', "targets": 15},
        {
            className: 'control',
            orderable: false,
            targets: -1
        }];

    <?php } else { ?>

        table_view = [
        {className: 'none', "targets": 3},
        {className: 'none', "targets": 8},
        {className: 'none', "targets": 9},
        {className: 'none', "targets": 11},
        {className: 'none', "targets": 12},
        {className: 'none', "targets": 13},
        {
            className: 'control',
            orderable: false,
            targets: -1
        }];

    <?php } ?>
    var oTable = $('#table1').dataTable({
        "bDestroy": true,
        "iDisplayLength": load_items,
        "aLengthMenu": [
        [10, 15, 25, 50, -1],
        [10, 15, 25, 50, "All"]
        ],
        'bFilter': false,
        "oTableTools": {
            "sSwfPath": "<?php echo base_url() . "DataTables-1.9.4/media/swf/copy_csv_xls_pdf.swf"; ?>",
            "aButtons": [{
                "sExtends": "print",
            }, ]

        },
        "sDom": '<"clear"><"H"lfr>t<"F"ip>',
        "bServerSide": true,
        "bProcessing": true,
        "bStateSave": false,
        "bSort": false,
        responsive: {
            details: {
                type: 'column',
                target: -1
            }
        },
        columnDefs: table_view,
        "sAjaxSource": url,
        "fnServerData": function (sSource, aoData, fnCallback) {
            var filter_id = $('#storedFilter_id').val();
            aoData.push({
                "name": "filter_id",
                "value": $.trim(filter_id)
            });
            $.getJSON(sSource, aoData, function (json) {
                if (json == 'LoginError') {
                    var url = "<?php echo base_url(); ?>index.php";
                    window.location.href = "<?php echo base_url(); ?>index.php/login";
                } else {
                    fnCallback(json)
                }

            });
        },
        "fnDrawCallback": function (oSettings) {
                                // $(".confirmDelete").click(function () {
                                //     var linkUrl = $(this).attr('url');
                                //     var program = $(this).attr('program');

                                //     if (program == "SEED" || program == "EIR" || program == "Unc-Pitch") {
                                //         msg = "This is an application submitted via the website. Are you sure you want to delete it?";
                                //     } else {
                                //         msg = 'Are you sure you want to delete this deal?';
                                //     }

                                //     var con = confirm(msg);
                                //     if (con) {
                                //         var oSettings = oTable.fnSettings();
                                //         var start = oSettings._iDisplayStart;
                                //         oTable.fnDestroy();
                                //         DeleteInnovation(linkUrl, start);
                                //         oTable.fnDraw();
                                //     }
                                // });
                            },
                            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                                $('td', nRow).attr('nowrap', 'nowrap');
                                if (nRow.className == 'even') {
                                    oTable.$('tr:even').css('backgroundColor', '#FFFFFF');
                                    oTable.$('tr:even').each(function () {
                                        $(this).find("td:eq(0)").css({
                                            'background-color': '#FFFFFF'
                                        });
                                    });
                                }
                                return nRow;
                            }

                        });
}

$(document).on('click', ".confirmDelete", function () {
    var linkUrl = $(this).attr('url');
    var program = $(this).attr('program');

    if (program == "SEED" || program == "EIR" || program == "Unc-Pitch") {
        msg = "This is an application submitted via the website. Are you sure you want to delete it?";
    } else {
        msg = 'Are you sure you want to delete this deal?';
    }

    var con = confirm(msg);
    if (con) {
        DeleteInnovation(linkUrl);
    }
});

function DeleteInnovation(url) {
    $.ajax({
        type: "POST",
        url: url,
        dataType: 'text',
        success: function (msg) {
            if (msg == "successMsg") {
                loadInnovationList();
            }
        },
    });
}

function popitup(url) {
    newwindow = window.open(url, 'name', 'height=400,width=450');
    if (window.focus) {
        newwindow.focus()
    }
    return false;
}
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#txtsubc").click(function () {
            var partner = $("#branchname1").val();
            if (partner == '') {
                alert("please select partner");
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/portfolio/getPartnerName",
                    data: {
                        id: partner
                    },
                    dataType: 'json',
                    success: function (msg) {
                        var a = confirm(
                            'You are about to trigger an email to the applicant requesting for permission to send the application to ' +
                            msg +
                            '. Once the applicant approves the request, A copy of this incubation application form will be sent to ' +
                            msg + '. Do you want to continue');
                        if (a) {
                            $("#assignpartner").submit();
                        }
                    }
                });
                return false;
            }
        });

        var a = '<?php echo $this->session->userdata['partner_id'] ?>';
        var usr = '<?php echo $this->session->userdata["user_type"] ?>';
        if (usr == 'superadmin') {
            var b = $('#branch option:selected').text();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/PartnerId",
                data: {
                    branch_name: b
                },
                dataType: 'json',
                success: function (msg) {
                    var arr = msg;
                    $("#branchname1 option[value='" + arr + "']").remove();
                },
            });
        }
        if (usr != 'superadmin') {
            $("#branchname1 option[value='" + a + "']").remove();
        }
    });

    function modal_copy(id) {
        $("#newpartner").val(id);
        $("#openModal").modal('show');
    }

    $('#Export_link_all').click(function () {
        var program = $('#program').val();
        $.ajax({
            type: "POST",
            data: $('#export_all').serialize(),
            url: "<?php echo base_url(); ?>index.php/portfolio/innovation_pool_export_all",
            beforeSend: function () {
            },
            success: function (msg) {
                var arr = msg;
                if (arr == 'invalid' || program == '') {
                    alert(
                        "Data to be exported contains applications for multiple programmes. Use the search options to retrieve applications in one programme and then use this export option");
                } else {
                    $("#export_all").submit();
                }
            }
        });
    });

    $('#partnerSubmit').on('click', function (e) {
        var p_enterprise = $('#partners_enterprise').val();
        var p_enterpreneur = $('#partners_entrepreneur').val();
        var p_email = $('#partners_email').val();
        if (p_enterprise == '' && p_enterpreneur == '' && p_email == '') {
            $('#err_txt').html('Please specify a search criteria');
            setTimeout(function () {
                $('#err_txt').html('');
            }, 3000);
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/getPartnersList",
                data: {
                    enterprise: p_enterprise,
                    enterpreneur: p_enterpreneur,
                    email: p_email
                },
                dataType: 'html',
                success: function (result) {
                    $("#ajax_load_partners").html(result);
                },
            });
            $('#err_txt').html('');
        }
    });

    function rmvPartners() {
        $('#partnersTable').remove();
        $('#popup_export').hide();
    }

    $("#Export_link").on('click', function () {
        $('#export').submit();
    });

    function attachmentDownload(inv_id, program, doc1, doc2) {
        if (doc1 != '' || doc2 != '') {
            $('#welcomeModal').modal('show');
            $('#download_id').val(inv_id);
            $('#program_id').val(program);
            $('#doc1_id').val(doc1);
            $('#doc2_id').val(doc2);
        } else {
            $('#download_id').val(inv_id);
            attachedfileNo();
        }
    }

    function attachedfileNo() {
        var inv_id = $('#download_id').val();
        if (inv_id != '') {
            var url = "<?php echo base_url() . 'index.php/scouting/export_deals_pdf/'; ?>";
            window.location.href = url + inv_id;
        }
    }

    var interval;

    function attachedfileYes() {
        var inv_id = $('#download_id').val();
        var program = $('#program_id').val();
        var doc1 = $('#doc1_id').val();
        var doc2 = $('#doc2_id').val();

        var app_url, doc1_url, doc2_url;

        var host = "<?php echo host_url(); ?>";
        var base = "<?php echo base_url(); ?>";
        var app_url = base + 'index.php/scouting/export_deals_pdf/' + inv_id;

        if (program == 0) {
            if (doc1 != '') {
                doc1_url = host + 'IncubationForm/mis_download.php?file_name=' + doc1;
            }
            if (doc2 != '') {
                doc2_url = host + 'IncubationForm/mis_download.php?file_name=' + doc2;
            }
        } else if (program == 3) {
            if (doc1 != '') {
                doc1_url = host + 'pitchform/mis_download.php?file_name=' + doc1;
            }
            if (doc2 != '') {
                doc2_url = host + 'pitchform/mis_download.php?file_name=' + doc2;
            }
        } else if (program == 4) {
            if (doc1 != '') {
                doc1_url = host + 'poweringlivelihoods/mis_download.php?file_name=' + doc1;
            }
            if (doc2 != '') {
                doc2_url = host + 'poweringlivelihoods/mis_download.php?file_name=' + doc2;
            }
        }

        var urls = [app_url, doc1_url, doc2_url];
        urls = $.grep(urls, function (n) {
            return(n);
        });

        interval = setInterval(download, 300, urls);
    }

    function download(urls) {
        var url = urls.pop();
        if (url != null && url != undefined) {
                    // var a = document.createElement("a");
                    // a.setAttribute('href', url);
                    // a.setAttribute('download', '');
                    // a.click();

                    var link = document.createElement('a');
                    link.download = '';
                    link.href = url;
                    document.body.appendChild(link);
                    link.click();
                    link.remove();

                    if (urls.length == 0) {
                        clearInterval(interval);
                    }
                } else {
                    return false;
                }
            }

        </script>

        <style>
            a[aria-expanded="true"] {
                background: transparent !important;
                border-left: none !important;
            }
            .onlyDeals{
                position:absolute;
                right:20px;
                z-index:1;
                font-size: 14px;
            }
            #table1_length {
                font-size: 14px;
            }
            .newdealbody {
                margin-top: 195px;
            }
            select#branch, select#branchname {
                padding: 5px 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                background: #fff;
            }
            button.multiselect.dropdown-toggle.btn.btn-default {
                width: 100%;
                font-size: 13px;
                border: 1px solid #ccc;
                padding: 5px 0;
                overflow:hidden;
                padding: 5px 5px 5px 10px;
            }
            .pad-lt15px>.form-group>.btn-group{
                max-width: 190px;

                min-width: 190px;
            }
            .search-show input,.search-show select{
                max-width: 190px;
                overflow: hidden;
                min-width: 190px;
            }
            ul.multiselect-container.dropdown-menu.show {
                width: 105%;
                overflow: hidden;
                height: 320px;
                overflow-y: auto;
            }
            ul.multiselect-container.dropdown-menu.show li a{
                width:100%;
            }
            .multiselect-container>li>a>label{
                width:100%;
            }
            .multiselect-container>li:first-child{
                display:none;
            }
            .multiselect-container>li>a>label {
                margin: 0;
                height: 100%;
                cursor: pointer;
                font-weight: 400;
                padding: 4px 15px 4px 15px;
                font-size: 14px;
                color: #333;
            }
            .multiselect-container>li>a>label>input[type=checkbox]{
                min-width: 25px;
            }
            .downloadIcon img{
                width: 25px !important;
                height: 24px !important;
                margin-right: 18px;
            }
            .ui-corner-all, #ui-datepicker-div{
                position: absolute !important;

            }
            #exampleModal{
                top:95px !important;
            }
            .ui-datepicker table{
                margin: 30px 0 .4em;
            }
            .ui-datepicker .ui-datepicker-header{
                width: 97%;
            }
            .global_result a{
                color: #fff;
                background-color: #28a745;
                border-color: #28a745;
                text-align: right;
                display: inline-block;
                margin: 10px 15px 25px;
                float: right;
                padding: 5px 22px;
                border-radius: 4px;
            }
            .global_result table{
                margin: 20px 0px 0;
                overflow: scroll;
                width: 100% !important;
                display: block;
                max-width: 100%;
            }
            .global_result table td,th{
                padding: 5px;
            }
            .global_result table thead{
                background:#a9cf55;
            }
            .global_result table tbody tr:nth-child(even){
                background: #f0f9d9;
            }
        </style>

    </body>
    </html>