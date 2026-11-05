<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Villgro MIS</title>

    </head>

    <body>
        <?php
        $innovation = $get_innovation[0];
        $master_data = $company_data[0];

        $company_name = isset($master_data) ? $master_data['name'] : $innovation['name_of_enterprise'];
        $reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];

        $this->load->view('port_header.php', array('page_title' => 'Plan Setup', 'company_name' => $company_name, 'reg_city' => $reg_city, 'sector_name' => $sector_name));
        ?>

        <!-- Inner Dashboard-->
        <div class="vi-dashboard onboardtabmenu">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link filled-data" id="nav-Companymaster-tab"  href="<?= base_url() . 'index.php/portfolio/company_data/' . $innovation_id; ?>"  aria-selected="false">Company Master Data</a>
                                <a class="nav-item nav-link filled-data" id="nav-business-tab" href="<?= base_url() . 'index.php/portfolio/business_nature/' . $innovation_id; ?>" aria-controls="nav-business" aria-selected="false">Nature of business</a>
                                <a class="nav-item nav-link filled-data" id="nav-management-tab"  href="<?= base_url() . 'index.php/portfolio/management/' . $innovation_id; ?>" aria-controls="nav-management" aria-selected="false">Management</a>
                                <a class="nav-item nav-link filled-data" id="nav-governance-tab"  href="<?= base_url() . 'index.php/portfolio/governance/' . $innovation_id; ?>" aria-controls="nav-governance" aria-selected="false">Governance</a>
                                <a class="nav-item nav-link filled-data" id="nav-relationship-tab" href="<?= base_url() . 'index.php/portfolio/villgro_relationship/' . $innovation_id; ?>" aria-controls="nav-relationship" aria-selected="false">Villgro Relationship Details</a>
                                <a class="nav-item nav-link filled-data" id="nav-incubation-tab" href="<?= base_url() . 'index.php/portfolio/incubation_relationship/' . $innovation_id; ?>"   aria-controls="nav-incubation" aria-selected="false">Management</a>
                                <a class="nav-item nav-link filled-data" id="nav-cap-tab" href="<?= base_url() . 'index.php/portfolio/cap_table/' . $innovation_id; ?>"   aria-controls="nav-cap" aria-selected="false">Cap Table</a>
                                <a class="nav-item nav-link filled-data" id="nav-interested-tab" href="<?= base_url() . 'index.php/portfolio/interested_parties/' . $innovation_id; ?>" aria-controls="nav-interested" aria-selected="false">Other Interested Parties</a>
                                <a class="nav-item nav-link brd-none" id="nav-about-tab"  href="#nav-about"  aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                                <a class="nav-item nav-link dataConfig active" id="nav-dataconfig-tab"  href="#nav-dataconfig" role="tab" aria-controls="nav-dataconfig" aria-selected="false">Plan Setup</a>
                            </div>
                        </nav>
                        <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-business" role="tabpanel" aria-labelledby="nav-business-tab">
                                <div class="tabpanel-title">
                                    <div class="row">
                                        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-9">
                                            <h4>Configure your data</h4>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-3 text-center">
                                            <a class="saveContinue" data-toggle="modal" data-target="#exampleModal">Save &amp; Continue</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabpanel-details config-wrapper page-wrapper chiller-theme">
                                    <nav id="sidebar" data-topbar data-options="scrolltop:false" class="sidebar-wrapper top-bar">
                                        <div class="sidebar-content">
                                            <div class="sidebar-menu">
                                                <ul>
                                                    <li class="sidebar-dropdown">
                                                        <a href="#">
                                                            <i class="fa fa-tachometer-alt"></i>
                                                            <span>Sales &amp; Pipeline</span>
                                                        </a>
                                                        <div class="sidebar-submenu">
                                                            <ul>
                                                                <li>
                                                                    <a href="#">Sales</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Channel</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Pipeline</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li class="sidebar-dropdown">
                                                        <a href="#">
                                                            <i class="fa fa-shopping-cart"></i>
                                                            <span>Finance &amp; Fundraise</span>
                                                        </a>
                                                        <div class="sidebar-submenu">
                                                            <ul>
                                                                <li>
                                                                    <a href="#">Revenue</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Net Profit</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">VIF Funding</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Fundraise</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li class="sidebar-dropdown">
                                                        <a href="#">
                                                            <i class="far fa-gem"></i>
                                                            <span>Team, TAP &amp; Mentors</span>
                                                        </a>
                                                        <div class="sidebar-submenu">
                                                            <ul>
                                                                <li>
                                                                    <a href="#">Mentors</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">TAP</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Partnerships(Non-TAP)</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li class="sidebar-dropdown">
                                                        <a href="#">
                                                            <i class="fa fa-chart-line"></i>
                                                            <span>DP &amp; Board meetings</span>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-dropdown">
                                                        <a href="#">
                                                            <i class="fa fa-chart-line"></i>
                                                            <span>Impact</span>
                                                        </a>
                                                    </li>
                                                    <li class="sidebar-dropdown">
                                                        <a href="#">
                                                            <i class="fa fa-globe"></i>
                                                            <span>Project</span>
                                                        </a>
                                                        <div class="sidebar-submenu">
                                                            <ul>
                                                                <li class="inner-dropdown">
                                                                    <a href="#">Milestone 1</a>
                                                                    <div class="inner-submenu">
                                                                        <ul>
                                                                            <li><a href="">Task 1</a></li>
                                                                            <li><a href="">Task 2</a></li>
                                                                            <li><a href="">Task 3</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                                <li class="sidebar-dropdown">
                                                                    <a href="#">Milestone 2</a>
                                                                    <div class="sidebar-submenu">
                                                                        <ul>
                                                                            <li><a href="">Task 1</a></li>
                                                                            <li><a href="">Task 2</a></li>
                                                                            <li><a href="">Task 3</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                            <!-- sidebar-menu  -->
                                        </div>
                                    </nav>
                                    <main class="page-content">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                <h4>TAP</h4>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                                <div class="config-sales">
                                                    <label>Financial Year</label>
                                                    <div class="form-group">
                                                        <select class="form-control form-control-sm">
                                                            <option value="">2019</option>
                                                            <option value="">2018</option>
                                                            <option value="">2017</option>
                                                            <option value="">2016</option>
                                                            <option value="">2015</option>
                                                        </select>
                                                    </div>
                                                    <label>/</label>
                                                    <label>Monthly</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Plan-structure">
                                            <div class="table-responsive">
                                                <div class="tabpanel-title">
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                            <h4>TAP Details</h4>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-2 col-md-1 col-sm-1 col-1 text-center">
                                                            <a href="javascript:" id="addMore"><i class="fas fa-plus-circle"></i> Add New</a>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-2 col-md-1 col-sm-1 col-1 text-center brd-left-onboard">
                                                            <a href="javascript:void(0)" id="edit_mentor"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-2 col-md-1 col-sm-1 col-1 text-center brd-left-onboard">
                                                            <a class="deleteControl" href="javascript:"><i class="fas fa-trash"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <table class="table">
                                                    <thead class="table-success">
                                                        <tr>
                                                            <th width="25%">Requirement</th>
                                                            <th width="20%">Service Provider</th>
                                                            <th width="13%">Need by</th>
                                                            <th width="42%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="add_tab_details">
                                                        <tr>
                                                            <td width="25%">
                                                                <form>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control form-control-sm Requirement" >
                                                                    </div>
                                                                </form>
                                                            </td>
                                                            <td width="20%">
                                                                <form>
                                                                    <div class="form-group">
                                                                        <select class="form-control form-control-sm Service Provider">
                                                                            <option>-- Select --</option>
                                                                        </select>
                                                                    </div>
                                                                </form>
                                                            </td>
                                                            <td width="13%">
                                                                <form>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control form-control-sm Need by" placeholder="04/05/2019">
                                                                    </div>
                                                                </form>
                                                            </td>
                                                            <td width="42%">

                                                            </td>
                                                        </tr>
                                                    </tbody>

                                                    <tbody id='mgmt_add'></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </main>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- script -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script type="text/javascript">

            $(document).ready(function () {
                $('input[type="text"]').attr('readonly', 'readonly');
            });


            $(document).on('click', '#addMore', function () {
                var i = 0;
                var datas = $('.add_tab_details').html();
                $('#mgmt_add').append(datas);
                $('.advisor').each(function (key, value) {
                    $('#mgmt_add').find('.Requirement:last').val('').attr('readonly', false);
                    $('#mgmt_add').find('.Service Provider:last').val('').attr('readonly', false);
                    $('#mgmt_add').find('.Need by:last').val('').attr('readonly', false);
                    i = i + 1;
                });
                var j = i - 1;

            });



        </script>

    </body>

</html>