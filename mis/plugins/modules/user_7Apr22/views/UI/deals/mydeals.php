<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villgro MIS</title>
    <link rel="shortcut icon" href="<?php echo base_url() . 'myfavicon.ico'; ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/new-portfolio.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/responsive_vitals.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-grid.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap-reboot.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
</head>

<body>
    <div class="fixed-headervi">
        <?php $this->load->view('UI/header1.php'); ?>
    </div>
    <div class="vil-sub_menu deal-bread ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12">
                        <ul class="milestone-links">
                            <li>
                                <h6 class="reduce_space">All Deals from Partner - Villgro India</h6>
                            </li>                           
                        </ul>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-6 col-sm-6 col-12 text-right">
                        <div class="form-group">
                            <ul>
                                <li><a href="<?= base_url() . 'index.php/scouting/new_innovation'; ?>" class="btn btn-success"><i class="fas fa-plus-circle"></i>&nbsp;Add Deal</a></li>
                                <li><a href="addportfolio" class="btn btn-success"><i class="fas fa-plus-circle"></i>&nbsp;Add to Portfolio</a></li>
                                <li><a href="javascript:void(0)" id="assign_incharge" class="btn btn-success"><i class="fas fa-user-tie"></i>
                                        Assign Incharge</a></li>
                                <li>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-search"></i> Search
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
    <!-- Inner Dashboard-->
    <div class="vi-dashboard-vital-deals onboardtabmenu wdt-100">
       
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="Diagnostic-graph">
                        <div id="accordion" class="vil-Deals vital_windowScroll table-responsive portfolio-table">
                            <table id="table1" class="gtable sortable">
                                <thead>
                                    <tr>
                                        <th width="2%">Select</th>
                                        <th nowrap="nowrap">INV ID</th>
                                        <th nowrap="nowrap">Enterprise</th>
                                        <th nowrap="nowrap">Entrepreneur</th>
                                        <th>Sector</th>
                                        <th>Program</th>
                                        <th>Stage</th>
                                        <th>Status</th>
                                        <th>Applied to Partners</th>
                                        <th nowrap="nowrap">Submitted Date</th>
                                        <th>Delete</th>
                                        <th align="left"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="checkbox" class="form-control"></td>
                                        <td>19994_01_01</td>
                                        <td><a href="javascript:">Play Like A Station</a></td>
                                        <td>Harddik K Patel</td>
                                        <td>Health</td>
                                        <td>Incubation</td>
                                        <td>Application</td>
                                        <td>Open</td>
                                        <td>KIIT,IIMC</td>
                                        <td>08-may-20</td>
                                        <td><span><i class="fas fa-times-circle"></i></span></td>
                                        <td>
                                            <ul class="vitals-links">
                                                <li><a href="javascript:" class="dealNewIcon"><i class="fas fa-download"></i></a></li>
                                                <li class="innerDroMenuDeal"><a href="javascript:" class="dropdown-toggle dealNewIcon" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i> </span>
                                                    </a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/deals'; ?>">Incubation Application Form</a></li>
                                                        <li><a href="#">Preliminary Assessment</a></li>
                                                        <li><a href="#">Detail Diligence</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="form-control"></td>
                                        <td>19994_01_01</td>
                                        <td><a href="javascript:">Play Like A Station</a></td>
                                        <td>Harddik K Patel</td>
                                        <td>Health</td>
                                        <td>Incubation</td>
                                        <td>Application</td>
                                        <td>Open</td>
                                        <td>KIIT,IIMC</td>
                                        <td>08-may-20</td>
                                        <td><span><i class="fas fa-times-circle"></i></span></td>
                                        <td>
                                            <ul class="vitals-links">
                                                <li><a href="javascript:" class="dealNewIcon"><i class="fas fa-download"></i></a></li>
                                                <li class="innerDroMenuDeal"><a href="javascript:" class="dropdown-toggle dealNewIcon" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i> </span>
                                                    </a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/deals'; ?>">Incubation Application Form</a></li>
                                                        <li><a href="#">Preliminary Assessment</a></li>
                                                        <li><a href="#">Detail Diligence</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="form-control"></td>
                                        <td>19994_01_01</td>
                                        <td><a href="javascript:">Play Like A Station</a></td>
                                        <td>Harddik K Patel</td>
                                        <td>Health</td>
                                        <td>Incubation</td>
                                        <td>Application</td>
                                        <td>Open</td>
                                        <td>KIIT,IIMC</td>
                                        <td>08-may-20</td>
                                        <td><span><i class="fas fa-times-circle"></i></span></td>
                                        <td>
                                            <ul class="vitals-links">
                                                <li><a href="javascript:" class="dealNewIcon"><i class="fas fa-download"></i></a></li>
                                                <li class="innerDroMenuDeal"><a href="javascript:" class="dropdown-toggle dealNewIcon" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i> </span>
                                                    </a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/deals'; ?>">Incubation Application Form</a></li>
                                                        <li><a href="#">Preliminary Assessment</a></li>
                                                        <li><a href="#">Detail Diligence</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="form-control"></td>
                                        <td>19994_01_01</td>
                                        <td><a href="javascript:">Play Like A Station</a></td>
                                        <td>Harddik K Patel</td>
                                        <td>Health</td>
                                        <td>Incubation</td>
                                        <td>Application</td>
                                        <td>Open</td>
                                        <td>KIIT,IIMC</td>
                                        <td>08-may-20</td>
                                        <td><span><i class="fas fa-times-circle"></i></span></td>
                                        <td>
                                            <ul class="vitals-links">
                                                <li><a href="javascript:" class="dealNewIcon"><i class="fas fa-download"></i></a></li>
                                                <li class="innerDroMenuDeal"><a href="javascript:" class="dropdown-toggle dealNewIcon" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i> </span>
                                                    </a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/deals'; ?>">Incubation Application Form</a></li>
                                                        <li><a href="#">Preliminary Assessment</a></li>
                                                        <li><a href="#">Detail Diligence</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="form-control"></td>
                                        <td>19994_01_01</td>
                                        <td><a href="javascript:">Play Like A Station</a></td>
                                        <td>Harddik K Patel</td>
                                        <td>Health</td>
                                        <td>Incubation</td>
                                        <td>Application</td>
                                        <td>Open</td>
                                        <td>KIIT,IIMC</td>
                                        <td>08-may-20</td>
                                        <td><span><i class="fas fa-times-circle"></i></span></td>
                                        <td>
                                            <ul class="vitals-links">
                                                <li><a href="javascript:" class="dealNewIcon"><i class="fas fa-download"></i></a></li>
                                                <li class="innerDroMenuDeal"><a href="javascript:" class="dropdown-toggle dealNewIcon" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i> </span>
                                                    </a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/deals'; ?>">Incubation Application Form</a></li>
                                                        <li><a href="#">Preliminary Assessment</a></li>
                                                        <li><a href="#">Detail Diligence</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="form-control"></td>
                                        <td>19994_01_01</td>
                                        <td><a href="javascript:">Play Like A Station</a></td>
                                        <td>Harddik K Patel</td>
                                        <td>Health</td>
                                        <td>Incubation</td>
                                        <td>Application</td>
                                        <td>Open</td>
                                        <td>KIIT,IIMC</td>
                                        <td>08-may-20</td>
                                        <td><span><i class="fas fa-times-circle"></i></span></td>
                                        <td>
                                            <ul class="vitals-links">
                                                <li><a href="javascript:" class="dealNewIcon"><i class="fas fa-download"></i></a></li>
                                                <li class="innerDroMenuDeal"><a href="javascript:" class="dropdown-toggle dealNewIcon" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i> </span>
                                                    </a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/deals'; ?>">Incubation Application Form</a></li>
                                                        <li><a href="#">Preliminary Assessment</a></li>
                                                        <li><a href="#">Detail Diligence</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="form-control"></td>
                                        <td>19994_01_01</td>
                                        <td><a href="javascript:">Play Like A Station</a></td>
                                        <td>Harddik K Patel</td>
                                        <td>Health</td>
                                        <td>Incubation</td>
                                        <td>Application</td>
                                        <td>Open</td>
                                        <td>KIIT,IIMC</td>
                                        <td>08-may-20</td>
                                        <td><span><i class="fas fa-times-circle"></i></span></td>
                                        <td>
                                            <ul class="vitals-links">
                                                <li><a href="javascript:" class="dealNewIcon"><i class="fas fa-download"></i></a></li>
                                                <li class="innerDroMenuDeal"><a href="javascript:" class="dropdown-toggle dealNewIcon" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i> </span>
                                                    </a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/deals'; ?>">Incubation Application Form</a></li>
                                                        <li><a href="#">Preliminary Assessment</a></li>
                                                        <li><a href="#">Detail Diligence</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="form-control"></td>
                                        <td>19994_01_01</td>
                                        <td><a href="javascript:">Play Like A Station</a></td>
                                        <td>Harddik K Patel</td>
                                        <td>Health</td>
                                        <td>Incubation</td>
                                        <td>Application</td>
                                        <td>Open</td>
                                        <td>KIIT,IIMC</td>
                                        <td>08-may-20</td>
                                        <td><span><i class="fas fa-times-circle"></i></span></td>
                                        <td>
                                            <ul class="vitals-links">
                                                <li><a href="javascript:" class="dealNewIcon"><i class="fas fa-download"></i></a></li>
                                                <li class="innerDroMenuDeal"><a href="javascript:" class="dropdown-toggle dealNewIcon" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i> </span>
                                                    </a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/deals'; ?>">Incubation Application Form</a></li>
                                                        <li><a href="#">Preliminary Assessment</a></li>
                                                        <li><a href="#">Detail Diligence</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" class="form-control"></td>
                                        <td>19994_01_01</td>
                                        <td><a href="javascript:">Play Like A Station</a></td>
                                        <td>Harddik K Patel</td>
                                        <td>Health</td>
                                        <td>Incubation</td>
                                        <td>Application</td>
                                        <td>Open</td>
                                        <td>KIIT,IIMC</td>
                                        <td>08-may-20</td>
                                        <td><span><i class="fas fa-times-circle"></i></span></td>
                                        <td>
                                            <ul class="vitals-links">
                                                <li><a href="javascript:" class="dealNewIcon"><i class="fas fa-download"></i></a></li>
                                                <li class="innerDroMenuDeal"><a href="javascript:" class="dropdown-toggle dealNewIcon" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i> </span>
                                                    </a>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/deals'; ?>">Incubation Application Form</a></li>
                                                        <li><a href="#">Preliminary Assessment</a></li>
                                                        <li><a href="#">Detail Diligence</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--export forms-->
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
    <script>
        $(document).ready(function() {
        $('.vital_windowScroll').css({
            'height': (($(window).height()) - 200) + 'px'
        });
    });

    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
    </script>
</body>

</html>