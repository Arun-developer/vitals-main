
<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Employee - Personal info')); ?>
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
          <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">

            <ul class="vitals-links">
              <li class="edit"><a href="javascript:" id="editpersonal" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt" style="text-align:right;"></i> Edit</a></li>
            </ul>
          </div>
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
                  <li role="presentation" class="active"><a href="javascript:void(0);">Personal</a></li>
                  <li role="presentation"><a href="<?php echo $report_menu_url; ?>">Reporting</a></li>
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
                  <form id="personal_form" method="post" action="<?php echo base_url() . 'index.php/myprofile/add_personal'; ?>" autocomplete="off" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-12 col-lg-4 col-md-4">
                        <div >
                          <div id="user_img">
                            <div class="form-group display-flex align-bottom">
                              <div class="profilePicMaster">
                                <?php
                                $emp_picture=$employee[0]['emp_picture'];
                                if($emp_picture==""){
                                  $emp_picture="";
                                }
                                if ($emp_picture!="") {
                                  ?>
                                  <img src="<?php echo base_url() . '/uploads/profile/'; ?><?php echo $emp_picture;?>" id="new_img" class="img-fluid"> 
                                  <?php
                                }else{
                                  ?>
                                  <img src="<?php echo base_url() . 'uploads/profile/default_picture.png'; ?>" id="new_img" class="img-fluid">
                                  <?php

                                } ?>

                              </div>
                              <div class="masterPicUpdate">
                                <label>Profile Picture
                                  <?php if ($employee[0]['emp_picture'] != '') { ?>
                                    <span class="cursor" title="Delete Picture" id="deletePic"><a href="javascript:void(0)" class="removeImg delete-btnconfig"><i class="fas fa-trash"></i></a></span>
                                  <?php } ?>
                                </label>
                                <input type="button" class="form-control masterPicUpdatebtn" value="Upload/Change Picture" /> 
                                <input type="file" name="profile_pic" id="my_file" class="display-hide" />
                                <input type="hidden" name="old_profile_pic" value="<?php echo  $emp_picture;?>">
                              </div>
                            </div>
                            <label class="error display-hide" id="dp_error"></label>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-lg-4 col-md-4">
                        <div>
                          <div class="form-group hgt-100v ">

                            <label>Employee Type <span class="text-danger">*</span></label>

                            <select class="form-control employeeInput" id="txt_employee" name="txt_employee" disabled>
                              <option value="">--Select--</option>
                              <?php foreach ($user_type as $user) { ?>
                                <option value="<?= $user['id']; ?>" <?php
                                if ($user['id'] == $employee[0]['emp_type']) {
                                  echo 'selected';
                                }
                                ?>><?= $user['user_type']; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-lg-4 col-md-4">
                        <div>
                          <div class="form-group hgt-100v ">

                            <label>Employee ID</label>
                            <input type="text" class="form-control" name="txt_empid" readonly="" placeholder="Employee ID" value="<?= $emp_id; ?>" disabled />
                            <input type="hidden" class="form-control" name="txt_empid" readonly="" placeholder="Employee ID" value="<?= $emp_id; ?>"  />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label>First Name <span class="text-danger">*</span></label>
                          <input type="text" class="form-control first_name" name="txt_firstname" placeholder="First name" maxlength="50" value="<?php echo $employee[0]['emp_first_name'];?>" disabled />
                        </div>
                      </div>
                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label>Middle Name</label>
                          <input type="text" class="form-control middle_name" name="txt_middlename" placeholder="Middle name" maxlength="50" value="<?php echo $employee[0]['emp_middle_name'];?>" disabled />
                        </div>
                      </div>
                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label>Last Name <span class="text-danger ">*</span></label>
                          <input type="text" class="form-control last_name" name="txt_lastname" placeholder="Last name" maxlength="50" value="<?php echo $employee[0]['emp_last_name'];?>" disabled />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group  ">
                          <label>Date of Birth</label>
                          <div class="position-relative">
                            <input type="text" id='dob' class="form-control form-control-sm dateCalendar" name="txt_dob" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y',strtotime($employee[0]['emp_dob'])); ?>" disabled />
                            <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label>Age</label>
                          <input type="text" id="age" class="form-control" name="txt_age" placeholder="Enter age" value="<?php echo $employee[0]['emp_age'];?>" maxlength="5" disabled />
                        </div>
                      </div>
                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label>Gender</label>
                          <select class="form-control" id="gender" name="txt_gender" disabled>


                            <option value="1" <?php if($employee[0]['emp_gender'] ==1){ echo 'selected';} ?>>Male</option>
                            <option value="2" <?php if($employee[0]['emp_gender'] ==2){ echo 'selected';} ?>>Female</option>
                            <option value="3" <?php if($employee[0]['emp_gender'] ==3){ echo 'selected';} ?>>Others</option>

                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label>Blood Group</label>
                          <input type="text" id="blood_group" class="form-control" name="txt_blood" placeholder="Blood group" maxlength="10" value ="<?php echo $employee[0]['blood_group'];?>" disabled />
                        </div>
                      </div>
                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label>Marital Status</label>
                          <select class="form-control" id="marital_status" name="txt_marital" disabled>
                            <option value="1" <?php if($employee[0]['marital_status'] ==1){ echo 'selected';} ?>>Married</option>
                            <option value="2" <?php if($employee[0]['marital_status'] ==2){ echo 'selected';} ?>>Unmarried</option>
                            <option value="3" <?php if($employee[0]['marital_status'] ==3){ echo 'selected';} ?>>Divorced</option>
                            <option value="4" <?php if($employee[0]['marital_status'] ==4){ echo 'selected';} ?>>Others</option>

                          </select>
                        </div>
                      </div>
                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label>Nationality</label>
                          <select id="nationality" class="form-control" name="txt_nationality" disabled>
                            <option value="">--Select--</option>
                            <?php foreach ($nationality as $nation) { ?>
                              <option value="<?= $nation['id']; ?>" <?php
                              if ($nation['id'] == $employee[0]['nationality']) {
                                echo 'selected';
                              }
                              ?>><?= $nation['nationality']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label>Experience</label>
                          <select id="experience" class="form-control" name="txt_experience" disabled>
                            <option value="">--Select--</option>
                            <?php foreach ($experience as $exp) { ?>
                              <option value="<?= $exp['id']; ?>" <?php 
                              if ($exp['id'] == $employee[0]['experience']) {
                                echo 'selected';
                              } 
                              ?>><?= $exp['exp_name']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label>UAN Number</label>
                          <input type="text" id="uan_number" class="form-control" name="txt_uan" placeholder="UAN number" maxlength="12" value="<?php echo $employee[0]['uan_number'];?>" disabled />
                        </div>
                      </div>
                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label>PAN Number</label>
                          <input type="text" id="pan_number" class="form-control" name="txt_pan" placeholder="PAN number" maxlength="10" value="<?php echo $employee[0]['pan_number'];?>" disabled />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label>Driving License Number</label>
                          <input type="text" id="license_number" class="form-control" name="txt_license" placeholder="License number" maxlength="15" value="<?php echo $employee[0]['license_number'];?>" disabled />
                        </div>
                      </div>

                      <div class="col-12 col-lg-4 col-md-4">
                        <div class="form-group">
                          <label>If organ donor details</label>
                          <input type="text" id = "organ_donor" class="form-control" name="txt_organ" placeholder="Organ donor details" maxlength="50" value="<?php echo $employee[0]['organ_donor'];?>" disabled />
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-12 col-sm-4  col-md-4 ">
                        <div class="text-left">
                          <ul class="vitals-links saveLinkView display-hide">
                            <li><input type="submit" value="Update" class="vital_yellow_btn wdt_100 save_add" disabled></li>
                            <li><a href="<?php echo base_url() . 'index.php/myprofile/personal/'.$emp_id; ?>" class="vital_bordered_btn wdt_100">Cancel</a></li>
                          </ul>
                        </div>
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
              <h4>Are you sure you want to delete profile picture?</h4>
              <p>you are about delete profile picture, you can't undo this</p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
        <button type="button" class="btn btn-success" id="deleteRecord"> Delete Picture</button>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('vitals_footer.php'); ?>

<script type="text/javascript">

  $(document).on('click', '#editpersonal', function (e) {
    $('.first_name').removeAttr('disabled');
    $('.middle_name').removeAttr('disabled');
    $('.last_name').removeAttr('disabled');
    $('#dob').removeAttr('disabled');
    $('#age').removeAttr('disabled');
    $('#gender').removeAttr('disabled');
    $('#blood_group').removeAttr('disabled');
    $('#marital_status').removeAttr('disabled');
    $('#nationality').removeAttr('disabled');
    $('#experience').removeAttr('disabled');
    $('#license_number').removeAttr('disabled');
    $('#uan_number').removeAttr('disabled');
    $('#pan_number').removeAttr('disabled');
    $('#organ_donor').removeAttr('disabled');
    $('.save_add').removeAttr('disabled');

  });
  $(document).ready(function () {

    $(".dateCalendar").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "dd-mm-yy",
      yearRange: "-60:+0",
      maxDate: 0
    });

    $(".licenseCalendar").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "dd-mm-yy",
      yearRange: "-30:+30"
    });

    var previous_type = localStorage.getItem('emp_type');
    if (previous_type != '') {
      var link = "<?php echo base_url() . 'index.php/myprofile/lists/'; ?>" + previous_type;
      $('.backPage').attr('href', link);
    }
  });

  $(document).on('click', '#reset_file', function (e) {
    $('#new_img').attr('src', "<?php echo base_url() . 'uploads/profile/' . $profile_picture; ?>");
  });

  $(document).on('click', '.masterPicUpdatebtn', function () {
    $("input[id='my_file']").click();
  });

  $(document).ready(function () {
    $("#my_file").on('change', function () {
      var countFiles = $(this)[0].files.length;
      var imgPath = $(this)[0].value;
      var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
      var imgSize = $(this)[0].files[0].size;
      if (imgSize <= '1048576') {
        if (extn == "png" || extn == "jpg" || extn == "jpeg") {
          if (typeof (FileReader) != "undefined") {
            for (var i = 0; i < countFiles; i++) {
              var reader = new FileReader();
              reader.onload = function (e) {
                $('#new_img').attr('src', e.target.result);
              }
              reader.readAsDataURL($(this)[0].files[i]);
            }
            $('#dp_error').addClass("display-hide");
            $('#dp_error').html("");
          } else {
            $('#dp_error').removeClass("display-hide");
            $('#dp_error').html("File does not support");
          }
        } else {
          $('#dp_error').removeClass("display-hide");
          $('#dp_error').html("Invalid File. Supports png, jpg, jpeg files only");
        }
      } else {
        $('#dp_error').removeClass("display-hide");
        $('#dp_error').html("File exceeds 1 MB");
      }
    });
  });

  $('#personal_form').validate({

    rules: {

      txt_firstname: "required",
      txt_lastname: "required"

    },
    messages: {

      txt_firstname: "Enter name",
      txt_lastname: "Enter name"
    }
  });

  $(document).on('click', '#deletePic', function (e) {
    $('#deletemodal').modal('show');
  });

  $(document).on('click', '#deleteRecord', function () {
    var emp_id = "<?= $emp_id; ?>";
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>index.php/myprofile/deleteValues",
      data: {
        id: emp_id
      },
      dataType: 'json',
      success: function (msg) {
        $('#deletemodal').modal('hide');
        $('#new_img').attr('src', "<?php echo base_url() . 'uploads/profile/default_picture.png'; ?>");
        $('.removeImg').hide();
        $('.imgToast').toast('show');
        $('.deleteMsg').removeClass('display-hide');
        $('#deleteText').html('Profile picture deleted successfully');
      }
    });
  });

  $('.summaryEdit').click(function () {
    $("#cancel_btn").css("display", "inline-block");
    $(".employeeInput").attr("disabled", false);
    $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
    $("#txt_employee").prop("disabled", true);
    $('li.edit').addClass("activeTabs");
    $('li.edit a').addClass("greentab");
    $('.saveLinkView').addClass("display-show");
    $('.saveLinkView').removeClass("display-hide");
  });

</script>

</body>
</html>