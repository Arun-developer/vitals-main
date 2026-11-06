
<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Profile -Dependents info')); ?>
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
                    <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <li class="edit"><a href="javascript:" id="editpersonal" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt" style="text-align:right;"></i> Edit</a></li>
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
                              <li role="presentation" class="active"><a href="javascript:void(0)">Dependents</a></li>
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
                              <form id="dependent_form" action="<?php echo base_url() . 'index.php/myprofile/add_dependents' ?>" method="POST" autocomplete="off">
                                <input type="hidden" name="employee_id" value="<?= $emp_id; ?>">
                                <div class="table_configcontentnew pad-bt0">
                                  <div class="tabpanel-title">
                                    <div class="row">
                                      <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                        <h4>Dependents</h4>
                                      </div>
                                      <div class="col-xl-6 col-lg-6 col-md-6  col-12 text-right">
                                        <ul class="milestone-links">
                                          <li class="brd-left-onboard">
                                            <a href="javascript:void(0)" id="addDependent" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                          </li>
                                          <li class="brd-left-onboard">
                                            <a href="javascript:void(0)" class="edit-btnconfig mar-tp15 dependent_deluser opacity5 none-pointer" id="delDependent"><i class="fas fa-trash-alt"></i> Delete</a>
                                          </li>
                                          <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue dependent_submit opacity5 none-pointer">Save</a></li>
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                  <table class="table table-hover dt-responsive" id="dependent_list" style="margin-top: 0">
                                    <thead>
                                      <tr>
                                        <th width="5%" class="removeArrow"><input class="form-control dependent_checkAll" type="checkbox" onchange="dependent_checkAll();"></th>
                                        <th width="20%">Name</th>
                                        <th width="20%">Relationship</th>
                                        <th width="20%">Date of Birth</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $j = 1;
                                      $dependent_count = isset($dependent_list[0]['id']) ? php72_count($dependent_list) : 0;
                                      if (php72_cmp($dependent_count) > 0) {
                                        for ($i = 0; $i < $dependent_count; $i++) {
                                          $birth_date = isset($dependent_list[$i]['birth_date']) && $dependent_list[$i]['birth_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($dependent_list[$i]['birth_date'])) : '';
                                          ?>
                                          <tr id="dependent_tr_<?php echo $j; ?>" class="dependent_more">
                                            <input type="hidden" name="dept_id[]" value="<?= $dependent_list[$i]['id']; ?>" />
                                            <td class="valign-center"><input class="form-control dept_checkbox" type="checkbox" name="dependent_id[]" id="dependent_id_<?= $j; ?>" value="<?= $dependent_list[$i]['id']; ?>"></td>
                                            <td><input class="form-control employeeInput" type="text" placeholder="Name" maxlength="50" name="dependent_name[]" id="dependent_name_<?= $j; ?>" value="<?= $dependent_list[$i]['name']; ?>"></td>
                                            <td>
                                              <select class="form-control employeeInput" readonly name="dependent_relation[]" id="dependent_relation_<?= $j; ?>">
                                                <option value="">-- Select --</option>
                                                <option value="1" <?php
                                                if (php72_cmp($dependent_list[$i]['relationship']) == 1) {
                                                  echo 'selected';
                                                }
                                                ?>>Father</option>
                                                <option value="2" <?php
                                                if (php72_cmp($dependent_list[$i]['relationship']) == 2) {
                                                  echo 'selected';
                                                }
                                                ?>>Mother</option>
                                                <option value="3" <?php
                                                if (php72_cmp($dependent_list[$i]['relationship']) == 3) {
                                                  echo 'selected';
                                                }
                                                ?>>Spouse</option>
                                                <option value="4" <?php
                                                if (php72_cmp($dependent_list[$i]['relationship']) == 4) {
                                                  echo 'selected';
                                                }
                                                ?>>Child</option>
                                              </select>
                                            </td>
                                            <td>
                                              <div class="position-relative">
                                                <input type="text" class="form-control employeeInput dateCalendar" name="dependent_birth[]" id="dependent_birth_<?= $j; ?>" value="<?= $birth_date; ?>" placeholder="dd-mm-yyyy" />
                                                <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                              </div>
                                            </td>

                                          </tr>
                                        </tbody>
                                        <?php
                                        $j++;
                                      }
                                    } else {
                                      ?>
                                      <tr id="dependent_tr_1" class="dependent_more">
                                        <input type="hidden" name="dept_id[]" value="" />
                                        <td id="noDataMsg" valign="top" colspan="7" class="none-pointer" style="text-align: center;">No data available in table</td>
                                      </tr>
                                      <?php
                                    }
                                    ?>
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
                <button type="button" class="btn btn-success" id="deleteRecord">Delete Selected</button>
              </div>
            </div>
          </div>
        </div>

        <input type="hidden" id="enable_dependent" value="<?= php72_count($dependent_list); ?>">
        <input type="hidden" id="enable_save" value="0">

        <?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

        <script type="text/javascript">



          $(document).ready(function () {
            datePicker();

            var previous_type = localStorage.getItem('emp_type');
            if (previous_type != '') {
              var link = "<?php echo base_url() . 'index.php/myprofile/lists/'; ?>" + previous_type;
              $('#backPage').attr('href', link);
            }

            var dependent = $('#enable_dependent').val();
            if (dependent > 0) {
              $('#dependent_list .employeeInput').attr('readonly', 'readonly');
              $('#dependent_list .employeeInput').css("pointer-events", "none");
            } else {
              $('#dependent_list input, #dependent_list select').removeClass('employeeInput');
              $('#dependent_list input, #dependent_list select').attr('readonly', false);
              $('#dependent_list .employeeInput').attr('readonly', false);
              $('#dependent_list .employeeInput').css("pointer-events", "");
              $('.dependent_checkAll').hide();
            }
          });

          function datePicker() {
            $(".dateCalendar").datepicker({
              changeMonth: true,
              changeYear: true,
              dateFormat: "dd-mm-yy",
              yearRange: "-100:+0",
              maxDate: 0
            });
          }

          $(document).on('click', '.dependent_submit', function () {
            $('#dependent_form').submit();
          });

          function dependent_checkAll() {
            var save = $('#enable_save').val();
            if ($('.dependent_checkAll:checked').length > 0) {
              $('.dept_checkbox').prop('checked', true);
              $('#delDependent').removeClass('opacity5');
              $('#delDependent').removeClass('none-pointer');
              $('#dependent_list .employeeInput').attr('readonly', false);
              $('#dependent_list .employeeInput').css("pointer-events", "");
              if (save == 0) {
                $('.dependent_submit').removeClass('opacity5');
                $('.dependent_submit').removeClass('none-pointer');
              }
            } else {
              $('.dept_checkbox').prop('checked', false);
              $('#delDependent').addClass('opacity5');
              $('#delDependent').addClass('none-pointer');
              $('#dependent_list .employeeInput').attr('readonly', 'readonly');
              $('#dependent_list .employeeInput').css("pointer-events", "none");
              if (save == 0) {
                $('.dependent_submit').addClass('opacity5');
                $('.dependent_submit').addClass('none-pointer');
              }
            }
          }

          $(document).on('click', '.dept_checkbox', function () {
            if ($('.dept_checkbox:checked').length == $('.dept_checkbox').length) {
              $('.dependent_checkAll').prop('checked', true);
            } else {
              $('.dependent_checkAll').prop('checked', false);
            }

            var design_check = $('.dept_checkbox:checkbox:checked').length;
            var save = $('#enable_save').val();
            if (design_check > 0) {
              $('#delDependent').removeClass('opacity5');
              $('#delDependent').removeClass('none-pointer');
              if (save == 0) {
                $('.dependent_submit').removeClass('opacity5');
                $('.dependent_submit').removeClass('none-pointer');
              }
            } else {
              $('#delDependent').addClass('opacity5');
              $('#delDependent').addClass('none-pointer');
              if (save == 0) {
                $('.dependent_submit').addClass('opacity5');
                $('.dependent_submit').addClass('none-pointer');
              }
            }

            $('#dependent_form .dept_checkbox').each(function () {
              var g_id = $(this).closest('tr').attr('id');
              if ($(this).is(":checked")) {
                $('#' + g_id + ' .employeeInput').attr("readonly", false);
                $('#' + g_id + ' .employeeInput').css("pointer-events", "");
              } else {
                $('#' + g_id + ' .employeeInput').attr("readonly", true);
                $('#' + g_id + ' .employeeInput').css("pointer-events", "none");
              }
            });

          });

          $(document).on('click', '#delDependent', function () {
            $('#delCount').val('');
            var sel_item = $(".dept_checkbox:checkbox:checked").length;
            $('#delCount').html(sel_item);
            if (sel_item > 0)
              $('#deletemodal').modal('show');
          });

          $(document).on('click', '#deleteRecord', function () {
            var vals = $('.dept_checkbox:checkbox:checked').map(function () {
              return this.value;
            }).get().join(',');
            var del_id = vals.split(',');
            $.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>index.php/myprofile/deleteUserData",
              data: {
                id: del_id,
                table: 'hr_user_dependents',
                field: 'status'
              },
              dataType: 'json',
              success: function (msg) {
                $('#deletemodal').modal('hide');
                location.reload();
              }
            });
          });

          $(document).on('click', '#addDependent', function () {
            $('.dependent_submit').removeClass('opacity5');
            $('.dependent_submit').removeClass('none-pointer');
          });

          $(document).on('click', '#addDependent', function () {
            $('#enable_save').val('1');
            var dyn = $(".dependent_more").length;
            var i = parseInt(dyn) + 1;
            var datas = '<tr id="dependent_tr_' + i + '" class="dependent_more"><input type="hidden" name="dept_id[]" value="" /><td class="valign-center"><input class="form-control dept_checkbox" type="checkbox" name="dependent_id[]" id="dependent_id_' + i + '" value=""></td>';
            datas += '<td><input class="form-control" type="text" name="dependent_name[]" id="dependent_name_' + i + '" maxlength="50" placeholder="Name" value=""></td>';
            datas += '<td><select class="form-control" name="dependent_relation[]" id="dependent_relation_' + i + '"><option value="">-Select-</option><option value="1">Father</option><option value="2">Mother</option><option value="3">Spouse</option><option value="4">Child</option></select></td>';
            datas += '<td><div class="position-relative"><input type="text" class="form-control dateCalendar" name="dependent_birth[]" id="dependent_birth_' + i + '" value="" placeholder="dd-mm-yyyy" /><span class="calendar-position"><i class="far fa-calendar-alt"></i></span></div></td></tr>';
            $(datas).insertBefore($('#dependent_tr_1'));
            datePicker();
            $('#noDataMsg').hide();
            $('.dependent_checkAll').show();
          });

        </script>

      </body>
      </html>