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
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/js/ui.multiselect.js'; ?>">
    <link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">    
    <!-- <script src="<?php echo base_url() . 'source/portfolio_assets/css/toastr.min.css'; ?>"> -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/plugins/localisation/jquery.localisation-min.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/plugins/scrollTo/jquery.scrollTo-min.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/ui.multiselect.js'; ?>"></script>
<script type="text/javascript">
		$(function(){
			$.localise('ui-multiselect', {/*language: 'en',*/ path: 'js/locale/'});
			$(".multiselect").multiselect();
			$('#switcher').themeswitcher();
		});
	</script>
</head>

<body>
    <div class="fixed-headervi">
        <?php $this->load->view('UI/header1.php'); ?>
    </div>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">
            <div class="dataconfig-content page-wrapper vitals_mainContent ">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('UI/master/master_sidemenu.php', array('page' => 'incubation_US')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                    <h4>Inbation Master - User Setup</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <form name="signup" class="form" novalidate>
                                                    <div class="row leaveLabel">
                                                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Partner</label>
                                                                <select class="form-control">
                                                                    <option>Select Partner</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row leaveLabel">
                                                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>CEO</label>
                                                                <select class="form-control">
                                                                    <option>Select</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row leaveLabel">
                                                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Chief Incubation Officer</label>
                                                                <select class="form-control">
                                                                    <option></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row leaveLabel">
                                                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                            <label>Incubation Committee Members</label>
                                                            <div class="userSetupAddInc">
                                                                <div class="form-group has-search-right mar-bt8 ">
                                                                    <a href="#" class="form-control-feedback"><span class="fa fa-search"></span></a>
                                                                    <input type="text" class="form-control" placeholder="Search">
                                                                </div>
                                                                <ul class="button_incclr">
                                                                    <li><a href="" class="grnIncbtn">Add All</a></li>
                                                                    <li><a href="" class="grnIncbtn">Clear</a></li>
                                                                </ul>
                                                                <ul class="list_incuserSet AddincSet">
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Chakravarthy A.B</label></div>

                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Paul Basil</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Heera Jayachandran</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Arunkumar Venkatesan</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Mohammad Azhar</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Binu Mathews</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Ragini Pillai</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Vikash Jha</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Nirupa Rao</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Rohit Lalwani</label></div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                            <label>&nbsp;</label>
                                                            <div class="userSetupRmvInc">
                                                                <div class="form-group has-search-right mar-bt8 ">
                                                                    <a href="#" class="form-control-feedback"><span class="fa fa-search"></span></a>
                                                                    <input type="text" class="form-control" placeholder="Search">
                                                                </div>
                                                                <ul class="button_incclr">
                                                                    <li><a href="" class="grnIncbtn">Remove All</a></li>
                                                                    <li><a href="" class="grnIncbtn">Clear</a></li>
                                                                </ul>
                                                                <ul class="list_incuserSet AddincSet">
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Chakravarthy A.B</label></div>

                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Paul Basil</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Heera Jayachandran</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Arunkumar Venkatesan</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Mohammad Azhar</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Binu Mathews</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Ragini Pillai</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Vikash Jha</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Nirupa Rao</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Rohit Lalwani</label></div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="height: 15px;"></div>
                                                    <div class="row leaveLabel">
                                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 userSetupA_Rbox">
                                                            <label>Associate: Business Incubation</label>
                                                            <!-- <div class="userSetupAddInc">
                                                                <div class="form-group has-search-right mar-bt8 ">
                                                                    <a href="#" class="form-control-feedback"><span class="fa fa-search"></span></a>
                                                                    <input type="text" class="form-control" placeholder="Search">
                                                                </div>
                                                                <ul class="button_incclr">
                                                                    <li><a href="" class="grnIncbtn">Add All</a></li>
                                                                    <li><a href="" class="grnIncbtn">Clear</a></li>
                                                                </ul>
                                                                <ul class="list_incuserSet AddincSet">
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Chakravarthy A.B</label></div>

                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Paul Basil</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Heera Jayachandran</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Arunkumar Venkatesan</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Mohammad Azhar</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Binu Mathews</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Ragini Pillai</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Vikash Jha</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Nirupa Rao</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Rohit Lalwani</label></div>
                                                                    </li>
                                                                </ul>
                                                            </div> -->
                                                            <form action="index.html">
      <select id="countries" class="multiselect" multiple="multiple" name="countries[]">
        <option value="AFG">Afghanistan</option>
        <option value="ALB">Albania</option>
        <option value="DZA">Algeria</option>
        <option value="AND">Andorra</option>
        <option value="ARG">Argentina</option>
        <option value="ARM">Armenia</option>
        <option value="ABW">Aruba</option>
        <option value="AUS">Australia</option>
        <option value="AUT" selected="selected">Austria</option>

        <option value="AZE">Azerbaijan</option>
        <option value="BGD">Bangladesh</option>
        <option value="BLR">Belarus</option>
        <option value="BEL">Belgium</option>
        <option value="BIH">Bosnia and Herzegovina</option>
        <option value="BRA">Brazil</option>
        <option value="BRN">Brunei</option>
        <option value="BGR">Bulgaria</option>
        <option value="CAN">Canada</option>

        <option value="CHN">China</option>
        <option value="COL">Colombia</option>
        <option value="HRV">Croatia</option>
        <option value="CYP">Cyprus</option>
        <option value="CZE">Czech Republic</option>
        <option value="DNK">Denmark</option>
        <option value="EGY">Egypt</option>
        <option value="EST">Estonia</option>
        <option value="FIN">Finland</option>

        <option value="FRA">France</option>
        <option value="GEO">Georgia</option>
        <option value="DEU" selected="selected">Germany</option>
        <option value="GRC">Greece</option>
        <option value="HKG">Hong Kong</option>
        <option value="HUN">Hungary</option>
        <option value="ISL">Iceland</option>
        <option value="IND">India</option>
        <option value="IDN">Indonesia</option>

        <option value="IRN">Iran</option>
        <option value="IRL">Ireland</option>
        <option value="ISR">Israel</option>
        <option value="ITA">Italy</option>
        <option value="JPN">Japan</option>
        <option value="JOR">Jordan</option>
        <option value="KAZ">Kazakhstan</option>
        <option value="KWT">Kuwait</option>
        <option value="KGZ">Kyrgyzstan</option>

        <option value="LVA">Latvia</option>
        <option value="LBN">Lebanon</option>
        <option value="LIE">Liechtenstein</option>
        <option value="LTU">Lithuania</option>
        <option value="LUX">Luxembourg</option>
        <option value="MAC">Macau</option>
        <option value="MKD">Macedonia</option>
        <option value="MYS">Malaysia</option>
        <option value="MLT">Malta</option>

        <option value="MEX">Mexico</option>
        <option value="MDA">Moldova</option>
        <option value="MNG">Mongolia</option>
        <option value="NLD" selected="selected">Netherlands</option>
        <option value="NZL">New Zealand</option>
        <option value="NGA">Nigeria</option>
        <option value="NOR">Norway</option>
        <option value="PER">Peru</option>
        <option value="PHL">Philippines</option>

        <option value="POL">Poland</option>
        <option value="PRT">Portugal</option>
        <option value="QAT">Qatar</option>
        <option value="ROU">Romania</option>
        <option value="RUS">Russia</option>
        <option value="SMR">San Marino</option>
        <option value="SAU">Saudi Arabia</option>
        <option value="CSG">Serbia and Montenegro</option>
        <option value="SGP">Singapore</option>

        <option value="SVK">Slovakia</option>
        <option value="SVN">Slovenia</option>
        <option value="ZAF">South Africa</option>
        <option value="KOR">South Korea</option>
        <option value="ESP">Spain</option>
        <option value="LKA">Sri Lanka</option>
        <option value="SWE">Sweden</option>
        <option value="CHE">Switzerland</option>
        <option value="SYR">Syria</option>

        <option value="TWN">Taiwan</option>
        <option value="TJK">Tajikistan</option>
        <option value="THA">Thailand</option>
        <option value="TUR">Turkey</option>
        <option value="TKM">Turkmenistan</option>
        <option value="UKR">Ukraine</option>
        <option value="ARE">United Arab Emirates</option>
        <option value="GBR">United Kingdom</option>
        <option value="USA" selected="selected">United States</option>

        <option value="UZB">Uzbekistan</option>
        <option value="VAT">Vatican City</option>
        <option value="VNM">Vietnam</option>
      </select>
    </form>
                                                        </div>
                                                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                            <label>&nbsp;</label>
                                                            <div class="userSetupRmvInc">
                                                                <div class="form-group has-search-right mar-bt8 ">
                                                                    <a href="#" class="form-control-feedback"><span class="fa fa-search"></span></a>
                                                                    <input type="text" class="form-control" placeholder="Search">
                                                                </div>
                                                                <ul class="button_incclr">
                                                                    <li><a href="" class="grnIncbtn">Remove All</a></li>
                                                                    <li><a href="" class="grnIncbtn">Clear</a></li>
                                                                </ul>
                                                                <ul class="list_incuserSet AddincSet">
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Chakravarthy A.B</label></div>

                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Paul Basil</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Heera Jayachandran</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Arunkumar Venkatesan</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Mohammad Azhar</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Binu Mathews</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Ragini Pillai</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Vikash Jha</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Nirupa Rao</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Rohit Lalwani</label></div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="height: 15px;"></div>
                                                    <div class="row leaveLabel">
                                                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                            <label>Finance Members</label>
                                                            <div class="userSetupAddInc">
                                                                <div class="form-group has-search-right mar-bt8 ">
                                                                    <a href="#" class="form-control-feedback"><span class="fa fa-search"></span></a>
                                                                    <input type="text" class="form-control" placeholder="Search">
                                                                </div>
                                                                <ul class="button_incclr">
                                                                    <li><a href="" class="grnIncbtn">Add All</a></li>
                                                                    <li><a href="" class="grnIncbtn">Clear</a></li>
                                                                </ul>
                                                                <ul class="list_incuserSet AddincSet">
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Chakravarthy A.B</label></div>

                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Paul Basil</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Heera Jayachandran</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Arunkumar Venkatesan</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Mohammad Azhar</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Binu Mathews</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Ragini Pillai</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Vikash Jha</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Nirupa Rao</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-plus-square"></i>
                                                                            <label>Rohit Lalwani</label></div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                            <label>&nbsp;</label>
                                                            <div class="userSetupRmvInc">
                                                                <div class="form-group has-search-right mar-bt8 ">
                                                                    <a href="#" class="form-control-feedback"><span class="fa fa-search"></span></a>
                                                                    <input type="text" class="form-control" placeholder="Search">
                                                                </div>
                                                                <ul class="button_incclr">
                                                                    <li><a href="" class="grnIncbtn">Remove All</a></li>
                                                                    <li><a href="" class="grnIncbtn">Clear</a></li>
                                                                </ul>
                                                                <ul class="list_incuserSet AddincSet">
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Chakravarthy A.B</label></div>

                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Paul Basil</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Heera Jayachandran</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Arunkumar Venkatesan</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Mohammad Azhar</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Binu Mathews</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Ragini Pillai</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Vikash Jha</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Nirupa Rao</label></div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <i class="far fa-minus-square"></i>
                                                                            <label>Rohit Lalwani</label></div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="height: 15px;"></div>
                                                    <div class="row leaveLabel">
                                                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Pre - Incubation Committee</label>
                                                                <input class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div>
                                                            <ul class="vitals-links">
                                                                <li><button id="showtoast" type="submit" class="vital_yellow_btn wdt_100">Save</button></li>
                                                                <li><a href="<?php echo base_url() . 'index.php/user/user_ui/reject_reason'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </main>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script>
    // Window Height
    // ---------------------------------------
    $(document).ready(function() {
        $('.vital_windowScroll').css({
            'height': (($(window).height()) - 190) + 'px'
        });
    });    
</script>



</html>