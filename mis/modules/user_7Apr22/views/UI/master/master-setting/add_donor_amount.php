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
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/responsive_vitals.css'; ?>">
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
        <?php $this->load->view('UI/header.php'); ?>
    </div>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">
            <div class="Vital-Newmenu">
                <div class="row">
                <div class="col">
                <ul>
                            <li><a href=""><i class="fas fa-home"></i> Home</a></li>
                            <li><a href=""><i class="fas fa-tag"></i> Deals</a></li>
                            <li ><a href="<?php echo base_url() . 'index.php/user/user_ui/apply_leave'; ?>"><i class="fas fa-sync-alt"></i> Requests</a></li>
                            <!-- <li><a href=""><i class="far fa-check-square"></i> Approve</a></li> -->
                            <li><a href=""><i class="far fa-chart-bar"></i> Portfolio</a></li>
                            <li><a href=""><i class="fas fa-archive"></i> Resources</a></li>
                            <li><a href=""><i class="fas fa-suitcase"></i> Reports</a></li>
                            <li class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>"><i class="fas fa-user-friends"></i> Master's</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="dataconfig-content page-wrapper vitals_mainContent ">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('UI/master/master_sidemenu.php', array('page' => 'master_setting')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                    <span><a href="<?php echo base_url() . 'index.php/user/user_ui/donor_amount'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4>Add Donor Amount</h4>
                                </div>                                
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <main class="page-content">
                                    <div class="inputplan-structureall plan-structure-new">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="vitals_innerSub">Add Donor Amount</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-4 col-md-6 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Donor</label>
                                                    <select class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="1232">Accenture</option>
                                                        <option value="1549">Accenture_Old</option>
                                                        <option value="1433">AGC</option>
                                                        <option value="497">ALTIS</option>
                                                        <option value="9">ANDE</option>
                                                        <option value="1186">ARK</option>
                                                        <option value="916">Ashoka</option>
                                                        <option value="1207">Auto Desk</option>
                                                        <option value="652">AVC</option>
                                                        <option value="1288">Bayer</option>
                                                        <option value="956">BIRAC</option>
                                                        <option value="1204">Boston Consultancy group</option>
                                                        <option value="544">Citi</option>
                                                        <option value="1445">Daimler</option>
                                                        <option value="929">DFID</option>
                                                        <option value="1455">DOEN</option>
                                                        <option value="1256">Doen Foundation - Travel</option>
                                                        <option value="1255">Doen Foundation Rev</option>
                                                        <option value="1558">DOEN_Old</option>
                                                        <option value="983">Event Fees/Revenue</option>
                                                        <option value="1346">Ford Foundation</option>
                                                        <option value="908">GCC</option>
                                                        <option value="1033">GIZ</option>
                                                        <option value="1253">GIZ Energy Rev</option>
                                                        <option value="1254">GIZ Energy travel component</option>
                                                        <option value="1131">Godrej</option>
                                                        <option value="291">Halloran</option>
                                                        <option value="1224">HDFC</option>
                                                        <option value="1424">Hindustan Uniliver Foundation</option>
                                                        <option value="668">HSBC</option>
                                                        <option value="622">IEIF</option>
                                                        <option value="1083">Kerala Startup Mission</option>
                                                        <option value="976">Mahindra</option>
                                                        <option value="1042">Marico</option>
                                                        <option value="1450">MBRDI</option>
                                                        <option value="1565">MBRDI_Old</option>
                                                        <option value="1194">Mercedes Benz</option>
                                                        <option value="1022">Mphasis</option>
                                                        <option value="937">MSDF</option>
                                                        <option value="1231">MSDF.</option>
                                                        <option value="543">MSME</option>
                                                        <option value="289">NSTEDB</option>
                                                        <option value="1539">Olam</option>
                                                        <option value="1113">Omidyar</option>
                                                        <option value="1421">Rabo Bank</option>
                                                        <option value="1287">RSF</option>
                                                        <option value="1124">Samhita</option>
                                                        <option value="1511">SAP India</option>
                                                        <option value="545">Shakti</option>
                                                        <option value="892">SRTT</option>
                                                        <option value="1148">Star Chemicals</option>
                                                        <option value="290">TDB</option>
                                                        <option value="1274">TDB-INVENT Mgt Fees</option>
                                                        <option value="1568">TDB_2</option>
                                                        <option value="1475">TDB_Old</option>
                                                        <option value="5">TLF</option>
                                                        <option value="657">TLF for CCP</option>
                                                        <option value="877">TLF-EIR</option>
                                                        <option value="1219">TLF-TAP</option>
                                                        <option value="1442">TLF_Old</option>
                                                        <option value="1326">TRIF</option>
                                                        <option value="1462">UNDP</option>
                                                        <option value="1359">UNDP-Energy -Travel</option>
                                                        <option value="1358">UNDP-Energy Revenue</option>
                                                        <option value="1331">Venture Well</option>
                                                        <option value="1338">YES Bank</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Amount (INR)</label>
                                                    <input type="text" class="form-control" placeholder="Enter Amount" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Date (Amount Deposited) <span>*</span></label>
                                                    <input type="text" class="form-control" placeholder="" />
                                                </div>


                                                <div>
                                                    <ul class="vitals-links">
                                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/donor_amount'; ?>" class="vital_yellow_btn">Save Donor Amount</a></li>
                                                        <li><a href="<?php echo base_url() . 'index.php/user/user_ui/donor_amount'; ?>" class="vital_bordered_btn">Cancel</a></li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </main>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
<script>
    $('table').DataTable();

    // Window Height
    // ---------------------------------------
    $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 230) + 'px'});
        });
</script>

</html>