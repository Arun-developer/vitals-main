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
                                    <span><a href="<?php echo base_url() . 'index.php/user/user_ui/balance_sheet'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4>Add Donor Amount</h4>
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <main class="page-content">
                                    <div class="inputplan-structureall plan-structure-new">
                                        <!-- <div class="row">
                                            <div class="col-12">
                                                <h4 class="vitals_innerSub">Add Donor Amount</h4>
                                            </div>
                                        </div> -->
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                                                <div class="form-group">
                                                    <label>Programme <span>*</span></label>
                                                    <select class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="48">ANDE</option>
                                                        <option value="49">ANDE Chapter - II</option>
                                                        <option value="51">ANDE-GIZ</option>
                                                        <option value="77">Contingency</option>
                                                        <option value="66">Eduucation-Unconvention</option>
                                                        <option value="27">EIR</option>
                                                        <option value="28">EIR-AdithyaP</option>
                                                        <option value="29">EIR-GaneshB</option>
                                                        <option value="31">EIR-KoushikY</option>
                                                        <option value="33">EIR-MervinR</option>
                                                        <option value="30">EIR-MinhajA</option>
                                                        <option value="34">EIR-SagarL</option>
                                                        <option value="32">EIR-SankarR</option>
                                                        <option value="11">Fellowship</option>
                                                        <option value="76">Finance</option>
                                                        <option value="58">Fundraising</option>
                                                        <option value="65">GALI</option>
                                                        <option value="63">GIZ for the CXO meeting</option>
                                                        <option value="62">GIZ-Samhita</option>
                                                        <option value="75">HR</option>
                                                        <option value="23">Incubation</option>
                                                        <option value="54">Incubation-Agriculture</option>
                                                        <option value="43">Incubation-AVC</option>
                                                        <option value="40">Incubation-BIRAC</option>
                                                        <option value="68">Incubation-Common-Comms</option>
                                                        <option value="67">Incubation-Common-TAP</option>
                                                        <option value="47">Incubation-DFID</option>
                                                        <option value="36">Incubation-Education</option>
                                                        <option value="22">Incubation-Energy</option>
                                                        <option value="53">Incubation-Health</option>
                                                        <option value="45">Incubation-Mahindra</option>
                                                        <option value="52">Incubation-Mahindra (Flybird)</option>
                                                        <option value="50">Incubation-Mphasis</option>
                                                        <option value="39">Incubation-MSDF</option>
                                                        <option value="46">Incubation-RF</option>
                                                        <option value="44">Incubation-TDB</option>
                                                        <option value="42">Incubation-TLF-EIR</option>
                                                        <option value="41">Incubation-TLF-Main</option>
                                                        <option value="59">Invent</option>
                                                        <option value="13">Knowledge Management</option>
                                                        <option value="55">Marketing &amp; Communications</option>
                                                        <option value="74">Mentoring &amp; TAP</option>
                                                        <option value="57">Personnel</option>
                                                        <option value="38">Replication</option>
                                                        <option value="61">RISE</option>
                                                        <option value="64">RISE – Teacher Fellowship Program</option>
                                                        <option value="35">Scale</option>
                                                        <option value="24">SEED</option>
                                                        <option value="60">TAP</option>
                                                        <option value="56">Technology</option>
                                                        <option value="69">TRIF</option>
                                                        <option value="25">Unconvention</option>
                                                        <option value="71">UNDP-Energy</option>
                                                        <option value="26">VIF OH</option>
                                                        <option value="73">VRIC</option>
                                                        <option value="70">Yes Scale</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                                                <div class="form-group">
                                                    <label>Donor <span>*</span></label>
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
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                                                <div class="form-group">
                                                    <label>Amount (INR)</label>
                                                    <input type="text" class="form-control" placeholder="Enter Amount" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3 col-xl-3">
                                                <div class="form-group">
                                                    <label>Date (Amount Deposited) <span>*</span></label>
                                                    <input type="text" class="form-control" placeholder="" />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <h4>Add Donor Amount</h4>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <ul class="milestone-links">
                                                            <li>
                                                                <a href="javascript:void(0)"  class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th>SNo</th>
                                                        <th>Budget Head <span>*</span></th>
                                                        <th>Line Item</th>
                                                        <th>Sub Line-Item</th>
                                                        <th>Amount (INR) <span>*</span></th>
                                                        <th>Action</th>                                                                                                              
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="metric_more">                                                        
                                                    <td><input type="checkbox" class="form-control"></td>
                                                        <td>
                                                            <select class="form-control" >
                                                                <option>--Select--</option>                                                                
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control" >
                                                                <option>--Select--</option>                                                                
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control" >
                                                                <option>--Select--</option>                                                                
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text"  class="form-control" placeholder="" >                                                            
                                                        </td>                                                        
                                                        <td>
                                                            <a class="deleteMetric" title="Delete Metric" onclick="deleteMetric(316);" href="javascript:void(0)"><i class="fas fa-trash"></i></a>
                                                        </td>
                                                    </tr> 
                                                    <tr class="metric_more">                                                        
                                                        <td><input type="checkbox" class="form-control"></td>
                                                        <td>
                                                            <select class="form-control" >
                                                                <option>--Select--</option>                                                                
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control" >
                                                                <option>--Select--</option>                                                                
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control" >
                                                                <option>--Select--</option>                                                                
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text"  class="form-control" placeholder="" >                                                            
                                                        </td>                                                        
                                                        <td>
                                                            <a class="deleteMetric" title="Delete Metric" onclick="deleteMetric(316);" href="javascript:void(0)"><i class="fas fa-trash"></i></a>
                                                        </td>
                                                    </tr>                                                  
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="text-right">
                                            <ul class="vitals-links">
                                                <li><a href="<?php echo base_url() . 'index.php/user/user_ui/balance_sheet'; ?>" class="vital_yellow_btn">Save Donor Amount</a></li>
                                                <li><a href="<?php echo base_url() . 'index.php/user/user_ui/balance_sheet'; ?>" class="vital_bordered_btn">Cancel</a></li>
                                            </ul>

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

<script>
    // Window Height
    // ---------------------------------------
    $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 230) + 'px'});
        });
</script>

</html>