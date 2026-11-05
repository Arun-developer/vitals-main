
<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Employee - Reporting info')); ?>
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
          <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex"> -->

            <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
              <span><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><i class="fas fa-angle-left"></i> Back</a></span>
              <h4><?= $employee[0]['emp_name']; ?></h4>
              <?php $emp_id = $this->session->userdata('emp_number'); ?>
            </div>
                    <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <li class="edit"><a href="javascript:" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt" style="text-align:right;"></i> Edit</a></li>
                        </ul>
                      </div> -->

                    </div>

                    <?php
                    $menu_access = explode(',', $employee_detail[0]['tab_access']);
                    $bank_opacity = $depent_opacity = $edu_opacity = $immig_opacity = $job_opacity = $report_opacity = $doc_opacity = '';
                    $bank_blur = $depent_blur = $edu_blur = $immig_blur = $job_blur = $report_blur = $doc_blur = '';
                    if (in_array('1', $menu_access)) {
                      $bank_menu_url = base_url() . 'index.php/myprofile/bank/' . $emp_id;
                    } else {
                      $bank_menu_url = 'javascript:void(0);';
                      $bank_opacity = 'opacity5 nocursor';
                      $bank_blur = 'menu-blur';
                    }

                    if (in_array('2', $menu_access)) {
                      $depent_menu_url = base_url() . 'index.php/myprofile/dependents/' . $emp_id;
                    } else {
                      $depent_menu_url = 'javascript:void(0);';
                      $depent_opacity = 'opacity5 nocursor';
                      $depent_blur = 'menu-blur';
                    }

                    if (in_array('3', $menu_access)) {
                      $edu_menu_url = base_url() . 'index.php/myprofile/education/' . $emp_id;
                    } else {
                      $edu_menu_url = 'javascript:void(0);';
                      $edu_opacity = 'opacity5 nocursor';
                      $edu_blur = 'menu-blur';
                    }

                    if (in_array('4', $menu_access)) {
                      $immig_menu_url = base_url() . 'index.php/myprofile/immigration/' . $emp_id;
                    } else {
                      $immig_menu_url = 'javascript:void(0);';
                      $immig_opacity = 'opacity5 nocursor';
                      $immig_blur = 'menu-blur';
                    }

                    if (in_array('5', $menu_access)) {
                      $job_menu_url = base_url() . 'index.php/myprofile/job/' . $emp_id;
                    } else {
                      $job_menu_url = 'javascript:void(0);';
                      $job_opacity = 'opacity5 nocursor';
                      $job_blur = 'menu-blur';
                    }

                    if (in_array('6', $menu_access)) {
                      $report_menu_url = base_url() . 'index.php/myprofile/reporting/' . $emp_id;
                    } else {
                      $report_menu_url = 'javascript:void(0);';
                      $report_opacity = 'opacity5 nocursor';
                      $report_blur = 'menu-blur';
                    }

                    if (in_array('7', $menu_access)) {
                      $doc_menu_url = base_url() . 'index.php/myprofile/document/' . $emp_id;
                    } else {
                      $doc_menu_url = 'javascript:void(0);';
                      $doc_opacity = 'opacity5 nocursor';
                      $doc_blur = 'menu-blur';
                    }
                    ?>
                    
                    <div class="plan-structure-vital vital_windowScroll">
                      <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                          <div>
                            <ul class="nav nav-tabs" role="tablist">
                              <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/personal/'. $emp_id; ?>">Personal</a></li>
                              <li role="presentation" class="active"><a href="javascript:void(0); ?>">Reporting</a></li>
                              <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/contact/' . $emp_id; ?>">Contacts</a></li>
                              <li role="presentation"><a href="<?php echo $depent_menu_url; ?>">Dependents</a></li>
                              <li role="presentation"><a href="<?php echo $immig_menu_url; ?>">Immigration</a></li>
                              <li role="presentation"><a href="<?php echo $job_menu_url; ?>">Job & Salary</a></li>
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
                            <div class="inputplan-structureall plan-structure-new ">
                              <form id="supervisor_form" action="<?php echo base_url() . 'index.php/myprofile/add_supervisor' ?>" method="POST" autocomplete="off">
                                <input type="hidden" name="employee_id" value="<?= $emp_id; ?>">
                                <div class="table_configcontentnew pad-bt0">
                                  <div class="tabpanel-title">
                                    <div class="row">
                                      <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                        <h4>Supervisors</h4>
                                      </div>
                                              <!--       <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                                        <ul class="milestone-links">
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15 supervisor_deluser opacity5 none-pointer" id="delSupervisor"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </li>
                                                            <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue supervisor_submit opacity5 none-pointer">Save</a></li>
                                                        </ul>
                                                      </div> -->
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                                  <table class="table table-hover dt-responsive" id="supervisor_list" style="margin-top: 0">
                                                    <thead>
                                                      <tr>
                                                        <th width="5%" class="removeArrow"><input class="form-control supervisor_checkAll" type="checkbox" onchange="supervisor_checkAll();"></th>
                                                        <th width="25%">Employee ID</th>
                                                        <th width="40%">Employee Name</th>
                                                        <th width="30%">Reporting Method</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php
                                                      $j = 1;
                                                      $supervisor_count = isset($supervisor_list[0]['id']) ? php72_count($supervisor_list) : 0;
                                                      if ($supervisor_count > 0) {
                                                        for ($i = 0; $i < $supervisor_count; $i++) {
                                                          ?>
                                                          <tr id="supervisor_tr_<?php echo $j; ?>" class="supervisor_more">
                                                            <input type="hidden" name="report_sup[]" value="<?= $supervisor_list[$i]['id']; ?>" />
                                                            <td class="valign-center"><input class="form-control sup_checkbox" type="checkbox" name="supervisor_id[]" id="supervisor_id_<?= $j; ?>" value="<?= $supervisor_list[$i]['id']; ?>" disabled></td>
                                                            <td><input class="form-control" disabled type="text" placeholder="Employee ID" name="supervisor_report[]" id="supervisor_report_<?= $j; ?>" value="<?= $supervisor_list[$i]['report_subordinate']; ?>" disabled></td>
                                                            <td>
                                                              <select class="form-control employeeInput" readonly name="supervisor_employee[]" id="supervisor_employee_<?= $j; ?>" onchange="loadSupEmployee(<?= $j; ?>, this.value);" disabled>
                                                                <option value="">-- Select --</option>
                                                                <?php foreach ($employee_list as $e_name) { ?>
                                                                  <option value="<?= $e_name['id']; ?>" <?php
                                                                  if ($e_name['id'] == $supervisor_list[$i]['report_subordinate']) {
                                                                    echo "selected";
                                                                  }
                                                                  ?>><?= $e_name['emp_name']; ?></option>
                                                                <?php } ?>
                                                              </select>
                                                            </td>
                                                            <td>
                                                              <select class="form-control employeeInput" readonly name="supervisor_method[]" id="supervisor_method_<?= $j; ?>" disabled>
                                                                <option value="">--Select--</option>
                                                                <option value="1" <?php
                                                                if ($supervisor_list[$i]['report_method'] == 1) {
                                                                  echo "selected";
                                                                }
                                                                ?>>Direct</option>
                                                                <option value="2" <?php
                                                                if ($supervisor_list[$i]['report_method'] == 2) {
                                                                  echo "selected";
                                                                }
                                                                ?>>Indirect</option>
                                                              </select>
                                                            </td>
                                                          </tr>
                                                          <?php
                                                          $j++;
                                                        }
                                                      } else {
                                                        ?>
                                                        <tr id="supervisor_tr_1" class="supervisor_more">
                                                          <input type="hidden" name="report_sup[]" value="" />
                                                          <td id="noSupervisorDataMsg" valign="top" colspan="7" class="none-pointer" style="text-align: center;">No data available in table</td>
                                                        </tr>
                                                        <?php
                                                      }
                                                      ?>
                                                    </tbody>
                                                  </table>
                                                </div>
                                              </form>
                                              <div style="height:15px"></div>
                                              <form id="subordinate_form" action="<?php echo base_url() . 'index.php/myprofile/add_subordinate' ?>" method="POST" autocomplete="off">
                                                <input type="hidden" name="employee_id" value="<?= $emp_id; ?>">
                                                <div class="table_configcontentnew pad-bt0">
                                                  <div class="tabpanel-title">
                                                    <div class="row">
                                                      <?php
                                                      $j = 1;
                                                      $subordinate_count = isset($subordinate_list[0]['id']) ? php72_count($subordinate_list) : 0;
                                                      if ($subordinate_count > 0) {

                                                        ?>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                          <h4>Subordinates</h4>
                                                        </div>


                                                    <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                                        <ul class="milestone-links">
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" id="addSubordinate" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15 subordinate_deluser opacity5 none-pointer" id="delSubordinate"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </li>
                                                            <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue subordinate_submit opacity5 none-pointer">Save</a></li>
                                                        </ul>
                                                      </div> -->
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                                  <table class="table table-hover dt-responsive" id="subordinate_list" style="margin-top: 0">
                                                    <thead>
                                                      <tr>
                                                        <th width="5%" class="removeArrow"><input class="form-control subordinate_checkAll" type="checkbox" onchange="subordinate_checkAll();"></th>
                                                        <th width="25%">Employee ID</th>
                                                        <th width="40%">Employee Name</th>
                                                        <th width="30%">Reporting Method</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php
                                                      $j = 1;
                                                      $subordinate_count = isset($subordinate_list[0]['id']) ? php72_count($subordinate_list) : 0;
                                                      if ($subordinate_count > 0) {
                                                        for ($i = 0; $i < $subordinate_count; $i++) {
                                                          ?>
                                                          <tr id="subordinate_tr_<?php echo $j; ?>" class="subordinate_more" disabled>
                                                            <input type="hidden" name="report_subor[]" value="<?= $subordinate_list[$i]['id']; ?>" />
                                                            <td class="valign-center"><input class="form-control subor_checkbox" type="checkbox" name="subordinate_id[]" id="subordinate_id_<?= $j; ?>" value="<?= $subordinate_list[$i]['id']; ?>" disabled></td>
                                                            <td><input class="form-control" disabled type="text" placeholder="Employee ID" name="subordinate_report[]" id="subordinate_report_<?= $j; ?>" value="<?= $subordinate_list[$i]['report_supervisor']; ?>" disabled></td>
                                                            <td>
                                                              <select class="form-control employeeInput" readonly name="subordinate_employee[]" id="subordinate_employee_<?= $j; ?>" onchange="loadSuborEmployee(<?= $j; ?>, this.value);" disabled>
                                                                <option value="">-- Select --</option>
                                                                <?php foreach ($employee_list as $e_name) { ?>
                                                                  <option value="<?= $e_name['id']; ?>" <?php
                                                                  if ($e_name['id'] == $subordinate_list[$i]['report_supervisor']) {
                                                                    echo "selected";
                                                                  }
                                                                  ?>><?= $e_name['emp_name']; ?></option>
                                                                <?php } ?>
                                                              </select>
                                                            </td>
                                                            <td>
                                                              <select class="form-control employeeInput" readonly name="subordinate_method[]" id="subordinate_method_<?= $j; ?>" disabled>
                                                                <option value="">--Select--</option>
                                                                <option value="1" <?php
                                                                if ($subordinate_list[$i]['report_method'] == 1) {
                                                                  echo "selected";
                                                                }
                                                                ?>>Direct</option>
                                                                <option value="2" <?php
                                                                if ($subordinate_list[$i]['report_method'] == 2) {
                                                                  echo "selected";
                                                                }
                                                                ?>>Indirect</option>
                                                              </select>
                                                            </td>
                                                          </tr>
                                                        </tbody>
                                                        <?php
                                                        $j++;
                                                      }
                                                    } else {
                                                      ?>
                                                      <tr id="subordinate_tr_1" class="subordinate_more">
                                                        <input type="hidden" name="report_subor[]" value="" />
                                                        <td id="noSubordinateDataMsg" valign="top" colspan="7" class="none-pointer" style="text-align: center;">No data available in table</td>
                                                      </tr>
                                                      <?php
                                                    }
                                                    ?>
                                                    <?php } ?>  <!--  endif subordinate -->
                                                  </table>
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


                            <?php $this->load->view('vitals_footer.php'); ?>

                            <script type="text/javascript">



                              function submitRequest() {
                                $('#applyleaveForm').submit();
                              }

                              $('#applyleaveForm').validate({
                                rules: {
                                  leave_type: "required",
                                  leave_from_date: "required",
                                  leave_to_date: "required",
                                  comments: "required",
                                  leave_length: "required"
                                },
                                messages: {
                                  leave_type: "Select leave type",
                                  leave_from_date: "Select from date",
                                  leave_to_date: "Select to date",
                                  comments: "Enter comments",
                                  leave_length: "Select leave length"
                                }
                              });

                              $(document).on('input', '.commonAlphaNum', function () {
                                if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
                                  this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
                                }
                              });

                              var datesArray = [<?php echo $holiday_list; ?>];

                              
                              $("#dob").datepicker({
                                changeMonth: true,
                                changeYear: true,
                                yearRange: '1945:'+(new Date).getFullYear(),
                                onSelect: function (selected) {
                                  $("#dob").datepicker("option", "dateFormat", 'mm/dd/yy');
                                  $("#filter_todate").val('');
                                  var dt = new Date(selected);
                                  var dateval = dt.getDate();
                                  var monthval = dt.getMonth() + 1;
                                  var yearval = dt.getFullYear();
                                  if (monthval < 100) {
                                    monthval = "0" + monthval;
                                  } else {
                                    monthval = monthval;
                                  }
                                  if (dateval < 10) {
                                    dateval = "0" + dateval;
                                  } else {
                                    dateval = dateval;
                                  }
                                  var fulldatevalue = dateval + '-' + monthval + '-' + yearval;
                                  $("#dob").val(fulldatevalue);
                                  dt.setDate(dt.getDate() + 1);
                                  $("#filter_todate").datepicker("option", {
                                    minDate: dt
                                  });
                                }
                              });


    // $('#dob').datepicker({
    //     dateFormat: "dd-mm-yy",
    //     minDate: 0,
    //     beforeShowDay: function (date) {
    //         var theday = (date.getMonth() + 1) + '/' + date.getDate() + '/' + date.getFullYear();
    //         return [true, $.inArray(theday, datesArray) >= 0 ? "specialDate" : ''];
    //     },
    // }).on("change", function () {
    //     calcDiff();
    // });

    function calcDiff() {
      var d1 = $('#leave_from_date').datepicker('getDate');
      var d2 = $('#leave_to_date').datepicker('getDate');
      var diff = 0;
      if (d1 && d2) {
    diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000); // ms per day
  }

  if(diff > 0) {
        //$('#leave_length').css('display', 'none');
        $("#leave_length").attr("disabled", true);
        $("#leave_length").val(1);
      } else {
        //$('#leave_length').css('display', 'block');
        $("#leave_length").attr("disabled", false);
      } 
    }

  </script>

  <style type="text/css">
    .ui-datepicker-week-end a {background: rgb(144, 238, 144) !important;}
    .ui-datepicker .specialDate a {color: #fff !important; background: #dc3545 !important;}
  </style>

</body>
</html>
