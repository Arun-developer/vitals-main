<?php
$split_empname = explode(' ', $this->session->userdata['emp_name']);
$first_name = array_shift($split_empname);
$partner_str = preg_replace('/\s+/', '', $this->session->userdata['partner_name']);
$gtag_user = $first_name . '_' . $partner_str . '_' . $this->session->userdata['emp_number'];
$allowed_partner = array("1", "2", "9");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
  <link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon" />
  <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>" />
  <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/vitals.css'; ?>" />
  <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/responsive_vitals.css'; ?>" />
  <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>" />
  <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>" />
  <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>" />
  <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/jquery-bootstrap-scrolling-tabs.css'; ?>" />
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" />

  <?php if ($page_table != '' && $page_table == 'datatable') { ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
    <?php if ($module != '' && $module != 'leave_summary') { ?>
      <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" />
    <?php } ?>
  <?php } ?>

  <?php if ($module == 'travel_accom') { ?>
    <link rel="stylesheet" href="<?php echo base_url() . 'source/autocomplete/autocomplete.css'; ?>" type="text/css" media="screen" />
  <?php } ?>
 <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/js/select/select2.min.css'; ?>" />
  <script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</head>

<?php
if ($main_menu == 'home') {
  $home_menu = 'active';
} else if ($main_menu == 'application') {
  $deals_menu = 'active';
} else if ($main_menu == 'portfolio') {
  $portfolio_menu = 'active';
} else if ($main_menu == 'portfolio_new') {
  $portfolio_menu = 'active';
} else if ($main_menu == 'request') {
  $request_menu = 'active';
} else if ($main_menu == 'approve') {
  $approve_menu = 'active';
} else if ($main_menu == 'funder') {
  $funder_menu = 'active';
} else if ($main_menu == 'report') {
  $report_menu = 'active';
} else if ($main_menu == 'admin') {
  $admin_menu = 'active';
}

if ($this->session->userdata('user_type')) {
  if ($this->session->userdata('user_type') != 'incubatee' && $this->session->userdata('ais_privilege') == 1) {
    $count = total_pending_count();
  }
}

$sess_empid = $this->session->userdata('emp_number');
$finance_user_count = financeuser_count($sess_empid);
$fin_user = 0;
if ($finance_user_count == 1) {
  $fin_user = 1;
}

$split_menu = explode(',', $this->session->userdata['menuAccess']);
$deals_opacity = $portfolio_opacity = $request_opacity = $approval_opacity = $fund_opacity = $report_opacity = '';
$deals_blur = $portfolio_blur = $request_blur = $approval_blur = $fund_blur = $report_blur = '';

if ($this->session->userdata['role_id'] != '4' || ($this->session->userdata['role_id'] == '4' && in_array('2', $split_menu))) {
  $deal_menu_url = base_url() . 'index.php/portfolio/alldeals';
} else {
  $deal_menu_url = 'javascript:void(0);';
  $deals_opacity = 'opacity5 nocursor';
  $deals_blur = 'menu-blur';
}

if ($this->session->userdata['role_id'] != '4' || ($this->session->userdata['role_id'] == '4' && in_array('6', $split_menu) && $company_id != '')) {
  //$portfolio_menu_url = base_url() . 'index.php/portfolio/portfolio_summary';
  $portfolio_menu_url = base_url() . 'index.php/portfolio/portfolio_summary_old';
} else {
  $portfolio_menu_url = 'javascript:void(0);';
  $portfolio_opacity = 'opacity5 nocursor';
  $portfolio_blur = 'menu-blur';
}

if ($this->session->userdata['role_id'] != '4' || ($this->session->userdata['role_id'] == '4' && in_array('9', $split_menu))) {
  $request_menu_url = base_url() . 'index.php/approval/new_approval';
} else {
  $request_menu_url = 'javascript:void(0);';
  $request_opacity = 'opacity5 nocursor';
  $request_blur = 'menu-blur';
}

if ($this->session->userdata['role_id'] != '4' || ($this->session->userdata['role_id'] == '4' && in_array('10', $split_menu))) {
  $approve_menu_url = base_url() . 'index.php/approval/approvaladmin/approval_notes/pending';
} else {
  $approve_menu_url = 'javascript:void(0);';
  $approval_opacity = 'opacity5 nocursor';
  $approval_blur = 'menu-blur';
}

if ($this->session->userdata['role_id'] != '4' || ($this->session->userdata['role_id'] == '4' && in_array('8', $split_menu))) {
  $fund_menu_url = base_url() . 'index.php/funder/display_summary_list';
} else {
  $fund_menu_url = 'javascript:void(0);';
  $fund_opacity = 'opacity5 nocursor';
  $fund_blur = 'menu-blur';
}

if ($this->session->userdata['role_id'] != '4' || ($this->session->userdata['role_id'] == '4' && in_array('7', $split_menu))) {
  if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin' || $fin_user == 1) {
    $report_menu_url = base_url() . 'index.php/report/report_an';
  } else {
    $report_menu_url = base_url() . 'index.php/report/untilized_report';
  }
} else {
  $report_menu_url = 'javascript:void(0);';
  $report_opacity = 'opacity5 nocursor';
  $report_blur = 'menu-blur';
}
?>

<body>
  <div class="fixed-headervi">
    <header class="newVitalheader">
      <div class="container-fluid">
        <div class="row">
          <div class="col-6 col-md-1 display-flex">
            <nav class="navbar navbar-light show_mob">
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            </nav>
            <div class="vil-logo">
              <a href="<?php echo base_url(); ?>">
                <img src="<?php echo base_url() . 'uploads/partner_logo/' . $this->session->userdata('partner_logo'); ?>" class="responsive" alt="Villgro Logo" />
              </a>
            </div>
          </div>
          <div class="d-block d-md-none text-center">
            <div class="collapse navbar-collapse show_mob" id="navbarTogglerDemo01">
              <ul class="navbar-nav">
			  	<?php if ($this->session->userdata('emp_number')!='645') { ?>
                <li class="nav-item <?= $deals_menu; ?>">
                  <a class="nav-link <?= $deals_opacity; ?>" href="<?php echo $deal_menu_url; ?>"><span class="activeMenuImg <?= $deals_blur; ?>"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.9425 10.5575L10.565 15.935C10.4257 16.0745 10.2603 16.1851 10.0782 16.2606C9.89606 16.3361 9.70087 16.3749 9.50375 16.3749C9.30663 16.3749 9.11144 16.3361 8.92934 16.2606C8.74724 16.1851 8.58181 16.0745 8.4425 15.935L2 9.5V2H9.5L15.9425 8.4425C16.2219 8.72354 16.3787 9.10372 16.3787 9.5C16.3787 9.89628 16.2219 10.2765 15.9425 10.5575V10.5575Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                    <circle cx="6.5" cy="6.5" r="1.5" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </span> Deals</a>
              </li>
			   <?php
              } ?>
              <?php
              if (in_array($this->session->userdata['partner_id'], $allowed_partner)) {
                ?>
                <li class="nav-item">
                  <a class="nav-link <?= $portfolio_opacity; ?> <?= $portfolio_menu; ?>" href="<?php echo $portfolio_menu_url; ?>"><span class="activeMenuImg <?= $portfolio_blur; ?>"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.25 2.25H3.75C2.92157 2.25 2.25 2.92157 2.25 3.75V14.25C2.25 15.0784 2.92157 15.75 3.75 15.75H14.25C15.0784 15.75 15.75 15.0784 15.75 14.25V3.75C15.75 2.92157 15.0784 2.25 14.25 2.25Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6 12V5.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M9 12V8.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 12V10.5" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                  </svg></span> Portfolio</a>
                </li>
                <?php
              }
              if ($this->session->userdata('emp_number')!='645' && $this->session->userdata['user_type'] == 'employee' && $this->session->userdata['ais_privilege'] == '1') {
                ?>
                <li class="nav-item">
                  <a class="nav-link <?= $request_opacity; ?> <?= $request_menu; ?>" href="<?php echo $request_menu_url; ?>"><span class="activeMenuImg <?= $request_blur; ?>"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.75 0.75L15.75 3.75L12.75 6.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M2.25 8.25V6.75C2.25 5.95435 2.56607 5.19129 3.12868 4.62868C3.69129 4.06607 4.45435 3.75 5.25 3.75H15.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M5.25 17.25L2.25 14.25L5.25 11.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M15.75 9.75V11.25C15.75 12.0456 15.4339 12.8087 14.8713 13.3713C14.3087 13.9339 13.5456 14.25 12.75 14.25H2.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </span> Requests</a>
              </li>
              <?php
            }
            if ($this->session->userdata('emp_number')!='645' &&  $this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') {
              ?>
              <li class="nav-item">
                <a class="nav-link <?= $approval_opacity; ?> <?= $approve_menu; ?>" href="<?php echo $approve_menu_url; ?>"><span class="activeMenuImg <?= $approval_blur; ?>"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12.75 0.75L15.75 3.75L12.75 6.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M2.25 8.25V6.75C2.25 5.95435 2.56607 5.19129 3.12868 4.62868C3.69129 4.06607 4.45435 3.75 5.25 3.75H15.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M5.25 17.25L2.25 14.25L5.25 11.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M15.75 9.75V11.25C15.75 12.0456 15.4339 12.8087 14.8713 13.3713C14.3087 13.9339 13.5456 14.25 12.75 14.25H2.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span> Approve</a>
            </li>
            <?php
          }
          if ($this->session->userdata('emp_number')!='645' &&  $this->session->userdata['ais_privilege'] == '1') {
            ?>
            <li class="nav-item">
              <a class="nav-link <?= $fund_opacity; ?> <?= $funder_menu; ?>" href="<?php echo $fund_menu_url; ?>"><span class="activeMenuImg <?= $fund_blur; ?>"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 8H8C9.10457 8 10 8.89543 10 10V10C10 11.1046 9.10457 12 8 12H6" stroke="#2D2D2D" />
                <path d="M6 8H11" stroke="#2D2D2D" />
                <path d="M6 10.0002H11" stroke="#2D2D2D" />
                <path d="M7.36359 12.0007L9.63631 15.3341" stroke="#2D2D2D" />
                <path d="M11.2235 1H5.95294L7.27059 3.90909C7.27059 3.90909 2 9.72727 2 12.6364C2 15.5455 3.75686 17 5.07451 17H11.2235C12.5412 17 15.1765 15.5455 15.1765 12.6364C15.1765 9.72727 9.90588 3.90909 9.90588 3.90909L11.2235 1Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M7 4L10 4" stroke="#2D2D2D" />
              </svg>
            </span> Funds/Grants</a>
          </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link <?= $report_opacity; ?> <?= $report_menu; ?>" href="<?php echo $report_menu_url; ?>"><span class="activeMenuImg <?= $report_blur; ?>"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 5.25H3C2.17157 5.25 1.5 5.92157 1.5 6.75V14.25C1.5 15.0784 2.17157 15.75 3 15.75H15C15.8284 15.75 16.5 15.0784 16.5 14.25V6.75C16.5 5.92157 15.8284 5.25 15 5.25Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M12 15.75V3.75C12 3.35218 11.842 2.97064 11.5607 2.68934C11.2794 2.40804 10.8978 2.25 10.5 2.25H7.5C7.10218 2.25 6.72064 2.40804 6.43934 2.68934C6.15804 2.97064 6 3.35218 6 3.75V15.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span> Reports</a>
      </li>
      <?php
      if ($this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
        ?>
        <li class="nav-item">
          <a class="nav-link <?= $admin_menu; ?>" href="<?php echo base_url() . 'index.php/user/lists/3'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.75 15.75V14.25C12.75 13.4544 12.4339 12.6913 11.8713 12.1287C11.3087 11.5661 10.5456 11.25 9.75 11.25H3.75C2.95435 11.25 2.19129 11.5661 1.62868 12.1287C1.06607 12.6913 0.75 13.4544 0.75 14.25V15.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M6.75 8.25C8.40685 8.25 9.75 6.90685 9.75 5.25C9.75 3.59315 8.40685 2.25 6.75 2.25C5.09315 2.25 3.75 3.59315 3.75 5.25C3.75 6.90685 5.09315 8.25 6.75 8.25Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M17.25 15.75V14.25C17.2495 13.5853 17.0283 12.9396 16.621 12.4143C16.2138 11.8889 15.6436 11.5137 15 11.3475" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M12 2.34753C12.6453 2.51276 13.2173 2.88806 13.6257 3.41427C14.0342 3.94047 14.2559 4.58766 14.2559 5.25378C14.2559 5.91991 14.0342 6.56709 13.6257 7.0933C13.2173 7.61951 12.6453 7.99481 12 8.16003" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span> Admin</a>
      </li>
    <?php } ?>
  </ul>
</div>
</div>
<div class="d-none d-md-block col-md-8 text-center">
  <div class="headerMenuNew" id="navbarTogglerDemo01">
    <ul>
	<?php if ($this->session->userdata('emp_number')!='645') { ?>
      <li class="nav-item">
        <a class="nav-link <?= $deals_opacity; ?> <?= $deals_menu; ?>" href="<?php echo $deal_menu_url; ?>"><span class="activeMenuImg <?= $deals_blur; ?>"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15.9425 10.5575L10.565 15.935C10.4257 16.0745 10.2603 16.1851 10.0782 16.2606C9.89606 16.3361 9.70087 16.3749 9.50375 16.3749C9.30663 16.3749 9.11144 16.3361 8.92934 16.2606C8.74724 16.1851 8.58181 16.0745 8.4425 15.935L2 9.5V2H9.5L15.9425 8.4425C16.2219 8.72354 16.3787 9.10372 16.3787 9.5C16.3787 9.89628 16.2219 10.2765 15.9425 10.5575V10.5575Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
          <circle cx="6.5" cy="6.5" r="1.5" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </span> Deals</a>
    </li>
	<?php } ?>
    <?php if (in_array($this->session->userdata['partner_id'], $allowed_partner)) { ?>
      <li class="nav-item">
        <a class="nav-link <?= $portfolio_opacity; ?> <?= $portfolio_menu; ?>" href="<?php echo $portfolio_menu_url; ?>"><span class="activeMenuImg <?= $portfolio_blur; ?>"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M14.25 2.25H3.75C2.92157 2.25 2.25 2.92157 2.25 3.75V14.25C2.25 15.0784 2.92157 15.75 3.75 15.75H14.25C15.0784 15.75 15.75 15.0784 15.75 14.25V3.75C15.75 2.92157 15.0784 2.25 14.25 2.25Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M6 12V5.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M9 12V8.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M12 12V10.5" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
        </svg></span> Portfolio</a>
      </li>
      <?php
    }
    if ($this->session->userdata('emp_number')!='645' &&  $this->session->userdata['user_type'] == 'employee' && $this->session->userdata['ais_privilege'] == '1') {
      ?>
      <li class="nav-item">
        <a class="nav-link <?= $request_opacity; ?> <?= $request_menu; ?>" href="<?php echo $request_menu_url; ?>"><span class="activeMenuImg <?= $request_blur; ?>"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12.75 0.75L15.75 3.75L12.75 6.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M2.25 8.25V6.75C2.25 5.95435 2.56607 5.19129 3.12868 4.62868C3.69129 4.06607 4.45435 3.75 5.25 3.75H15.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M5.25 17.25L2.25 14.25L5.25 11.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M15.75 9.75V11.25C15.75 12.0456 15.4339 12.8087 14.8713 13.3713C14.3087 13.9339 13.5456 14.25 12.75 14.25H2.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </span> Requests</a>
    </li>
    <?php
  }
  if ($this->session->userdata('emp_number')!='645' &&  $this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') {
    ?>
    <li class="nav-item">
      <a class="nav-link <?= $approval_opacity; ?> <?= $approve_menu; ?>" href="<?php echo $approve_menu_url; ?>"><span class="activeMenuImg <?= $approval_blur; ?>"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12.75 0.75L15.75 3.75L12.75 6.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M2.25 8.25V6.75C2.25 5.95435 2.56607 5.19129 3.12868 4.62868C3.69129 4.06607 4.45435 3.75 5.25 3.75H15.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M5.25 17.25L2.25 14.25L5.25 11.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M15.75 9.75V11.25C15.75 12.0456 15.4339 12.8087 14.8713 13.3713C14.3087 13.9339 13.5456 14.25 12.75 14.25H2.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </span> Approve</a>
  </li>
  <?php
}
if ($this->session->userdata('emp_number')!='645' &&  $this->session->userdata['ais_privilege'] == '1' ) {
  ?>
  <li class="nav-item">
    <a class="nav-link <?= $fund_opacity; ?> <?= $funder_menu; ?>" href="<?php echo $fund_menu_url; ?>"><span class="activeMenuImg <?= $fund_blur; ?>"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M6 8H8C9.10457 8 10 8.89543 10 10V10C10 11.1046 9.10457 12 8 12H6" stroke="#2D2D2D" />
      <path d="M6 8H11" stroke="#2D2D2D" />
      <path d="M6 10.0002H11" stroke="#2D2D2D" />
      <path d="M7.36359 12.0007L9.63631 15.3341" stroke="#2D2D2D" />
      <path d="M11.2235 1H5.95294L7.27059 3.90909C7.27059 3.90909 2 9.72727 2 12.6364C2 15.5455 3.75686 17 5.07451 17H11.2235C12.5412 17 15.1765 15.5455 15.1765 12.6364C15.1765 9.72727 9.90588 3.90909 9.90588 3.90909L11.2235 1Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
      <path d="M7 4L10 4" stroke="#2D2D2D" />
    </svg>
  </span> Funds/Grants</a>
</li>
<?php } ?>
<?php if ($this->session->userdata('emp_number')!='645') { ?>
	<li class="nav-item">
	  <a class="nav-link <?= $report_opacity; ?> <?= $report_menu; ?>" href="<?php echo $report_menu_url; ?>"><span class="activeMenuImg <?= $report_blur; ?>"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M15 5.25H3C2.17157 5.25 1.5 5.92157 1.5 6.75V14.25C1.5 15.0784 2.17157 15.75 3 15.75H15C15.8284 15.75 16.5 15.0784 16.5 14.25V6.75C16.5 5.92157 15.8284 5.25 15 5.25Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
		<path d="M12 15.75V3.75C12 3.35218 11.842 2.97064 11.5607 2.68934C11.2794 2.40804 10.8978 2.25 10.5 2.25H7.5C7.10218 2.25 6.72064 2.40804 6.43934 2.68934C6.15804 2.97064 6 3.35218 6 3.75V15.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
	  </svg>
	</span> Reports</a>
	</li>
<?php } ?>
<?php if ($this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
  <li class="nav-item">
    <a class="nav-link <?= $admin_menu; ?>" href="<?php echo base_url() . 'index.php/user/lists/3'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M12.75 15.75V14.25C12.75 13.4544 12.4339 12.6913 11.8713 12.1287C11.3087 11.5661 10.5456 11.25 9.75 11.25H3.75C2.95435 11.25 2.19129 11.5661 1.62868 12.1287C1.06607 12.6913 0.75 13.4544 0.75 14.25V15.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
      <path d="M6.75 8.25C8.40685 8.25 9.75 6.90685 9.75 5.25C9.75 3.59315 8.40685 2.25 6.75 2.25C5.09315 2.25 3.75 3.59315 3.75 5.25C3.75 6.90685 5.09315 8.25 6.75 8.25Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
      <path d="M17.25 15.75V14.25C17.2495 13.5853 17.0283 12.9396 16.621 12.4143C16.2138 11.8889 15.6436 11.5137 15 11.3475" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
      <path d="M12 2.34753C12.6453 2.51276 13.2173 2.88806 13.6257 3.41427C14.0342 3.94047 14.2559 4.58766 14.2559 5.25378C14.2559 5.91991 14.0342 6.56709 13.6257 7.0933C13.2173 7.61951 12.6453 7.99481 12 8.16003" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  </span> Admin</a>
</li>
<?php } ?>
</ul>
</div>
</div>

<?php
$switch_type = '';
if ($this->session->userdata('role_id') == 2 && $this->session->userdata('user_type') == 'admin') {
  $switch_type = 'Switch to user';
} else if ($this->session->userdata('role_id') == 2 && $this->session->userdata('user_type') == 'employee') {
  $switch_type = 'Switch to admin';
}

if ($this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') {
  $notify_url = site_url('approval/approvaladmin/approval_notes/pending');
} else {
  $notify_url = site_url('approval/approval_note/all_pending');
                            # Redirect PH/CEO/PENDING approval notes
  $this->load->model('Approval/Mapproval');
  $emp_id = $this->session->userdata('emp_number');
  $partner_id = $this->session->userdata('partner_id');
  $ph_user_count = $this->Mapproval->get_ph_user($emp_id, $partner_id);

  $this->load->model('Approval/Mlogapproval');
  $emp_id = $this->session->userdata('emp_number');
  $partner_id = $this->session->userdata('partner_id');
  $ph_user_count = $this->Mapproval->get_ph_user($emp_id, $partner_id);
  $ceo = $this->Mapproval->getApprovalSetting('ceo');
  $sess_emp_id = $this->session->userdata('emp_number');
  $ph_Usercount = '0';
  if (!empty($ph_user_count)) {
    $ph_Usercount = '1';
    $getAll_Phcount = $phcount = total_phpending_count($sess_emp_id);
  }

  $ceo_Usercount = '0';
  if ($ceo == $this->session->userdata('emp_number')) {
    $ceo_Usercount = '1';
    $where = "(AP.above_50000 = 'yes' or AP.estimated_in_workplan = 'no' ) and AP.status = 'pending'";
    $columnSortOrder = 'asc';
    $admin = 'Show all';
    $approvalCount = $this->Mapproval->getLimitApprovalNotes($where, '', '', $sort_column, $columnSortOrder, $admin);
    $getAll_count = php72_count($approvalCount);
  }

  if ($ph_Usercount == '1' && $ceo_Usercount == '1') {
    $type = 1;
    if ($getAll_count > 0) {
      $notify_url = site_url('approval/approval_note/all_pending/ceolist');
    }
    if ($getAll_Phcount > 0) {
      $notify_url = site_url('approval/approval_note/pending/phlist');
    }
  } else if ($ph_Usercount == '1' && $ceo_Usercount == '0') {
    $type = 2;
    if ($getAll_Phcount > 0) {
      $notify_url = site_url('approval/approval_note/pending/phlist');
    }
  } else if ($ph_Usercount == '0' && $ceo_Usercount == '1') {
    $type = 3;
    if ($getAll_count > 0) {
      $notify_url = site_url('approval/approval_note/all_pending/ceolist');
    }
  } else if ($ph_Usercount == '0' && $ceo_Usercount == '0') {
    $type = 4;
    $notify_url = site_url('approval/approval_note/all_pending');
  }
                            # Redirect PH/CEO/PENDING approval notes
}

if ($this->session->userdata['role_id'] != '4' || ($this->session->userdata['role_id'] == '4' && in_array('9', $split_menu))) {
  $notify_icon_link = $notify_url;
  $notify_icon_opacity = '';
} else {
  $notify_icon_link = 'javascript:void(0);';
  $notify_icon_opacity = 'opacity5 nocursor';
}
?>

<div class="col-md-3 col-6 align-self-center text-right">
  <ul class="vitals-links">
    <li>
      <a href="<?= $notify_icon_link; ?>" class="notifyLink <?= $notify_icon_opacity; ?>">
        <div class="notifyIconNew position-relative">
          <span class="notifySVg">
            <svg width="14" height="18" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M0.75 1.55011H12" stroke="#00662D" stroke-width="1.5" />
              <path d="M0.750122 14.5999H12.0001" stroke="#00662D" stroke-width="1.5" />
              <path d="M2.85016 1.54999V4.39999L9.97516 11.6V14.6" stroke="#00662D" stroke-width="1.5" />
              <path d="M2.85004 14.5997V11.7497L9.97504 4.54973V1.54973" stroke="#00662D" stroke-width="1.5" />
            </svg>
          </span>
          <span class="notifyCount"><?= $count; ?></span>
        </div>
      </a>
    </li>
    <li class="align-self-center headerUserWl">
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
          <?php $emp_id = $this->session->userdata('emp_number'); ?>
          <?php if ($switch_type != '') { ?>
            <a class="dropdown-item" href="<?php echo base_url() . 'index.php/login/admin_portfolio'; ?>"><i class="fas fa-retweet"></i> <?= $switch_type; ?></a>
          <?php } ?>
          <?php
            
            if ($this->session->userdata('user_type') != 'admin') {
              ?>
            
          <a class="dropdown-item" href="<?php echo site_url('myprofile/personal'); ?>/<?php echo $emp_id; ?>"><i class="fas fa-user"></i> My Profile </a>
        <?php } ?>
          <!-- <a class="dropdown-item" href="<?php echo site_url('changepass'); ?>"><i class="fas fa-key"></i> Change password</a> -->
          <a class="dropdown-item" href="<?php echo base_url() . 'index.php/login/logout'; ?>"><i class="fas fa-sign-out-alt"></i> Sign out</a>
        </div>
      </div>
    </li>
  </ul>
</div>
</div>
</div>
</header>

<?php if ($port_action == 'add_portfolio') { ?>
  <div class="vil-sub_menu deal-bread vi-inner-ma-top-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-3 col-md-3 col-sm-3 col-12">
          <h4> Add to Portfolio</h4>
        </div>
        <div class="col-xl-9 col-md-9 col-sm-9 col-12 text-right">
          <div class="form-group">
            <ul>
              <li>
                <form id="search" action="<?= base_url() . 'index.php/portfolio/addportfolio'; ?>" method="post" name="<?= $form_name ?>" autocomplete="off">
                  <div id="custom-search-input">
                    <div class="input-group">
                      <input type="text" class="search-query form-control" name="search_value" placeholder="Search by incubatee #ID" value="<?php echo (isset($search_value)) ? $search_value : ''; ?>" />
                      <span class="input-group-btn">
                        <button class="btn btn-danger" type="submit">
                          <i class="fas fa-search"></i>
                        </button>
                      </span>
                    </div>
                  </div>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } else if ($port_action == 'plan') { ?>
  <div class="villgro-breadcrumb container-fluid">
    <div class="row">
      <div class="col-md-6 col-xl-6 col-lg-6 col-12 pad-lt40px onbordconfig-title">
       <!--span><a href="<?php echo base_url() . 'index.php/portfolio/company_summary/' . $inv_id . '/' . $fin_year; ?>"><i class="fas fa-angle-left"></i> Back to Dashboard </a></span-->
       <?php /* <span><a href="<?php echo base_url() . 'index.php/portfolio/portfolio_summary_old/'; ?>"><i class="fas fa-angle-left"></i> Back to Dashboard </a></span> */ ?>
       <span><a href="javascript:void(0)" class="restrict-tag" onclick="go_to_previous_page();"><i class="fas fa-angle-left"></i> Back to Dashboard </a></span>
	   
     </div>
     <div class="col-md-6 col-xl-6 col-lg-6 col-12 text-right onbordconfig-title">
      <h6>
        <a href="<?= base_url() . 'index.php/portfolio/all_forms/updates/' . $inv_id . '/' . $fin_year; ?>">
          <span>
            Achievements: <?php
            echo ucfirst($company_name) . ', ';
            if ($reg_city != '') {
              echo ucfirst($reg_city) . ', ';
            }
            if ($sector_name != '') {
              echo ucfirst($sector_name);
            }
            ?>
          </span>
        </a>
      </h6>
    </div>
  </div>
</div>
<?php } else if ($port_action == 'actual') { ?>

  <div class="villgro-breadcrumb container-fluid">
    <div class="row">
      <div class="col-md-6 col-xl-6 col-lg-6 col-12 pad-lt40px onbordconfig-title">
       <!--span><a href="<?php echo base_url() . 'index.php/portfolio/company_summary/' . $inv_id . '/' . $fin_year; ?>"><i class="fas fa-angle-left"></i> Back to Dashboard </a></span-->
       <?php /* <span><a href="<?php echo base_url() . 'index.php/portfolio/portfolio_summary_old/'; ?>"><i class="fas fa-angle-left"></i> Back to Dashboard </a></span> */ ?>
	   <span><a href="javascript:void(0)" class="restrict-tag" onclick="go_to_previous_page();"><i class="fas fa-angle-left"></i> Back to Dashboard </a></span> 
     </div>
     <div class="col-md-6 col-xl-6 col-lg-6 col-12 text-right onbordconfig-title">
      <h6>
        <a href="<?= base_url() . 'index.php/portfolio/product/' . $inv_id . '/' . $fin_year; ?>">
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
<?php } else if ($port_action == 'sec_plan') { ?>
  <div class="vil-sub_menu deal-bread vi-inner-ma-top-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-8 col-md-8 col-sm-8 col-12">
          <ul class="milestone-links">
           <li>
            <div class="pad-lt40px onbordconfig-title">
              <?php /* <span><a href="<?php echo base_url() . 'index.php/portfolio/portfolio_summary_old'; ?>"><i class="fas fa-angle-left"></i> Back to Dashboard </a></span> */ ?>
			  <span><a href="javascript:void(0)" class="restrict-tag" onclick="go_to_previous_page();"><i class="fas fa-angle-left"></i> Back to Dashboard </a></span>
            </div>
          </li>
          <li>
            <div class="form-group">
              <ul class="milestone-links">
                <li>
                  <select name="txtSector" id="txtSector" class="form-control form-control-sm" onchange="load_sector(this.value)">
                    <!--<option value="">All Sectors</option>-->
                    <?php foreach ($sectors_values as $row) { ?>
                      <option value="<?php echo $row['id']; ?>" <?php
                      if ($row['id'] == $sector_id) {
                        echo 'selected';
                      }
                      ?>><?= $row['sector']; ?></option>
                    <?php } ?>
                  </select>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <div class="form-group">
              <ul class="milestone-links sectormenusnav">
                <li>
                  <select class="form-control form-control-sm" name="financial_year" id="financial_year" onchange="loadYear(this.value);">
                    <?php
                    if (php72_count($fin_list) > 0) {
                      foreach ($fin_list as $year) {
                        $nxt_fyear = $year['fin_year'] + 1;
                        ?>
                        <option value="<?= $year['fin_year']; ?>" <?php if (isset($current_financial) && $current_financial == $year['fin_year']) { ?> selected <?php } ?>><?= $year['fin_year'] . ' - ' . $nxt_fyear; ?></option>
                        <?php
                      }
                    } else {
                      ?>
                      <option value="<?= date('Y'); ?>" <?php if (isset($current_financial) && $current_financial == date('Y')) { ?> selected <?php } ?>><?= date('Y'); ?></option>
                    <?php } ?>
                  </select>
                </li>
                <li>
                  <a class="active">Sector Plan</a>
                </li>
                <li>
                  <a href="<?= base_url() . 'index.php/portfolio/sector_plan/sector_plan_export/' . $sector_id . '/' . $current_financial; ?>" title="Export <?php echo $sector_name; ?> Summary"><i class="fas fa-file-export"></i></a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
      <div class="col-md-4 col-xl-4 col-lg-4 col-12 text-right onbordconfig-title">
        <h6 class="padding-top-8"><a href="<?= base_url() . 'index.php/portfolio/sector_actual/discovery/' . $sector_id . '/' . $current_financial; ?>">
          <span>
            Achievements: <?= $sector_name; ?> Sector
          </span>
        </a></h6>
      </div>
    </div>
  </div>
</div>
<?php } else if ($port_action == 'sec_actual') { ?>
  <div class="villgro-breadcrumb container-fluid">
    <div class="row">
      <div class="col-md-6 col-xl-6 col-lg-6 col-12 pad-lt40px onbordconfig-title">
        <?php /* <span><a href="<?php echo base_url() . 'index.php/portfolio/portfolio_summary_old'; ?>"><i class="fas fa-angle-left"></i> Back to Dashboard </a></span> */ ?>
        <span><a href="javascript:void(0)" class="restrict-tag" onclick="go_to_previous_page();"><i class="fas fa-angle-left"></i> Back to Dashboard </a></span>
      </div>
      <div class="col-md-6 col-xl-6 col-lg-6 col-12 text-right onbordconfig-title">
        <h6><a href="<?= base_url() . 'index.php/portfolio/sector_plan/discovery/' . $sector_id . '/' . $current_financial; ?>">
          <span>
            Plan: <?= $sector_name; ?> Sector
          </span>
        </a></h6>
      </div>
    </div>
  </div>
<?php } ?>
</div>

<?php if ($portfolio_summary == 'yes') { ?>
  <div class="onboardtabmenu wdt-100">
  <?php } else { ?>
    <div class="vi-newdashboard vi-dashboard-vital onboardtabmenu wdt-100 <?= $add_class; ?>">
      <?php if ($container != 'yes') { ?>
        <div class="container-fluid">
        <?php } ?>
      <?php } ?>

      <?php
      $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
      $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';
      $deleteMsg = ($this->session->flashdata('deleteMsg')) ? $this->session->flashdata('deleteMsg') : '';
      if ($successMsg != '') {
        ?>
        <div class="position-absolute d-flex flex-column p-4 toastPlace toasterHide">
          <div id="toast-container" aria-live="polite" aria-atomic="true">
            <div id="toast-wrapper">
              <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                <div class="toast-header bg-success text-white">
                  <strong><?= $successMsg; ?></strong>
                  <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true" class="text-white">×</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      if ($errorMsg != '') {
        ?>
        <div class="position-absolute d-flex flex-column p-4 toastPlace toasterHide">
          <div id="toast-container" aria-live="polite" aria-atomic="true">
            <div id="toast-wrapper">
              <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                <div class="toast-header bg-danger text-white">
                  <strong><?= $errorMsg; ?></strong>
                  <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true" class="text-white">×</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      if ($deleteMsg != '') {
        ?>
        <div class="position-absolute d-flex flex-column p-4 toastPlace toasterHide">
          <div id="toast-container" aria-live="polite" aria-atomic="true">
            <div id="toast-wrapper">
              <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                <div class="toast-header bg-success text-white">
                  <strong><?= $deleteMsg; ?></strong>
                  <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true" class="text-white">×</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>

      <div class="display-hide deleteMsg">
        <div class="position-absolute d-flex flex-column p-4 toastPlace toasterHide">
          <div id="toast-container" aria-live="polite" aria-atomic="true">
            <div id="toast-wrapper">
              <div class="toast imgToast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                <div class="toast-header bg-success text-white">
                  <strong id="deleteText"></strong>
                  <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true" class="text-white">×</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

