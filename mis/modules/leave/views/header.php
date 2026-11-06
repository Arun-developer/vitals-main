        <link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/vitals.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/responsive_vitals.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
<link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-multiselect.css'; ?>">
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/fullcalendar.css'; ?>">
<div class="fixed-headervi">
    <?php
    $req_active = $master_active = '';
    if(isset($page) && $page == 'request'){
        $req_active = 'active';
    }

    if(isset($page) && $page == 'master'){
        $master_active = 'active';
    }
     ?>
    
<header class="newVitalheader">
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 col-md-1 display-flex">
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
                            $logo_name = 'logo1.png';
                        }
                        ?>
                        <img src="<?php echo base_url() . 'source/portfolio_assets/img/' . $logo_name; ?>" class="responsive" alt="Villgro Logo" />
                    </a>
                </div>
            </div>
            <div class="d-block d-md-none text-left">
                <div class="collapse navbar-collapse show_mob" id="navbarTogglerDemo01">
                    <ul class="navbar-nav ">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.9425 10.5575L10.565 15.935C10.4257 16.0745 10.2603 16.1851 10.0782 16.2606C9.89606 16.3361 9.70087 16.3749 9.50375 16.3749C9.30663 16.3749 9.11144 16.3361 8.92934 16.2606C8.74724 16.1851 8.58181 16.0745 8.4425 15.935L2 9.5V2H9.5L15.9425 8.4425C16.2219 8.72354 16.3787 9.10372 16.3787 9.5C16.3787 9.89628 16.2219 10.2765 15.9425 10.5575V10.5575Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="6.5" cy="6.5" r="1.5" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span> Deals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/portfolio/portfolio_summary'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.25 2.25H3.75C2.92157 2.25 2.25 2.92157 2.25 3.75V14.25C2.25 15.0784 2.92157 15.75 3.75 15.75H14.25C15.0784 15.75 15.75 15.0784 15.75 14.25V3.75C15.75 2.92157 15.0784 2.25 14.25 2.25Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M6 12V5.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M9 12V8.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 12V10.5" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg></span> Portfolio</a>
                        </li>
                        <?php if($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin'){ ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $req_active; ?>" href="<?php echo base_url() . 'index.php/leave/apply_leave'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.75 0.75L15.75 3.75L12.75 6.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M2.25 8.25V6.75C2.25 5.95435 2.56607 5.19129 3.12868 4.62868C3.69129 4.06607 4.45435 3.75 5.25 3.75H15.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M5.25 17.25L2.25 14.25L5.25 11.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M15.75 9.75V11.25C15.75 12.0456 15.4339 12.8087 14.8713 13.3713C14.3087 13.9339 13.5456 14.25 12.75 14.25H2.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span> Requests</a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $req_active; ?>" href="<?php echo base_url() . 'index.php/leave/approve_leave_list'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.75 0.75L15.75 3.75L12.75 6.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M2.25 8.25V6.75C2.25 5.95435 2.56607 5.19129 3.12868 4.62868C3.69129 4.06607 4.45435 3.75 5.25 3.75H15.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M5.25 17.25L2.25 14.25L5.25 11.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M15.75 9.75V11.25C15.75 12.0456 15.4339 12.8087 14.8713 13.3713C14.3087 13.9339 13.5456 14.25 12.75 14.25H2.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span> Approve</a>
                            </li>
                        <?php
                    }
                         /* if ($this->session->userdata['ais_privilege'] == '1') { ?>
                          <li class="nav-item">
                          <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/approve_leave_list'; ?>"><i class="far fa-check-square"></i> Approve</a>
                          </li>
                          <?php } */ ?>
                        <?php if ($this->session->userdata['ais_privilege'] == '1') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/approve_leave_list'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/login/resources'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.75 6V15.75H2.25V6" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M17.25 2.25H0.75V6H17.25V2.25Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M7.5 9H10.5" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span> Resources</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/login/reports'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 5.25H3C2.17157 5.25 1.5 5.92157 1.5 6.75V14.25C1.5 15.0784 2.17157 15.75 3 15.75H15C15.8284 15.75 16.5 15.0784 16.5 14.25V6.75C16.5 5.92157 15.8284 5.25 15 5.25Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 15.75V3.75C12 3.35218 11.842 2.97064 11.5607 2.68934C11.2794 2.40804 10.8978 2.25 10.5 2.25H7.5C7.10218 2.25 6.72064 2.40804 6.43934 2.68934C6.15804 2.97064 6 3.35218 6 3.75V15.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span> Reports</a>
                        </li>
                        <?php if ($this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $master_active; ?>" href="<?php echo base_url() . 'index.php/user/lists/3'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
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
            <div class="d-none d-md-block col-md-8 text-left">
                <div class="headerMenuNew " id="navbarTogglerDemo01">
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.9425 10.5575L10.565 15.935C10.4257 16.0745 10.2603 16.1851 10.0782 16.2606C9.89606 16.3361 9.70087 16.3749 9.50375 16.3749C9.30663 16.3749 9.11144 16.3361 8.92934 16.2606C8.74724 16.1851 8.58181 16.0745 8.4425 15.935L2 9.5V2H9.5L15.9425 8.4425C16.2219 8.72354 16.3787 9.10372 16.3787 9.5C16.3787 9.89628 16.2219 10.2765 15.9425 10.5575V10.5575Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="6.5" cy="6.5" r="1.5" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span> Deals</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/portfolio/portfolio_summary'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.25 2.25H3.75C2.92157 2.25 2.25 2.92157 2.25 3.75V14.25C2.25 15.0784 2.92157 15.75 3.75 15.75H14.25C15.0784 15.75 15.75 15.0784 15.75 14.25V3.75C15.75 2.92157 15.0784 2.25 14.25 2.25Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M6 12V5.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M9 12V8.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 12V10.5" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg></span> Portfolio</a>
                        </li>
                        <?php if($this->session->userdata('user_type') != 'admin' && $this->session->userdata('user_type') != 'superadmin'){ ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $req_active; ?>" href="<?php echo base_url() . 'index.php/leave/apply_leave'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.75 0.75L15.75 3.75L12.75 6.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M2.25 8.25V6.75C2.25 5.95435 2.56607 5.19129 3.12868 4.62868C3.69129 4.06607 4.45435 3.75 5.25 3.75H15.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M5.25 17.25L2.25 14.25L5.25 11.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M15.75 9.75V11.25C15.75 12.0456 15.4339 12.8087 14.8713 13.3713C14.3087 13.9339 13.5456 14.25 12.75 14.25H2.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span> Requests</a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $req_active; ?>" href="<?php echo base_url() . 'index.php/leave/approve_leave_list'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.75 0.75L15.75 3.75L12.75 6.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M2.25 8.25V6.75C2.25 5.95435 2.56607 5.19129 3.12868 4.62868C3.69129 4.06607 4.45435 3.75 5.25 3.75H15.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M5.25 17.25L2.25 14.25L5.25 11.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M15.75 9.75V11.25C15.75 12.0456 15.4339 12.8087 14.8713 13.3713C14.3087 13.9339 13.5456 14.25 12.75 14.25H2.25" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span> Approve</a>
                            </li>
                        <?php
                    }
                         /* if ($this->session->userdata['ais_privilege'] == '1') { ?>
                          <li class="nav-item">
                          <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/approve_leave_list'; ?>"><i class="far fa-check-square"></i> Approve</a>
                          </li>
                          <?php } */ ?>
                        <?php if ($this->session->userdata['ais_privilege'] == '1') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo base_url() . 'index.php/leave/approve_leave_list'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/login/resources'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.75 6V15.75H2.25V6" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M17.25 2.25H0.75V6H17.25V2.25Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M7.5 9H10.5" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span> Resources</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url() . 'index.php/login/reports'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 5.25H3C2.17157 5.25 1.5 5.92157 1.5 6.75V14.25C1.5 15.0784 2.17157 15.75 3 15.75H15C15.8284 15.75 16.5 15.0784 16.5 14.25V6.75C16.5 5.92157 15.8284 5.25 15 5.25Z" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 15.75V3.75C12 3.35218 11.842 2.97064 11.5607 2.68934C11.2794 2.40804 10.8978 2.25 10.5 2.25H7.5C7.10218 2.25 6.72064 2.40804 6.43934 2.68934C6.15804 2.97064 6 3.35218 6 3.75V15.75" stroke="#2D2D2D" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span> Reports</a>
                        </li>
                        <?php if ($this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $master_active; ?>" href="<?php echo base_url() . 'index.php/user/lists/3'; ?>"><span class="activeMenuImg"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
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
            if (php72_cmp($this->session->userdata('role_id')) == 2 && $this->session->userdata('user_type') == 'admin') {
                $switch_type = 'Switch to user';
            } else if (php72_cmp($this->session->userdata('role_id')) == 2 && $this->session->userdata('user_type') == 'employee') {
                $switch_type = 'Switch to admin';
            }
            ?>

            <div class="col-md-3 col-8 align-self-center text-right">
            <ul class="vitals-links">
                    <li>
                        <a href="" class="notifyLink">
                            <div class="notifyIconNew position-relative">
                                <span class="notifySVg">
                                    <svg width="14" height="18" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.75 1.55011H12" stroke="#00662D" stroke-width="1.5" />
                                        <path d="M0.750122 14.5999H12.0001" stroke="#00662D" stroke-width="1.5" />
                                        <path d="M2.85016 1.54999V4.39999L9.97516 11.6V14.6" stroke="#00662D" stroke-width="1.5" />
                                        <path d="M2.85004 14.5997V11.7497L9.97504 4.54973V1.54973" stroke="#00662D" stroke-width="1.5" />
                                    </svg>
                                </span>
                                <span class="notifyCount">10</span>
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
                        <a class="dropdown-item" href="<?php echo base_url() . 'index.php/login/logout'; ?>"><i class="fas fa-sign-out-alt"></i> Sign out</a>
                    </div>
                </div>
                    </li>
                </ul>
                
            </div>

        </div>
    </div>
</header>
</div>

            <script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-1.9.1.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    
    <?php if(!isset($module) || ($module != 'leave_summary')){ ?>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<?php } ?>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.toaster.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap-multiselect.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/fullcalendar.js'; ?>"></script>