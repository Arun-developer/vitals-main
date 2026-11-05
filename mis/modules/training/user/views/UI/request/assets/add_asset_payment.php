<?php ?>
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
                                <li class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/apply_leave'; ?>"><i class="fas fa-sync-alt"></i> Requests</a></li>
                                <!-- <li><a href=""><i class="far fa-check-square"></i> Approve</a></li> -->
                                <li><a href=""><i class="far fa-chart-bar"></i> Portfolio</a></li>
                                <li><a href=""><i class="fas fa-archive"></i> Resources</a></li>
                                <li><a href=""><i class="fas fa-suitcase"></i> Reports</a></li>
                                <li><a href="<?php echo base_url() . 'index.php/user/user_ui/current_holiday_calendar'; ?>"><i class="fas fa-user-friends"></i> Master's</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <br>
                <div class="dataconfig-content page-wrapper vitals_mainContent ">
                    <div class="row">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('UI/request/request_sidemenu.php', array('page' => 'assets_payment')); ?>
                            </div>
                            <div class="footer-link">
                                <p>copyright &copy; mis.villgroapps.org</p>
                            </div>
                        </div>
                        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                            <main class="page-content">
                                <div class="row dataconfig d_v_d_c">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                                        <h4>Edit Asset Payments</h4>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">

                                    </div>
                                </div>
                                <div class="plan-structure-vital vital_windowScroll">
                                    <div class="tab-slider--container">
                                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                            <main class="page-content">
                                                <div class="inputplan-structureall plan-structure-new">
                                                    <div class="row leaveLabel">

                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Asset Number <span>*</span></label>
                                                                <input class="form-control" type="text" placeholder="" value="AST/0008">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Payment Type</label>
                                                                <select class="form-control">
                                                                    <option value="">Select</option>
                                                                    <option value="AMC">AMC</option>
                                                                    <option value="usage" selected="">Usage</option>
                                                                    <option value="repair">Repairs</option>
                                                                    <option value="replace">Replacements</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Payment To (Currenly Under) <span>*</span></label>
                                                                <select class="form-control">
                                                                    <option value="">Select </option>
                                                                    <option value="USR293">
                                                                        Abhijit Sathe (IITK)                    </option>
                                                                    <option value="USR291">
                                                                        Aditya Jahagirdar                    </option>
                                                                    <option value="USR272">
                                                                        Ananth Aravamudhan                    </option>
                                                                    <option value="USR271">
                                                                        Anika Pandey                    </option>
                                                                    <option value="USR252">
                                                                        Anuja Master                    </option>
                                                                    <option value="USR180">
                                                                        Bangalore VIF                    </option>
                                                                    <option value="USR325">
                                                                        Beyond Capital                    </option>
                                                                    <option value="USR306">
                                                                        Bhargava KC                    </option>
                                                                    <option value="USR231">
                                                                        Binu Mathews                    </option>
                                                                    <option value="USR032" selected="">
                                                                        Chakravarthy A.B                    </option>
                                                                    <option value="USR179">
                                                                        Daphne Salinas Rodriguez                    </option>
                                                                    <option value="USR343">
                                                                        Deepa VK                    </option>
                                                                    <option value="USR282">
                                                                        Deepanshi Balooni                    </option>
                                                                    <option value="USR244">
                                                                        Gowtham Raju                    </option>
                                                                    <option value="USR167">
                                                                        Hang Vo                    </option>
                                                                    <option value="USR122">
                                                                        Heera Jayachandran                    </option>
                                                                    <option value="USR251">
                                                                        Jenaan Lilani                    </option>
                                                                    <option value="USR297">
                                                                        Kavya Agarwal                    </option>
                                                                    <option value="USR298">
                                                                        Kevin Bobby                    </option>
                                                                    <option value="USR290">
                                                                        Malathy M                    </option>
                                                                    <option value="USR322">
                                                                        Meenatshi C                    </option>
                                                                    <option value="USR318">
                                                                        Mehal Poddar                    </option>
                                                                    <option value="USR224">
                                                                        Mohammad Azhar                    </option>
                                                                    <option value="USR227">
                                                                        Mohammad Azhar                    </option>
                                                                    <option value="USR320">
                                                                        Mrinalini V                    </option>
                                                                    <option value="USR098">
                                                                        Mukesh Sharma                    </option>
                                                                    <option value="USR030">
                                                                        Murugan M                    </option>
                                                                    <option value="USR241">
                                                                        Nirupa Rao                    </option>
                                                                    <option value="USR321">
                                                                        Nivvedhitha Shankar                    </option>
                                                                    <option value="USR305">
                                                                        Pankaj Anand                    </option>
                                                                    <option value="USR043">
                                                                        Paul Basil                    </option>
                                                                    <option value="USR278">
                                                                        Praveen Rajan                    </option>
                                                                    <option value="USR232">
                                                                        Ragini Pillai                    </option>
                                                                    <option value="USR323">
                                                                        Ram V                    </option>
                                                                    <option value="USR229">
                                                                        Rama Kannan                    </option>
                                                                    <option value="USR283">
                                                                        Rashi .                    </option>
                                                                    <option value="USR243">
                                                                        Rohit Lalwani                    </option>
                                                                    <option value="USR315">
                                                                        Saipriya Salla                    </option>
                                                                    <option value="USR308">
                                                                        Seraphina Selvanayakom                    </option>
                                                                    <option value="USR286">
                                                                        Shaikh Mobin                    </option>
                                                                    <option value="USR285">
                                                                        Shankha Lahiri                    </option>
                                                                    <option value="USR317">
                                                                        Shoma Bhardwaj                    </option>
                                                                    <option value="USR292">
                                                                        Shreya Agrawal (IITK)                    </option>
                                                                    <option value="USR289">
                                                                        Siddharth Vashist                    </option>
                                                                    <option value="USR296">
                                                                        Soujit Das (IIMCIP)                    </option>
                                                                    <option value="USR259">
                                                                        Srinivas Ramanujam                    </option>
                                                                    <option value="USR274">
                                                                        Sucharita Kamath                    </option>
                                                                    <option value="USR242">
                                                                        Sukriti Somvanshi                    </option>
                                                                    <option value="USR295">
                                                                        Surekha Routray (KIIT)                    </option>
                                                                    <option value="USR319">
                                                                        Swetha Tipparaju                    </option>
                                                                    <option value="USR284">
                                                                        Tanuja Kate                    </option>
                                                                    <option value="USR326">
                                                                        Tanya Agarwal                    </option>
                                                                    <option value="USR182">
                                                                        Thuy Pham                    </option>
                                                                    <option value="USR294">
                                                                        Vaibhav Vashishtha (SO)                    </option>
                                                                    <option value="USR276">
                                                                        Venture Centre, Pune                    </option>
                                                                    <option value="USR248">
                                                                        Vigneshwaran V                    </option>
                                                                    <option value="USR119">
                                                                        Vijitha Panikkar                    </option>
                                                                    <option value="USR240">
                                                                        Vikash Jha                    </option>
                                                                    <option value="0">Others</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row leaveLabel">

                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Ceiling Amount <span>*</span></label>
                                                                <input class="form-control" type="text" placeholder="" value="551">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
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
                                                                    <option value="1589">funder donorr</option>
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
                                                                    <option value="1274">TDB-INVENT  Mgt Fees</option>
                                                                    <option value="1568">TDB_2</option>
                                                                    <option value="1475">TDB_Old</option>
                                                                    <option value="5" selected="">TLF</option>
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
                                                                    <option value="0">Others</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Budget Head<span>*</span></label>
                                                                <select class="form-control">
                                                                    <option value="850">Allocation of Vif Mgmt Salary</option>
                                                                    <option value="498">Design</option>
                                                                    <option value="1047">Events and conferences</option>
                                                                    <option value="1063">Fixed Assets</option>
                                                                    <option value="868">Funding to Incubatees</option>
                                                                    <option value="21">Incubation</option>
                                                                    <option value="1170">Incubation-Agri</option>
                                                                    <option value="1171">Incubation-Edu</option>
                                                                    <option value="1172">Incubation-Health</option>
                                                                    <option value="1064">International travel</option>
                                                                    <option value="1173">INVENT</option>
                                                                    <option value="26">Marketing</option>
                                                                    <option value="1061">Memberships</option>
                                                                    <option value="1496">MIS &amp; Websites</option>
                                                                    <option value="891">Other Direct Expense - Prototyping Cost</option>
                                                                    <option value="833">Other Direct Expenses</option>
                                                                    <option value="1049">Overheads</option>
                                                                    <option value="1043">Payment to experts</option>
                                                                    <option value="694">Payments to experts</option>
                                                                    <option value="681">Personnel</option>
                                                                    <option value="24">Replication</option>
                                                                    <option value="20">Scouting</option>
                                                                    <option value="1062">Subscriptions</option>
                                                                    <option value="1174">TAP</option>
                                                                    <option value="499">Travel</option>
                                                                    <option value="772">Travel and stay</option>
                                                                    <option value="292">Unconvention</option>
                                                                    <option value="1485">VRIC</option>
                                                                    <option value="0" selected="">Others</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row leaveLabel">
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Others </label>
                                                                <input class="form-control" type="text" placeholder="" value="HR COMMUNICATION" >
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Line Item <span>*</span></label>
                                                                <select class="form-control">
                                                                    <option value="0" selected="">Others</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Others </label>
                                                                <input class="form-control" type="text" placeholder="" >
                                                            </div>
                                                        </div>



                                                    </div>
                                                    <div class="row leaveLabel">
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Sub-line Item</label>
                                                                <select class="form-control">
                                                                    <option value="">Select</option>
                                                                    <option value="372">16PF test</option>
                                                                    <option value="332">Accounting and Auditing/Accounting Services Fees</option>
                                                                    <option value="333">Accounting and Auditing/Filing Charges</option>
                                                                    <option value="331">Accounting and Auditing/Statutory Audit Fees</option>
                                                                    <option value="449">Accounts</option>
                                                                    <option value="342">Ad consultant fees</option>
                                                                    <option value="862">Allocation of Vif Mgmt Salary</option>
                                                                    <option value="863">Allocation of Vif Mgmt Salary</option>
                                                                    <option value="864">Allocation of Vif Mgmt Salary</option>
                                                                    <option value="865">Allocation of Vif Mgmt Salary</option>
                                                                    <option value="866">Allocation of Vif Mgmt Salary</option>
                                                                    <option value="867">Allocation of Vif Mgmt Salary</option>
                                                                    <option value="876">Allocation of Vif Mgmt Salary</option>
                                                                    <option value="325">Assets/Furnishing</option>
                                                                    <option value="323">Assets/Insurance Premium</option>
                                                                    <option value="447">Associate Admin </option>
                                                                    <option value="461">Associate Admin </option>
                                                                    <option value="435">Associate, Learning</option>
                                                                    <option value="437">Associate, Process Management</option>
                                                                    <option value="442">Associate-Incubation</option>
                                                                    <option value="458">Associate-Incubation</option>
                                                                    <option value="459">Associate-Incubation &amp; MIS</option>
                                                                    <option value="445">Associate-Process Management</option>
                                                                    <option value="462">Audit out-of-pocket expenses</option>
                                                                    <option value="322">Bank Charges</option>
                                                                    <option value="338">Board of Directors/Honararium to board members</option>
                                                                    <option value="337">Board of Directors/Meeting Hall and Lunch expenses</option>
                                                                    <option value="336">Board of Directors/Travel expenses &amp; Stay</option>
                                                                    <option value="424">Books &amp; periodicals</option>
                                                                    <option value="431">Case Studies</option>
                                                                    <option value="439">CEO</option>
                                                                    <option value="456">CEO</option>
                                                                    <option value="463">Communication Materials</option>
                                                                    <option value="415">Computers &amp; Software</option>
                                                                    <option value="536">Consultancy fees</option>
                                                                    <option value="352">Consultant Assignment </option>
                                                                    <option value="515">Contingency</option>
                                                                    <option value="738">Cost of hiring Interns</option>
                                                                    <option value="742">Cost of hiring Interns</option>
                                                                    <option value="743">Cost of hiring Interns</option>
                                                                    <option value="517">Diligence Vists</option>
                                                                    <option value="432">Dissemination workshops</option>
                                                                    <option value="434">Domestic travel/Conduct Research/Attend Conferences/Networking</option>
                                                                    <option value="306">Due Diligence</option>
                                                                    <option value="318">electricity</option>
                                                                    <option value="419">Electricity</option>
                                                                    <option value="348">Event Management </option>
                                                                    <option value="470">Fellows-Stipend</option>
                                                                    <option value="373">Fellows-Stipend +Other Expenses</option>
                                                                    <option value="416">Furnishing</option>
                                                                    <option value="514">Graduation Ceremony</option>
                                                                    <option value="522">GSBI</option>
                                                                    <option value="446">Head -Admin/Process</option>
                                                                    <option value="460">Head -Admin/Process</option>
                                                                    <option value="444">Head- Innovation Ecosystem</option>
                                                                    <option value="448">HR</option>
                                                                    <option value="465">HR Communication</option>
                                                                    <option value="467">HR Outsourcing Fees</option>
                                                                    <option value="350">Hubs</option>
                                                                    <option value="382">iCats Platform</option>
                                                                    <option value="307">Impact Assessment</option>
                                                                    <option value="429">Impact Assessment</option>
                                                                    <option value="518">In-residence Sessions</option>
                                                                    <option value="528">In-residence Sessions</option>
                                                                    <option value="308">Incubatee capacity building  </option>
                                                                    <option value="329">Information system</option>
                                                                    <option value="539">Information System</option>
                                                                    <option value="453">Insurance</option>
                                                                    <option value="328">Leased line rentals</option>
                                                                    <option value="423">Local Conveyance</option>
                                                                    <option value="524">Marketing</option>
                                                                    <option value="345">Marketing &amp; Collaterals</option>
                                                                    <option value="469">Marketing /Partnership Costs</option>
                                                                    <option value="441">Marketing and Communications</option>
                                                                    <option value="485">Marketing Collaterals</option>
                                                                    <option value="487">Marketing Collaterals</option>
                                                                    <option value="491">Marketing Collaterals</option>
                                                                    <option value="381">Marketing/Partnership costs</option>
                                                                    <option value="753">Mentor Honorarium</option>
                                                                    <option value="754">Mentor Honorarium</option>
                                                                    <option value="761">Mentor honorarium</option>
                                                                    <option value="764">Mentor Honorarium</option>
                                                                    <option value="765">Mentor Honorarium</option>
                                                                    <option value="305">Mentoring Fund from the Foundation</option>
                                                                    <option value="349">Mini Unconventions</option>
                                                                    <option value="433">Minor Support/Guest Speaker/Track Student	</option>
                                                                    <option value="335">Miscellaneous Expenses</option>
                                                                    <option value="452">Miscellaneous expenses</option>
                                                                    <option value="495">Miscellaneous Expenses</option>
                                                                    <option value="344">New media</option>
                                                                    <option value="440">NEW/SCALE</option>
                                                                    <option value="422">Office Maintaince</option>
                                                                    <option value="531">Overheads at Villgro, operating centre of SEED</option>
                                                                    <option value="417">Parking Charges</option>
                                                                    <option value="759">Partnerships</option>
                                                                    <option value="760">Partnerships</option>
                                                                    <option value="304">Patent Search</option>
                                                                    <option value="756">Payment to SELCO </option>
                                                                    <option value="769">Payments to experts</option>
                                                                    <option value="770">Payments to experts</option>
                                                                    <option value="771">Payments to experts</option>
                                                                    <option value="618">Personnel</option>
                                                                    <option value="526">Platform</option>
                                                                    <option value="427">Postage</option>
                                                                    <option value="428">Printing &amp; stationery</option>
                                                                    <option value="757">Recruitment Cost (Hiring Agency)</option>
                                                                    <option value="758">Recruitment Cost (Hiring Agency)</option>
                                                                    <option value="747">Research</option>
                                                                    <option value="748">Research</option>
                                                                    <option value="749">Research</option>
                                                                    <option value="436">Research Administrator</option>
                                                                    <option value="513">Salary</option>
                                                                    <option value="364">Seed Fund</option>
                                                                    <option value="374">Selection Cost, Travel and Boarding  for Induction, Review, PDP sessions</option>
                                                                    <option value="527">Selection Panel</option>
                                                                    <option value="516">Selection Panelists</option>
                                                                    <option value="454">Senior Advisor</option>
                                                                    <option value="312">Setting up a Network of Social Enterprise Incubators</option>
                                                                    <option value="744">Speaker Coaching</option>
                                                                    <option value="745">Speaker Coaching</option>
                                                                    <option value="746">Speaker Coaching</option>
                                                                    <option value="486">Speakers/Resource Person</option>
                                                                    <option value="488">Speakers/Resource Person</option>
                                                                    <option value="492">Speakers/Resource Person</option>
                                                                    <option value="443">Sr.Associate-strategic partnership</option>
                                                                    <option value="451">Staff Travel</option>
                                                                    <option value="353">Staffing ( Fellow)</option>
                                                                    <option value="313">Staffing at Villgro</option>
                                                                    <option value="311">Staffing at XIMB Manji</option>
                                                                    <option value="483">Steering Committee Meeting</option>
                                                                    <option value="370">Stipend Intern</option>
                                                                    <option value="411">Stipend Intern</option>
                                                                    <option value="310">Strategy &amp; Tool Kit Development </option>
                                                                    <option value="450">Support Team</option>
                                                                    <option value="438">Team Leader, Knowledge Management</option>
                                                                    <option value="750">Technology (Website design, online application)</option>
                                                                    <option value="751">Technology (Website design, online application)</option>
                                                                    <option value="752">Technology (Website design, online application)</option>
                                                                    <option value="755">Technology (Website design, online application)</option>
                                                                    <option value="739">test</option>
                                                                    <option value="740">test</option>
                                                                    <option value="741">test</option>
                                                                    <option value="430">Training for Project staff related implement of research activities	</option>
                                                                    <option value="347">Travel &amp; Accommodation </option>
                                                                    <option value="617">Travel and Stay</option>
                                                                    <option value="791">Travel and stay</option>
                                                                    <option value="792">Travel and stay</option>
                                                                    <option value="534">Unconvention Finale</option>
                                                                    <option value="315">Utilities/building main</option>
                                                                    <option value="316">Utilities/Parking charges</option>
                                                                    <option value="314">Utilities/Rent</option>
                                                                    <option value="317">Utilities/Water</option>
                                                                    <option value="330">Videoconferencing</option>
                                                                    <option value="523">Vists to Enterprises</option>
                                                                    <option value="421">water</option>
                                                                    <option value="762">Webinar Content Development</option>
                                                                    <option value="763">Webinar Content Development</option>
                                                                    <option value="484">Website</option>
                                                                    <option value="343">Website maintenance costs</option>
                                                                    <option value="0" selected="">Others</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Others</label>
                                                                <input class="form-control" type="text" placeholder="" >
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Vendor <span>*</span></label>
                                                                <select class="form-control">
                                                                    <option value="">Select</option>
                                                                    <option value="14">
                                                                        Airtel                    </option>
                                                                    <option value="22">
                                                                        All Seasons                    </option>
                                                                    <option value="21">
                                                                        Alternate lighting                    </option>
                                                                    <option value="15">
                                                                        ARAMARK PATMAN SERVICES PVT LTD                    </option>
                                                                    <option value="18">
                                                                        Ashwin Engineers                    </option>
                                                                    <option value="10">
                                                                        Classica Graphix                    </option>
                                                                    <option value="16">
                                                                        E Net Tek India Pvt Ltd                    </option>
                                                                    <option value="28">
                                                                        EUREKA FORBES LIMITED                    </option>
                                                                    <option value="19">
                                                                        Gemini Communication                    </option>
                                                                    <option value="5">
                                                                        Ginger Hotels                    </option>
                                                                    <option value="17">
                                                                        Gokul Cabs                    </option>
                                                                    <option value="31">
                                                                        Icon Techsolution                    </option>
                                                                    <option value="6">
                                                                        IITM Research Park                    </option>
                                                                    <option value="4">
                                                                        MBC Travels                    </option>
                                                                    <option value="2">
                                                                        P.K. Air Travel                    </option>
                                                                    <option value="26">
                                                                        PC in world                    </option>
                                                                    <option value="27">
                                                                        PeopleLink Corporate Solutions Pvt, Ltd                    </option>
                                                                    <option value="7">
                                                                        Professional Courier                    </option>
                                                                    <option value="3" selected="">
                                                                        Reliance                    </option>
                                                                    <option value="8">
                                                                        Repute                    </option>
                                                                    <option value="9">
                                                                        Sai Baba Document Solution (P) Ltd                    </option>
                                                                    <option value="13">
                                                                        Sathya Tourism                    </option>
                                                                    <option value="12">
                                                                        Stationery Poin                    </option>
                                                                    <option value="35">
                                                                        TATA DOCOMO                    </option>
                                                                    <option value="11">
                                                                        Tata Indicom                    </option>
                                                                    <option value="20">
                                                                        Thomas Cook                    </option>
                                                                    <option value="29">
                                                                        Univercell                    </option>
                                                                    <option value="25">
                                                                        V-cube Technlogies                     </option>
                                                                    <option value="24">
                                                                        Veroni systems                    </option>
                                                                    <option value="32">
                                                                        Vodafone                    </option>
                                                                    <option value="23">
                                                                        Zebro officemate                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row leaveLabel">
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Payment Period From <span>*</span></label>
                                                                <input class="form-control" type="text" placeholder="" value="25/01/2011" >
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Payment Period To <span>*</span></label>
                                                                <input class="form-control" type="text" placeholder="" value="25/01/2011" >
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Bill Date<span>*</span></label>
                                                                <input class="form-control" type="text" placeholder="" value="25/01/2011">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row leaveLabel">
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Bill Number </label>
                                                                <input class="form-control" type="text" placeholder="" value="323599973432" >
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div class="form-group">
                                                                <label>Amount <span>*</span></label>
                                                                <input class="form-control" type="text" placeholder="" value="550" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row leaveLabel">
                                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                                            <div style="height: 15px;"></div>
                                                            <ul class="vitals-links">
                                                                <li><a href="" class="vital_yellow_btn pad-hr15">Save Payment</a></li>
                                                                <li><a href="<?= base_url() . 'index.php/user/user_ui/assets_paymenT'; ?>"><span class="vitals_clearSearch">Back</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>


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
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/main-popper.min.js'; ?>" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.min.js'; ?>"></script>
    <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script><script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <script>
        $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 190) + 'px'});
        });

        $('table').DataTable();

        // table row in a table clickable as a link
        // ---------------------------------------

        jQuery(document).ready(function ($) {
            $(".clickable-row").click(function () {
                window.location = $(this).data("href");
            });
        });


    </script>

</html>