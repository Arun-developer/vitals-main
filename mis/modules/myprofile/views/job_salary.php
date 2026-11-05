
<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Profile -Job & Salary Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
  <div class="row">
    <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
      <div id="leftMenuLoad">
        <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'change_password', 'page' => 'my_profile')); ?>
      </div>
    </div>
    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
      <main class="page-content">
        <div class="row dataconfig d_v_d_c">

          <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
            <span><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><i class="fas fa-angle-left"></i> Back</a></span>
            <h4><?= $employee[0]['emp_name']; ?></h4>
            <?php $emp_id = $this->session->userdata('emp_number'); ?>
          </div>
               <!--      <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <li class="edit"><a href="<?php echo base_url() . 'index.php/myprofile/edit_immigration/' . $emp_id; ?>" id="editpersonal" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt" style="text-align:right;"></i> Edit</a></li>
                        </ul>
                      </div> -->
                    </div>

                    <?php
                    $bank_menu_url = base_url() . 'index.php/myprofile/bank/' . $emp_id;
                    $depent_menu_url = base_url() . 'index.php/myprofile/dependents/' . $emp_id;
                    $edu_menu_url = base_url() . 'index.php/myprofile/education/' . $emp_id;
                    $immig_menu_url = base_url() . 'index.php/myprofile/immigration/' . $emp_id;
                    $job_menu_url = base_url() . 'index.php/myprofile/job/' . $emp_id;
                    $report_menu_url = base_url() . 'index.php/myprofile/reporting/' . $emp_id;
                    $doc_menu_url = base_url() . 'index.php/myprofile/document/' . $emp_id;
                    ?>

                    <div class="plan-structure-vital vital_windowScroll">
                      <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                          <div>
                            <ul class="nav nav-tabs" role="tablist">
                              <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/personal/' . $emp_id; ?>">Personal</a></li>
                              <li role="presentation"><a href="<?php echo $report_menu_url; ?>">Reporting</a></li>
                              <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/contact/' . $emp_id; ?>">Contacts</a></li>
                              <li role="presentation"><a href="<?php echo $depent_menu_url; ?>">Dependents</a></li>
                              <li role="presentation"><a href="<?php echo $immig_menu_url; ?>">Immigration</a></li>
                              <li role="presentation" class="active"><a href="javascript:void(0);">Job & Salary</a></li>
                              <li role="presentation"><a href="<?php echo $bank_menu_url; ?>">Bank</a></li>
                              <li role="presentation"><a href="<?php echo $edu_menu_url; ?>">Education</a></li>
                              <li role="presentation"><a href="<?php echo $doc_menu_url; ?>">Document</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                          <main class="page-content">
                            <div class="inputplan-structureall  plan-structure-new">
                              <div class="row">
                                <div class="col-12">
                                  <h4 class="vitals_innerSub">Designation Details</h4>
                                </div>
                              </div>

                              <div id="load_designation">
                                <form id="designation_form" method="post" autocomplete="off">
                                  <input type="hidden" name="employee_id" value="<?= $emp_id; ?>">
                                  <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                      <div>
                                        <div class="form-group">
                                          <label>Current Designation</label>
                                          <select class="form-control employeeInput" disabled name="job_design">
                                            <option>--Select--</option>
                                            <?php foreach ($job_designation as $design) { ?>
                                              <option value="<?= $design['id']; ?>" <?php
                                              if ($design['id'] == $job_salary[0]['designation']) {
                                                echo 'selected';
                                              }
                                              ?>><?= $design['job_title']; ?></option>
                                            <?php } ?>
                                          </select>
                                        </div>
                                      </div>
                                    </div>

                                    <?php
                                    $job_date = isset($job_salary[0]['job_date']) && $job_salary[0]['job_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($job_salary[0]['job_date'])) : '';
                                    ?>

                                    <div class="col-12 col-lg-4 col-md-4">
                                      <div>
                                        <div class="form-group">
                                          <label>Department</label>
                                          <select class="form-control employeeInput" disabled name="job_dept">
                                            <option>--Select--</option>
                                            <?php foreach ($job_department as $dept) { ?>
                                              <option value="<?= $dept['id']; ?>" <?php
                                              if ($dept['id'] == $job_salary[0]['department']) {
                                                echo 'selected';
                                              }
                                              ?>><?= $dept['job_department']; ?></option>
                                            <?php } ?>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                      <div>
                                        <div class="form-group">
                                          <label>Job Location</label>
                                          <select class="form-control employeeInput" disabled name="job_location">
                                            <option>--Select--</option>
                                            <?php foreach ($job_location as $location) { ?>
                                              <option value="<?= $location['id']; ?>" <?php
                                              if ($location['id'] == $job_salary[0]['location']) {
                                                echo 'selected';
                                              }
                                              ?>><?= $location['location_name']; ?></option>
                                            <?php } ?>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                      <div class="form-group">
                                        <label>Job Type</label>

                                        <select class="form-control employeeInput" disabled name="job_type">
                                          <option>--Select--</option>

                                          <?php foreach ($job_type as $status) { ?>

                                            <option value="<?= $status['id']; ?>" <?php
                                            if ($status['id'] == $job_salary[0]['job_type']) {
                                              echo 'selected';
                                            }
                                            ?>><?= $status['job_name']; ?></option>
                                          <?php } ?>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                      <div class="form-group  ">
                                        <label>Date</label>
                                        <div class="position-relative">
                                          <input type="text" class="form-control form-control-sm employeeInput dateCalendar" disabled name="job_date" placeholder="dd-mm-yyyy" value="<?= $job_date; ?>" />
                                          <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4">
                                      <div class="form-group">
                                        <label>Service as on date</label>
                                        <ul class="vitals-links">
                                          <li><input type="text" placeholder="0" name="service_year" value="<?= $job_salary[0]['job_service_year']; ?>" class="form-control employeeInput wdt_80" disabled></li>
                                          <li><span>Year</span></li>
                                          <li>&nbsp;&nbsp;</li>
                                          <li><input type="text" placeholder="0" name="service_month" value="<?= $job_salary[0]['job_service_month']; ?>" class="form-control employeeInput wdt_80" disabled></li>
                                          <li><span>Months</span></li>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                    <div class="col-12 col-sm-8 col-md-8">
                                      <div class="form-group">
                                        <ul class="vitals-links">
                                          <li class="hide_destinationHis display-hide"><input type="button" class="vital_yellow_btn wdt_auto" value="Hide Designation History"></li>
                                          <li class="view_destinationHis"><input type="button" class="vital_bordered_btn wdt_auto " id="view_design" value="View Designation History"></li>
                                                            <!-- <li><input type="button" class="vital_bordered_btn" id="revise_designation" value="Revise Designation"></li>
                                                            <li><input type="button" class="wdt_100 vital_yellow_btn display-hide" id="designation_save" value="Save"></li>
                                                            <li><a href="<?php echo base_url() . 'index.php/myprofile/job/' . $emp_id; ?>" class="wdt_100 vital_bordered_btn display-hide" id="designation_cancel">Cancel</a></li> -->
                                                          </ul>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="row">
                                                      <div class="col-12 col-md-6 col-lg-6 col-xl-6 valign-bottom">
                                                        <h4 class="vitals_innerSub show_designTitle display-hide mar-bt0 pad-tp10">Designation History</h4>
                                                      </div>
                                                      <div class="col-12 col-md-6 col-lg-6 col-xl-6 text-right">
                                                        <ul class="vitals-links ">
                                                          <li>
                                                            <a href="javascript:void(0)" class="master_deluser designation_His_del mar-vr10 display-hide none-pointer" id="delDesignation"><i class="fas fa-trash-alt"></i> Delete</a>
                                                          </li>
                                                        </ul>
                                                      </div>
                                                    </div>
                                                  </form>

                                                  <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 designation_His_table vitalMasterDataTbl display-hide">
                                                      <table class="table table-hover dt-responsive" id="design_list">
                                                        <thead>
                                                          <tr>
                                                            <th width="6%"><input type='checkbox' class='form-control design_checkAll' onchange="design_checkAll();"></th>
                                                            <th>Designation</th>
                                                            <th>Job Location</th>
                                                            <th>Date</th>
                                                            <th>Department</th>
                                                            <th>Job Type</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                          <?php echo $this->pagination->create_links_new($form_name); ?>
                                                        </tbody>
                                                      </table>
                                                      <div style="height:50px"></div>
                                                    </div>
                                                  </div>
                                                </div>

                                                <?php
                                                $salarydate = isset($job_salary[0]['salary_date']) && $job_salary[0]['salary_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($job_salary[0]['salary_date'])) : '';
                                                ?>

                                                <div class="row">
                                                  <div class="col-12">
                                                    <h4 class="vitals_innerSub">Salary Details</h4>
                                                  </div>
                                                </div>

                                                <div id="load_salary">
                                                  <form id="salary_form" method="post" autocomplete="off">
                                                    <input type="hidden" name="employee_id" value="<?= $emp_id; ?>">
                                                    <div class="row">
                                                      <div class="col-12 col-lg-4 col-md-4">
                                                        <div>
                                                          <div class="form-group">
                                                            <label>Current CTC Band</label>
                                                            <select class="form-control employeeInput" disabled name="salary_ctc">
                                                              <option>--Select--</option>
                                                              <?php foreach ($salary_ctc as $ctc) { ?>
                                                                <option value="<?= $ctc['id']; ?>" <?php
                                                                if ($ctc['id'] == $job_salary[0]['ctc_salary']) {
                                                                  echo 'selected';
                                                                }
                                                                ?>><?= $ctc['salary_ctc']; ?></option>
                                                              <?php } ?>
                                                            </select>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="col-12 col-lg-4 col-md-4">
                                                        <div>
                                                          <div class="form-group">
                                                            <label>Current Gross Salary</label>
                                                            <input placeholder="Enter Value (Rs.)" class="form-control employeeInput currencyField" disabled name="salary_gross" maxlength="10" value="<?= $job_salary[0]['gross_salary']; ?>">
                                                          </div>

                                                        </div>
                                                      </div>
                                                      <div class="col-12 col-lg-4 col-md-4">
                                                        <div>
                                                          <div class="form-group">
                                                            <label>Current Performance Linked Incentive (PLI)</label>
                                                            <input placeholder="Enter Value (Rs.)" class="form-control employeeInput currencyField" disabled name="salary_incentive" maxlength="10" value="<?= $job_salary[0]['salary_incentive']; ?>">
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="row">
                                                      <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="form-group  ">
                                                          <label>Date</label>
                                                          <div class="position-relative">
                                                            <input type="text" class="form-control form-control-sm employeeInput dateCalendar" disabled name="salary_date" placeholder="dd-mm-yyyy" value="<?= $salarydate; ?>" />
                                                            <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="form-group">
                                                          <label>Contracted Hours</label>
                                                          <input placeholder="Enter Value (Hrs)" class="form-control employeeInput hoursonly" disabled name="salary_contract" maxlength="6" value="<?= $job_salary[0]['contract_hours']; ?>">
                                                        </div>
                                                      </div>
                                                      <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="form-group">
                                                          <label>Payment per Hours</label>
                                                          <input placeholder="Enter Value (Rs.)" class="form-control employeeInput currencyField" disabled name="payment_hours" maxlength="10" value="<?= $job_salary[0]['payment_hours']; ?>">
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="row">
                                                      <div class="col-12 col-sm-8 col-md-8">
                                                        <div class="form-group">
                                                          <ul class="vitals-links">
                                                            <li class="hide_salay_details_btn display-hide"><input type="button" class="vital_yellow_btn" value="Hide Salary History"></li>
                                                            <li class="view_salay_details_btn"><input type="button" class="vital_bordered_btn" id="view_salary" value="View Salary History"></li>
                                                            <!-- <li><input type="button" class="vital_bordered_btn" id="revise_salary" value="Revise Salary"></li>
                                                            <li><input type="button" class="wdt_100 vital_yellow_btn  display-hide" id="salary_save" value="Save"></li>
                                                            <li><a href="<?php echo base_url() . 'index.php/myprofile/job/' . $emp_id; ?>" class="wdt_100 vital_bordered_btn display-hide" id="salary_cancel">Cancel</a></li> -->
                                                          </ul>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="row">
                                                      <div class="col-12 col-md-6 col-lg-6 col-xl-6 valign-bottom">
                                                        <h4 class="vitals_innerSub show_salTitle display-hide mar-bt0 pad-tp10">Salary History</h4>
                                                      </div>
                                                      <div class="col-12 col-md-6 col-lg-6 col-xl-6 text-right">
                                                        <ul class="vitals-links ">
                                                          <li>
                                                            <a href="javascript:void(0)" class="master_deluser salary_Details_del mar-vr10 display-hide none-pointer" id="delSalary"><i class="fas fa-trash-alt"></i> Delete</a>
                                                          </li>
                                                        </ul>
                                                      </div>
                                                    </div>
                                                  </form>

                                                  <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 salary_His_table vitalMasterDataTbl display-hide">
                                                      <table class="table table-hover dt-responsive" id="salary_list">
                                                        <thead>
                                                          <tr>
                                                            <th width="6%"><input type='checkbox' class='form-control salary_checkAll' onchange="salary_checkAll();"></th>
                                                            <th>Current Gross Salary</th>
                                                            <th>Current PLI</th>
                                                            <th>Date</th>
                                                            <th>Contract Hours</th>
                                                            <th>Payment Per Hour</th>
                                                            <th>Current CTC</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                          <?php echo $this->pagination->create_links_new($form_name); ?>
                                                        </tbody>
                                                      </table>
                                                      <div style="height:50px"></div>
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class="row">
                                                  <div class="col-12">
                                                    <h4 class="vitals_innerSub">Offer Details</h4>
                                                  </div>
                                                </div>

                                                <?php
                                                $offer_date = isset($job_salary[0]['offer_date']) && $job_salary[0]['offer_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($job_salary[0]['offer_date'])) : '';
                                                $resign_date = isset($job_salary[0]['resignation_date']) && $job_salary[0]['resignation_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($job_salary[0]['resignation_date'])) : '';
                                                $last_date = isset($job_salary[0]['last_working_date']) && $job_salary[0]['last_working_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($job_salary[0]['last_working_date'])) : '';
                                                ?>

                                                <div id="load_offer">
                                                  <form id="offer_form" method="post" autocomplete="off">
                                                    <input type="hidden" name="employee_id" value="<?= $emp_id; ?>">
                                                    <div class="row">
                                                      <div class="col-12 col-lg-4 col-md-4">
                                                        <div>
                                                          <div class="form-group  ">
                                                            <label>Offer Letter Date</label>
                                                            <div class="position-relative">
                                                              <input type="text" class="form-control form-control-sm employeeInput dateCalendar" disabled name="offer_date" placeholder="dd-mm-yyyy" value="<?= $offer_date; ?>" />
                                                              <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                          </div>

                                                        </div>
                                                      </div>
                                                      <div class="col-12 col-lg-4 col-md-4">
                                                        <div>
                                                          <div class="form-group">
                                                            <label>Offer Letter Designation</label>
                                                            <input placeholder="Enter Designation" class="form-control employeeInput" disabled name="offer_designation" maxlength="50" value="<?= $job_salary[0]['offer_designation']; ?>">
                                                          </div>

                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="row">
                                                      <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="form-group">
                                                          <label>Offer Letter Gross Salary</label>
                                                          <input placeholder="Enter Value (Rs.)" class="form-control employeeInput currencyField" disabled name="offer_salary" maxlength="10" value="<?= $job_salary[0]['offer_salary']; ?>">
                                                        </div>
                                                      </div>
                                                      <div class="col-12 col-lg-4 col-md-4">
                                                        <div class="form-group">
                                                          <label>Offer Letter PLI</label>
                                                          <input placeholder="Enter Value (Rs.)" class="form-control employeeInput currencyField" disabled name="offer_incentive" maxlength="10" value="<?= $job_salary[0]['offer_incentive']; ?>">
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="row">
                                                      <div class="col-12">
                                                        <h4 class="vitals_innerSub">Resignation Details</h4>
                                                      </div>
                                                    </div>
                                                    <div class="row">
                                                      <div class="col-12 col-lg-4 col-md-4">
                                                        <div>
                                                          <div class="form-group  ">
                                                            <label>Date of Resignation</label>
                                                            <div class="position-relative">
                                                              <input type="text" class="form-control form-control-sm employeeInput dateCalendar" disabled name="resign_date" placeholder="dd-mm-yyyy" value="<?= $resign_date; ?>" />
                                                              <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="col-12 col-lg-4 col-md-4">
                                                        <div>
                                                          <div class="form-group  ">
                                                            <label>Last Working Day</label>
                                                            <div class="position-relative">
                                                              <input type="text" class="form-control form-control-sm employeeInput dateCalendar" disabled name="resign_last_working" placeholder="dd-mm-yyyy" value="<?= $last_date; ?>" />
                                                              <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="row ">
                                                      <div class="col-12 col-sm-4  col-md-4 ">
                                                        <div class="text-left">
                                                          <ul class="vitals-links saveLinkView display-hide">
                                                            <li><input type="button" value="Save " id="job_salary_submit" class="vital_yellow_btn wdt_100"></li>
                                                            <li><a href="<?php echo base_url() . 'index.php/myprofile/job/' . $emp_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                          </ul>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </form>
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

                          <div class="modal" id="deletemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content delete-alert">
                                <div class="modal-body text-center">
                                  <div class="container-fluid">
                                    <div class="row">
                                      <div class="col-2">
                                        <i class="fas fa-exclamation"></i>
                                      </div>
                                      <div class="col-10">
                                        <h4>Are you sure you want to delete selected items?</h4>
                                        <p>you are about delete <span id="delCount"></span> selected information fields, you can't undo this</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
                                  <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                                  <button type="button" class="btn btn-success deleteRecord"> Delete Selected</button>
                                </div>
                              </div>
                            </div>
                          </div>

                          <?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

                          <script type="text/javascript">
                            $(document).ready(function () {
                              $(".dateCalendar").datepicker({
                                changeMonth: true,
                                changeYear: true,
                                dateFormat: "dd-mm-yy"
                              });

                              var previous_type = localStorage.getItem('emp_type');
                              if (previous_type != '') {
                                var link = "<?php echo base_url() . 'index.php/myprofile/lists/'; ?>" + previous_type;
                                $('.backPage').attr('href', link);
                              }
                            });

                            $(document).on('click', '#job_salary_submit', function () {
                              designation_submit();
                            });

                            function designation_submit() {
                              $.ajax({
                                type: 'POST',
                                url: "<?php echo base_url(); ?>index.php/myprofile/add_designation",
                                data: $('#designation_form').serialize(),
                                success: function (d_msg) {
                                  if (d_msg == 1)
                                    salary_submit();
                                }
                              });
                            }

                            function salary_submit() {
                              $.ajax({
                                type: 'POST',
                                url: "<?php echo base_url(); ?>index.php/myprofile/add_salary",
                                data: $('#salary_form').serialize(),
                                success: function (s_msg) {
                                  if (s_msg == 1)
                                    offer_submit();
                                }
                              });
                            }

                            function offer_submit() {
                              $.ajax({
                                type: 'POST',
                                url: "<?php echo base_url(); ?>index.php/myprofile/add_offer",
                                data: $('#offer_form').serialize(),
                                success: function () {
                                  window.location.href = '<?= base_url(); ?>' + 'index.php/myprofile/job/' + "<?= $emp_id; ?>";
                                }
                              });
                            }

                            $(document).on('click', '#revise_designation', function () {
                              $('#designation_save, #designation_cancel').removeClass("display-hide");
                              $("#load_designation .employeeInput").attr("disabled", false);
                            });

                            $(document).on('click', '#revise_salary', function () {
                              $('#salary_save, #salary_cancel').removeClass("display-hide");
                              $("#load_salary .employeeInput").attr("disabled", false);
                            });

                            $(document).on('click', '#designation_save', function () {
                              $.ajax({
                                type: 'POST',
                                url: "<?php echo base_url(); ?>index.php/myprofile/add_revisedesignation",
                                data: $('#designation_form').serialize(),
                                success: function (d_msg) {
                                  location.reload();
                                }
                              });
                            });

                            $(document).on('click', '#salary_save', function () {
                              $.ajax({
                                type: 'POST',
                                url: "<?php echo base_url(); ?>index.php/myprofile/add_revisesalary",
                                data: $('#salary_form').serialize(),
                                success: function (s_msg) {
                                  location.reload();
                                }
                              });
                            });

                            $(document).on('click', '#view_design', function () {
                              $('#design_list').DataTable({
                                "bProcessing": true,
                                "bServerSide": true,
                                "bDestroy": true,
                                "paging": true,
                                "ordering": true,
                                "info": false,
                                "searching": false,
                                "pageLength": 10,
                                "lengthChange": false,
                                "stateSave": false,
                                "ajax": {
                                  "url": "<?php echo base_url(); ?>index.php/myprofile/DT_designation",
                                  "data": {
                                    "employee_id": "<?php echo $emp_id; ?>"
                                  },
                                  "type": "POST"
                                },
                                drawCallback: function () {
                                  var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                                  pagination.toggle(this.api().page.info().pages > 1);

                                  var table = $('#design_list').dataTable();
                                  var data_len = table.fnGetData().length;
                                  if (data_len == 0) {
                                    $('.design_checkAll').hide();
                                    $('tr td:first-child').addClass('none-pointer');
                                  }

                                  $('.design_checkAll').prop('checked', false);
                                  $('.designation_His_del').removeClass('clr_red');
                                  $('.designation_His_del').addClass('none-pointer');
                                  $('tr td:first-child').css('text-align', 'center');
                                },
                                'columnDefs': [{
                                  'orderable': false,
                                  'targets': [0]
                                }],
                                "order": [1, 'desc']
                              });
                            });

                            function design_checkAll() {
                              if ($('.design_checkAll:checked').length > 0) {
                                $('.design_chckbox').prop('checked', true);
                                $('.designation_His_del').addClass('clr_red');
                                $('.designation_His_del').removeClass('none-pointer');
                              } else {
                                $('.design_chckbox').prop('checked', false);
                                $('.designation_His_del').removeClass('clr_red');
                                $('.designation_His_del').addClass('none-pointer');
                              }
                            }

                            $(document).on('click', '#design_chk_box', function () {
                              var design_check = $('.design_chckbox:checkbox:checked').length;
                              if ($('.design_chckbox:checked').length == $('.design_chckbox').length) {
                                $('.design_checkAll').prop('checked', true);
                              } else {
                                $('.design_checkAll').prop('checked', false);
                              }

                              if (design_check > 0) {
                                $('.designation_His_del').addClass('clr_red');
                                $('.designation_His_del').removeClass('none-pointer');
                              } else {
                                $('.designation_His_del').removeClass('clr_red');
                                $('.designation_His_del').addClass('none-pointer');
                              }
                            });

                            $(document).on('click', '#delDesignation', function () {
                              $('#delCount').val('');
                              var sel_item = $(".design_chckbox:checkbox:checked").length;
                              $('#delCount').html(sel_item);
                              if (sel_item > 0) {
                                $('#deletemodal').modal('show');
                                $('.deleteRecord').attr('id', 'delete_design');
                              }
                            });

                            $(document).on('click', '#delete_design', function () {
                              var vals = $('.design_chckbox:checkbox:checked').map(function () {
                                return this.value;
                              }).get().join(',');
                              var del_id = vals.split(',');
                              $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>index.php/myprofile/deleteUserData",
                                data: {
                                  id: del_id,
                                  table: 'hr_job_designation_revise',
                                  field: 'status'
                                },
                                dataType: 'json',
                                success: function (msg) {
                                  $('#deletemodal').modal('hide');
                                  location.reload();
                                }
                              });
                            });

                            $(document).on('click', '#view_salary', function () {
                              $('#salary_list').DataTable({
                                "bProcessing": true,
                                "bServerSide": true,
                                "bDestroy": true,
                                "paging": true,
                                "ordering": true,
                                "info": false,
                                "searching": false,
                                "pageLength": 10,
                                "lengthChange": false,
                                "stateSave": false,
                                "ajax": {
                                  "url": "<?php echo base_url(); ?>index.php/myprofile/DT_salary",
                                  "data": {
                                    "employee_id": "<?php echo $emp_id; ?>"
                                  },
                                  "type": "POST"
                                },
                                drawCallback: function () {
                                  var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                                  pagination.toggle(this.api().page.info().pages > 1);

                                  var table = $('#salary_list').dataTable();
                                  var data_len = table.fnGetData().length;
                                  if (data_len == 0) {
                                    $('.salary_checkAll').hide();
                                    $('tr td:first-child').addClass('none-pointer');
                                  }

                                  $('.salary_checkAll').prop('checked', false);
                                  $('.salary_Details_del').removeClass('clr_red');
                                  $('.salary_Details_del').addClass('none-pointer');
                                  $('tr td:first-child').css('text-align', 'center');
                                },
                                'columnDefs': [{
                                  'orderable': false,
                                  'targets': [0]
                                }],
                                "order": [1, 'desc']
                              });
                            });

                            function salary_checkAll() {
                              if ($('.salary_checkAll:checked').length > 0) {
                                $('.salary_chckbox').prop('checked', true);
                                $('.salary_Details_del').addClass('clr_red');
                                $('.salary_Details_del').removeClass('none-pointer');
                              } else {
                                $('.salary_chckbox').prop('checked', false);
                                $('.salary_Details_del').removeClass('clr_red');
                                $('.salary_Details_del').addClass('none-pointer');
                              }
                            }

                            $(document).on('click', '#salary_chk_box', function () {
                              var salary_check = $('.salary_chckbox:checkbox:checked').length;
                              if ($('.salary_chckbox:checked').length == $('.salary_chckbox').length) {
                                $('.salary_checkAll').prop('checked', true);
                              } else {
                                $('.salary_checkAll').prop('checked', false);
                              }

                              if (salary_check > 0) {
                                $('.salary_Details_del').addClass('clr_red');
                                $('.salary_Details_del').removeClass('none-pointer');
                              } else {
                                $('.salary_Details_del').removeClass('clr_red');
                                $('.salary_Details_del').addClass('none-pointer');
                              }
                            });

                            $(document).on('click', '#delSalary', function () {
                              $('#delCount').val('');
                              var sel_item = $(".salary_chckbox:checkbox:checked").length;
                              $('#delCount').html(sel_item);
                              if (sel_item > 0) {
                                $('#deletemodal').modal('show');
                                $('.deleteRecord').attr('id', 'delete_salary');
                              }
                            });

                            $(document).on('click', '#delete_salary', function () {
                              var vals = $('.salary_chckbox:checkbox:checked').map(function () {
                                return this.value;
                              }).get().join(',');
                              var del_id = vals.split(',');
                              $.ajax({
                                type: "POST",
                                url: "<?php echo base_url(); ?>index.php/myprofile/deleteUserData",
                                data: {
                                  id: del_id,
                                  table: 'hr_job_salary_revise',
                                  field: 'status'
                                },
                                dataType: 'json',
                                success: function (msg) {
                                  $('#deletemodal').modal('hide');
                                  location.reload();
                                }
                              });
                            });

                            $('.view_destinationHis').click(function () {
                              $(".view_destinationHis").addClass("display-hide");
                              $(".view_destinationHis").removeClass("display-show");
                              $('.hide_destinationHis').removeClass("display-hide");
                              $('.designation_His_del').removeClass("display-hide");
                              $('.show_designTitle').removeClass("display-hide");
                              $('.designation_His_table').removeClass("display-hide");
                              $(".hide_destinationHis").addClass("display-show");
                              $('.designation_His_del').addClass("display-show");
                              $('.show_designTitle').addClass("display-show");
                              $('.designation_His_table').addClass("display-show");

                            });

                            $('.hide_destinationHis').click(function () {
                              $(".view_destinationHis").addClass("display-show");
                              $('.view_destinationHis').removeClass("display-hide");
                              $(".hide_destinationHis").addClass("display-hide");
                              $('.hide_destinationHis').removeClass("display-show");
                              $('.designation_His_del').addClass("display-hide");
                              $('.designation_His_del').removeClass("display-show");
                              $('.show_designTitle').addClass("display-hide");
                              $('.show_designTitle').removeClass("display-show");
                              $('.designation_His_table').addClass("display-hide");
                              $('.designation_His_table').removeClass("display-show");
                            });

                            $('.view_salay_details_btn').click(function () {
                              $(".view_salay_details_btn").addClass("display-hide");
                              $('.hide_salay_details_btn').removeClass("display-hide");
                              $('.hide_salay_details_btn').addClass("display-show");
                              $('.salary_Details_del').removeClass("display-hide");
                              $('.show_salTitle').removeClass("display-hide");
                              $('.salary_His_table').removeClass("display-hide");
                              $('.salary_Details_del').addClass("display-show");
                              $('.show_salTitle').addClass("display-show");
                              $('.salary_His_table').addClass("display-show");
                              $(".view_salay_details_btn").removeClass("display-show");

                            });

                            $('.hide_salay_details_btn').click(function () {
                              $(".hide_salay_details_btn").addClass("display-hide");
                              $('.hide_salay_details_btn').removeClass("display-show");
                              $(".view_salay_details_btn").addClass("display-show");
                              $('.view_salay_details_btn').removeClass("display-hide");
                              $('.salary_Details_del').addClass("display-hide");
                              $('.salary_Details_del').removeClass("display-show");
                              $('.show_salTitle').addClass("display-hide");
                              $('.show_salTitle').removeClass("display-show");
                              $('.salary_His_table').addClass("display-hide");
                              $('.salary_His_table').removeClass("display-show");
                            });

                            $('.summaryEdit').click(function () {
                              $(".employeeInput").attr("disabled", false);
                              $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
                              $('li.edit').addClass("activeTabs");
                              $('li.edit a').addClass("greentab");
                              $('.saveLinkView').removeClass("display-hide");
                              $('.saveLinkView').addClass("display-show");
                            });

                            $(document).on('input', '.hoursonly', function () {
                              if (this.value.match(/[^0-9.]/g)) {
                                this.value = this.value.replace(/[^0-9.]/g, '');
                              }
                            });

                            $(document).on('input', '.currencyField', function (evt) {
                              var self = $(this);
                              self.val(self.val().replace(/[^0-9\.]/g, ''));
                              self.val(inrFormat(self.val()));
                              var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
                              var matchedString = self.val().match(patt);
                              if (matchedString) {
                                self.val(matchedString);
                              }
                            });

                            function inrFormat(nStr) {
                              nStr += '';
                              x = nStr.split('.');
                              x1 = x[0];
                              x2 = x.length > 1 ? '.' + x[1] : '';
                              var rgx = /(\d+)(\d{3})/;
                              var z = 0;
                              var len = String(x1).length;
                              var num = parseInt((len / 2) - 1);
                              while (rgx.test(x1)) {
                                if (z > 0) {
                                  x1 = x1.replace(rgx, '$1' + ',' + '$2');
                                } else {
                                  x1 = x1.replace(rgx, '$1' + ',' + '$2');
                                  rgx = /(\d+)(\d{2})/;
                                }
                                z++;
                                num--;
                                if (num == 0) {
                                  break;
                                }
                              }
                              return x1 + x2;
                            }
                          </script>

                        </body>
                        </html>