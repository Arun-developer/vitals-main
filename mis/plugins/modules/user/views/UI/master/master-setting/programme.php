<?php
?>
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
    <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/jquery-bootstrap-scrolling-tabs.css'; ?>">
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
                                <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                                    <h4>Budget</h4>
                                </div>
                                <!-- <div class="col-xl-8 col-lg-8 col-md-12 col-12 text-right">
                                    <ul class="vitals-links">
                                        <li>
                                            <a href="<?php echo base_url() . 'index.php/user/user_ui/add_programme'; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add</a>
                                        </li>
                                        <li class="edit">
                                            <a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                                        <li>
                                            <a href="#" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a>
                                        </li>
                                    </ul>
                                </div> -->
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div>
                                    <div class="newCLickTabs">
                                        <div>
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/user_ui/balance_sheet'; ?>">Balance Sheet</a></li>
                                                <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/user/user_ui/programme'; ?>">Programme</a></li>
                                                <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">Donor</a></li>
                                                <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">Budget Head</a></li>
                                                <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Line Item</a></li>
                                                <li role="presentation"><a href="#tab1" role="tab" data-toggle="tab">Additional Info</a></li>
                                                <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Financial Year</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tab-slider--container tab-content">
                                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
                                                <div class="row leaveLabel">
                                                    <div class="col-xl-7 col-lg-7 col-md-12 col-12 ">
                                                        <ul class="vitals-links">
                                                            <li>
                                                                <div class="form-group">
                                                                    <label>Programme Head</label>
                                                                    <select class="form-control">
                                                                        <option value="">Select</option>
                                                                        <option value="USR293">
                                                                            Abhijit Sathe (IITK) </option>
                                                                        <option value="USR291">
                                                                            Aditya Jahagirdar </option>
                                                                        <option value="USR272">
                                                                            Ananth Aravamudhan </option>
                                                                        <option value="USR271">
                                                                            Anika Pandey </option>
                                                                        <option value="USR252">
                                                                            Anuja Master </option>
                                                                        <option value="USR180">
                                                                            Bangalore VIF </option>
                                                                        <option value="USR325">
                                                                            Beyond Capital </option>
                                                                        <option value="USR306">
                                                                            Bhargava KC </option>
                                                                        <option value="USR231">
                                                                            Binu Mathews </option>
                                                                        <option value="USR032">
                                                                            Chakravarthy A.B </option>
                                                                        <option value="USR179">
                                                                            Daphne Salinas Rodriguez </option>
                                                                        <option value="USR343">
                                                                            Deepa VK </option>
                                                                        <option value="USR282">
                                                                            Deepanshi Balooni </option>
                                                                        <option value="USR244">
                                                                            Gowtham Raju </option>
                                                                        <option value="USR167">
                                                                            Hang Vo </option>
                                                                        <option value="USR122">
                                                                            Heera Jayachandran </option>
                                                                        <option value="USR251">
                                                                            Jenaan Lilani </option>
                                                                        <option value="USR297">
                                                                            Kavya Agarwal </option>
                                                                        <option value="USR298">
                                                                            Kevin Bobby </option>
                                                                        <option value="USR290">
                                                                            Malathy M </option>
                                                                        <option value="USR322">
                                                                            Meenatshi C </option>
                                                                        <option value="USR318">
                                                                            Mehal Poddar </option>
                                                                        <option value="USR224">
                                                                            Mohammad Azhar </option>
                                                                        <option value="USR227">
                                                                            Mohammad Azhar </option>
                                                                        <option value="USR320">
                                                                            Mrinalini V </option>
                                                                        <option value="USR098">
                                                                            Mukesh Sharma </option>
                                                                        <option value="USR030">
                                                                            Murugan M </option>
                                                                        <option value="USR241">
                                                                            Nirupa Rao </option>
                                                                        <option value="USR321">
                                                                            Nivvedhitha Shankar </option>
                                                                        <option value="USR305">
                                                                            Pankaj Anand </option>
                                                                        <option value="USR043">
                                                                            Paul Basil </option>
                                                                        <option value="USR278">
                                                                            Praveen Rajan </option>
                                                                        <option value="USR232">
                                                                            Ragini Pillai </option>
                                                                        <option value="USR323">
                                                                            Ram V </option>
                                                                        <option value="USR229">
                                                                            Rama Kannan </option>
                                                                        <option value="USR283">
                                                                            Rashi . </option>
                                                                        <option value="USR243">
                                                                            Rohit Lalwani </option>
                                                                        <option value="USR315">
                                                                            Saipriya Salla </option>
                                                                        <option value="USR308">
                                                                            Seraphina Selvanayakom </option>
                                                                        <option value="USR286">
                                                                            Shaikh Mobin </option>
                                                                        <option value="USR285">
                                                                            Shankha Lahiri </option>
                                                                        <option value="USR317">
                                                                            Shoma Bhardwaj </option>
                                                                        <option value="USR292">
                                                                            Shreya Agrawal (IITK) </option>
                                                                        <option value="USR289">
                                                                            Siddharth Vashist </option>
                                                                        <option value="USR296">
                                                                            Soujit Das (IIMCIP) </option>
                                                                        <option value="USR259">
                                                                            Srinivas Ramanujam </option>
                                                                        <option value="USR274">
                                                                            Sucharita Kamath </option>
                                                                        <option value="USR242">
                                                                            Sukriti Somvanshi </option>
                                                                        <option value="USR295">
                                                                            Surekha Routray (KIIT) </option>
                                                                        <option value="USR319">
                                                                            Swetha Tipparaju </option>
                                                                        <option value="USR284">
                                                                            Tanuja Kate </option>
                                                                        <option value="USR326">
                                                                            Tanya Agarwal </option>
                                                                        <option value="USR182">
                                                                            Thuy Pham </option>
                                                                        <option value="USR294">
                                                                            Vaibhav Vashishtha (SO) </option>
                                                                        <option value="USR276">
                                                                            Venture Centre, Pune </option>
                                                                        <option value="USR248">
                                                                            Vigneshwaran V </option>
                                                                        <option value="USR119">
                                                                            Vijitha Panikkar </option>
                                                                        <option value="USR240">
                                                                            Vikash Jha </option>
                                                                        <option value="0">Others</option>
                                                                    </select>
                                                                </div>
                                                            </li>
                                                            <li class="pad-lt15px">
                                                                <div class="form-group has-search-right mar-bt8 wdt_180">
                                                                    <a href="#" class="form-control-feedback"><span class="fa fa-search"></span></a>
                                                                    <input type="text" class="form-control" placeholder="Search">
                                                                </div>
                                                            </li>
                                                            <li><span class="vitals_clearSearch">Clear search</span></li>
                                                        </ul>
                                                    </div>

                                                    <div class="col-xl-5 col-lg-5 col-md-12 col-12 text-right">
                                                        <label>&nbsp;</label>
                                                        <ul class="vitals-links">
                                                            <li>
                                                                <a href="<?php echo base_url() . 'index.php/user/user_ui/add_programme'; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add</a>
                                                            </li>
                                                            <li class="edit">
                                                                <a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                                                            <li>
                                                                <a href="#" class="master_deluser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                        <table class="table table-hover dt-responsive">
                                                            <thead>
                                                                <tr>
                                                                    <th class="removeArrow"><input type="checkbox" class="form-control"/></th>
                                                                    <th>Programme</th>
                                                                    <th>Programme Head</th>
                                                                    <th>Donors</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><input type="checkbox" class="form-control"/></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="RAMP Incubation" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="Palamadai Ganapathy" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="TLF, IDRC, TDB" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><select class="form-control" disabled><option>Active</option><option>Inactive</option></select></div></td>
                                                                </tr>  
                                                                <tr>
                                                                    <td><input type="checkbox" class="form-control"/></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="Fellowship" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="Priya Thachadi" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="TLF, Halloran," class="form-control"/></div></td>
                                                                    <td><div class="form-group"><select class="form-control" disabled><option>Active</option><option>Inactive</option></select></div></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox" class="form-control"/></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="Innovator Training & Pre Incubation" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="Sucharita Kamath" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="ANDE," class="form-control"/></div></td>
                                                                    <td><div class="form-group"><select class="form-control" disabled><option>Active</option><option>Inactive</option></select></div></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox" class="form-control"/></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="Knowledge Management" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="Jessica Seddon" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="TLF, IDRC," class="form-control"/></div></td>
                                                                    <td><div class="form-group"><select class="form-control" disabled><option>Active</option><option>Inactive</option></select></div></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox" class="form-control"/></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="I2E, VIF" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="James Rajanayagam" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="HIVOS," class="form-control"/></div></td>
                                                                    <td><div class="form-group"><select class="form-control" disabled><option>Active</option><option>Inactive</option></select></div></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox" class="form-control"/></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="ANDE Chapter" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="Sucharita Kamath" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="ANDE," class="form-control"/></div></td>
                                                                    <td><div class="form-group"><select class="form-control" disabled><option>Active</option><option>Inactive</option></select></div></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox" class="form-control"/></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="Capacity building programme for VLEs" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="Ashutosh Sinha" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="HIVOS" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><select class="form-control" disabled><option>Active</option><option>Inactive</option></select></div></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox" class="form-control"/></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="Villgro Stores" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="Ashutosh Sinha" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="SDTT" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><select class="form-control" disabled><option>Active</option><option>Inactive</option></select></div></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox" class="form-control"/></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="RAMP Incubation" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="Palamadai Ganapathy" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="TLF, IDRC, TDB" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><select class="form-control" disabled><option>Active</option><option>Inactive</option></select></div></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="checkbox" class="form-control"/></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="I2E, VIF" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="James Rajanayagam" class="form-control"/></div></td>
                                                                    <td><div class="form-group"><input type="text" disabled value="HIVOS," class="form-control"/></div></td>
                                                                    <td><div class="form-group"><select class="form-control" disabled><option>Active</option><option>Inactive</option></select></div></td>
                                                                </tr>                                                              
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-end">
                                                    <div class="col-12 col-sm-4  col-md-4 ">
                                                        <div class="text-right">
                                                            <ul class="vitals-links saveLinkView display-hide">
                                                                <li><a href="#" class="vital_yellow_btn">Save Programme</a></li>
                                                                <li><a href="#" class="vital_bordered_btn">Reset</a></li> 
                                                            </ul>                                                    
                                                        </div>
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
<script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-bootstrap-scrolling-tabs.js'; ?>"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
<script src="https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script>
    // Window Height
    // ---------------------------------------
    $(document).ready(function () {
            $('.vital_windowScroll').css({'height': (($(window).height()) - 20) + 'px'});
        });

    $('table').DataTable();

    // table row in a table clickable as a link
    // ---------------------------------------



    (function() {
        'use strict';
        $(activate);

        function activate() {

            $('.nav-tabs')
                .scrollingTabs({
                    enableSwiping: true
                })
                .on('ready.scrtabs', function() {
                    $('.tab-content').show();
                });
        }
    }());
    // Edit Click to remove disabled
    // ---------------------------------------
    $('.summaryEdit').click(function() {
        $("input, select").attr("disabled", false); 
            
            $('li.edit').addClass("activeTabs");        
            $('li.edit a').addClass("greentab");
            $('.saveLinkView').removeClass("display-hide");
            $('.saveLinkView').addClass("display-show");
    })


    
</script>

</html>