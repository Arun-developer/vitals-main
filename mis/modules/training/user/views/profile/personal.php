<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Employee - Personal info')); ?>

<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'emp_list')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/user/lists/3'; ?>" class="backPage"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?= $employee[0]['emp_name']; ?></h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <li class="edit"><a href="javascript:" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                        </ul>
                    </div>
                </div>
                <?php
                $menu_access = explode(',', $employee_detail[0]['tab_access']);
                $bank_opacity = $depent_opacity = $edu_opacity = $immig_opacity = $job_opacity = $report_opacity = $doc_opacity = '';
                $bank_blur = $depent_blur = $edu_blur = $immig_blur = $job_blur = $report_blur = $doc_blur = '';
                if (in_array('1', $menu_access)) {
                  $bank_menu_url = base_url() . 'index.php/user/bank/' . $emp_id;
              } else {
                  $bank_menu_url = 'javascript:void(0);';
                  $bank_opacity = 'opacity5 nocursor';
                  $bank_blur = 'menu-blur';
              }

              if (in_array('2', $menu_access)) {
                  $depent_menu_url = base_url() . 'index.php/user/dependents/' . $emp_id;
              } else {
                  $depent_menu_url = 'javascript:void(0);';
                  $depent_opacity = 'opacity5 nocursor';
                  $depent_blur = 'menu-blur';
              }

              if (in_array('3', $menu_access)) {
                  $edu_menu_url = base_url() . 'index.php/user/education/' . $emp_id;
              } else {
                  $edu_menu_url = 'javascript:void(0);';
                  $edu_opacity = 'opacity5 nocursor';
                  $edu_blur = 'menu-blur';
              }

              if (in_array('4', $menu_access)) {
                  $immig_menu_url = base_url() . 'index.php/user/immigration/' . $emp_id;
              } else {
                  $immig_menu_url = 'javascript:void(0);';
                  $immig_opacity = 'opacity5 nocursor';
                  $immig_blur = 'menu-blur';
              }

              if (in_array('5', $menu_access)) {
                  $job_menu_url = base_url() . 'index.php/user/job/' . $emp_id;
              } else {
                  $job_menu_url = 'javascript:void(0);';
                  $job_opacity = 'opacity5 nocursor';
                  $job_blur = 'menu-blur';
              }

              if (in_array('6', $menu_access)) {
                  $report_menu_url = base_url() . 'index.php/user/reporting/' . $emp_id;
              } else {
                  $report_menu_url = 'javascript:void(0);';
                  $report_opacity = 'opacity5 nocursor';
                  $report_blur = 'menu-blur';
              }

              if (in_array('7', $menu_access)) {
                  $doc_menu_url = base_url() . 'index.php/user/document/' . $emp_id;
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
                                <li role="presentation" class="active"><a href="javascript:void(0)">Personal</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/login/' . $emp_id; ?>">Login</a></li>
                                <li role="presentation"><a class="<?= $report_opacity; ?> <?= $report_menu; ?>" href="<?php echo $report_menu_url; ?>">Reporting</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/contact/' . $emp_id; ?>">Contacts</a></li>
                                <li role="presentation"><a class="<?= $depent_opacity; ?> <?= $depent_menu; ?>" href="<?php echo $depent_menu_url; ?>">Dependents</a></li>
                                <li role="presentation"><a class="<?= $immig_opacity; ?> <?= $immig_menu; ?>" href="<?php echo $immig_menu_url; ?>">Immigration</a></li>
                                <li role="presentation"><a class="<?= $job_opacity; ?> <?= $job_menu; ?>" href="<?php echo $job_menu_url; ?>">Job & Salary</a></li>
                                <li role="presentation"><a class="<?= $bank_opacity; ?> <?= $bank_menu; ?>" href="<?php echo $bank_menu_url; ?>">Bank</a></li>
                                <li role="presentation"><a class="<?= $edu_opacity; ?> <?= $edu_menu; ?>" href="<?php echo $edu_menu_url; ?>">Education</a></li>
                                <li role="presentation"><a class="<?= $doc_opacity; ?> <?= $doc_menu; ?>" href="<?php echo $doc_menu_url; ?>">Document</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container tab-content">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new ">
                                <form id="personal_form" method="post" action="<?php echo base_url() . 'index.php/user/add_personal'; ?>" autocomplete="off" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div>
                                                <div id="user_img">
                                                    <div class="form-group display-flex align-bottom">
                                                        <div class="profilePicMaster">
                                                            <?php
                                                            if ($employee[0]['emp_picture'] != '') {
                                                                $profile_picture = $employee[0]['emp_picture'];
                                                            } else {
                                                                $profile_picture = 'default_picture.png';
                                                            }
                                                            ?>
                                                            <img src="<?php echo base_url() . 'uploads/profile/' . $profile_picture; ?>" id="new_img" class="img-fluid">
                                                        </div>
                                                        <div class="masterPicUpdate">
                                                            <label>Profile Picture
                                                                <?php if ($employee[0]['emp_picture'] != '') { ?>
                                                                    <span class="cursor" title="Delete Picture" id="deletePic"><a href="javascript:void(0)" class="removeImg delete-btnconfig"><i class="fas fa-trash"></i></a></span>
                                                                <?php } ?>
                                                            </label>
                                                            <input type="button" class="form-control masterPicUpdatebtn employeeInput" disabled value="Upload/Change Picture" />
                                                            <input type="file" name="profile_pic" id="my_file" style="display: none;" />
                                                            <input type="hidden" name="old_profile_pic" value="<?= $employee[0]['emp_picture']; ?>">
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
                                                    <select class="form-control employeeInput" name="txt_employee" disabled>
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
                                                    <input type="text" class="form-control employeeInput" name="txt_empid" disabled readonly="" placeholder="Employee ID" value="<?= $employee[0]['id']; ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>First Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control employeeInput" name="txt_firstname" disabled placeholder="First name" maxlength="50" value="<?= $employee[0]['emp_first_name']; ?>" />
                                            </div>
                                            <?php
                                            $birth_date = isset($employee[0]['emp_dob']) && $employee[0]['emp_dob'] != '0000-00-00' ? date('d-m-Y', strtotime($employee[0]['emp_dob'])) : '';
                                            ?>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Middle Name</label>
                                                <input type="text" class="form-control employeeInput" name="txt_middlename" disabled placeholder="Middle name" maxlength="50" value="<?= $employee[0]['emp_middle_name']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Last Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control employeeInput" name="txt_lastname" disabled placeholder="Last name" maxlength="50" value="<?= $employee[0]['emp_last_name']; ?>" />
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group  ">
                                                <label>Date of Birth</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control dateCalendar employeeInput" disabled name="txt_dob" placeholder="dd-mm-yyyy" value="<?= $birth_date; ?>" />
                                                    <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Age</label>
                                                <input type="text" class="form-control employeeInput" name="txt_age" disabled placeholder="Enter age" maxlength="5" value="<?= $employee[0]['emp_age']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <select class="form-control employeeInput" name="txt_gender" disabled>
                                                    <option value="">--Select--</option>
                                                    <option value="1" <?php
                                                    if (php72_cmp($employee[0]['emp_gender']) == 1) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Male</option>
                                                    <option value="2" <?php
                                                    if (php72_cmp($employee[0]['emp_gender']) == 2) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Female</option>
                                                    <option value="3" <?php
                                                    if (php72_cmp($employee[0]['emp_gender']) == 3) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Others</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Blood Group</label>
                                                <input type="text" class="form-control employeeInput" name="txt_blood" disabled placeholder="Blood group" maxlength="10" value="<?= $employee[0]['blood_group']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Marital Status</label>
                                                <select class="form-control employeeInput" name="txt_marital" disabled>
                                                    <option value="">--Select--</option>
                                                    <option value="1" <?php
                                                    if (php72_cmp($employee[0]['marital_status']) == 1) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Married</option>
                                                    <option value="2" <?php
                                                    if (php72_cmp($employee[0]['marital_status']) == 2) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Unmarried</option>
                                                    <option value="3" <?php
                                                    if (php72_cmp($employee[0]['marital_status']) == 3) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Divorced</option>
                                                    <option value="4" <?php
                                                    if (php72_cmp($employee[0]['marital_status']) == 4) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Nationality</label>
                                                <select class="form-control employeeInput" name="txt_nationality" disabled>
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
                                                <select class="form-control employeeInput" name="txt_experience" disabled>
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
                                                <label>Source of Hiring</label>
                                                <select class="form-control employeeInput" name="txt_hiring" disabled>
                                                    <option value="">--Select--</option>
                                                    <option value="1" <?php
                                                    if (php72_cmp($employee[0]['hiring_source']) == 1) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Facebook</option>
                                                    <option value="2" <?php
                                                    if (php72_cmp($employee[0]['hiring_source']) == 2) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Google</option>
                                                    <option value="3" <?php
                                                    if (php72_cmp($employee[0]['hiring_source']) == 3) {
                                                        echo 'selected';
                                                    }
                                                    ?>>LinkedIn</option>
                                                    <option value="4" <?php
                                                    if (php72_cmp($employee[0]['hiring_source']) == 5) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Referral</option>
                                                    <option value="5" <?php
                                                    if (php72_cmp($employee[0]['hiring_source']) == 6) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Military Service</label>
                                                <input type="text" class="form-control employeeInput" name="txt_military" disabled placeholder="Military service" maxlength="50" value="<?= $employee[0]['military_service']; ?>" />
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Insurance No</label>
                                                <input type="text" class="form-control employeeInput" name="txt_insurance" disabled placeholder="Insurance number" maxlength="10" value="<?= $employee[0]['insurance']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>UAN Number</label>
                                                <input type="text" class="form-control employeeInput" name="txt_uan" disabled placeholder="UAN number" maxlength="12" value="<?= $employee[0]['uan_number']; ?>" />
                                            </div>
                                            <?php
                                            $expiry_date = isset($employee[0]['license_expiry_date']) && $employee[0]['license_expiry_date'] != '0000-00-00' ? date('d-m-Y', strtotime($employee[0]['license_expiry_date'])) : '';
                                            ?>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>PAN Number</label>
                                                <input type="text" class="form-control employeeInput" name="txt_pan" disabled placeholder="PAN number" maxlength="10" value="<?= $employee[0]['pan_number']; ?>" />
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Driving License Number</label>
                                                <input type="text" class="form-control employeeInput" name="txt_license" disabled placeholder="License number" maxlength="10" value="<?= $employee[0]['license_number']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group  ">
                                                <label>License Expiry date</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control licenseCalendar employeeInput" name="txt_license_expiry" disabled placeholder="dd-mm-yyyy" value="<?= $expiry_date; ?>" />
                                                    <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>If organ donor details</label>
                                                <input type="text" class="form-control employeeInput" name="txt_organ" disabled placeholder="Organ donor details" maxlength="50" value="<?= $employee[0]['organ_donor']; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Any Details of Illness</label>
                                                <input type="text" class="form-control employeeInput" name="txt_illness" disabled placeholder="Illness details" maxlength="50" value="<?= $employee[0]['illness']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Hobbies</label>
                                                <input type="text" class="form-control employeeInput" name="txt_hobbies" disabled placeholder="Enter Hobbies" maxlength="50" value="<?= $employee[0]['hobbies']; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4"></div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-12 col-sm-4  col-md-4 ">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView display-hide">
                                                    <li><input type="submit" value="Save" class="vital_yellow_btn wdt_100"></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/user/personal/' . $emp_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
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
            var link = "<?php echo base_url() . 'index.php/user/lists/'; ?>" + previous_type;
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
            txt_employee: "required",
            txt_firstname: "required",
            txt_lastname: "required"

        },
        messages: {
            txt_employee: "Select type",
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
            url: "<?php echo base_url(); ?>index.php/user/deleteValues",
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
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').addClass("display-show");
        $('.saveLinkView').removeClass("display-hide");
    });

</script>

</body>
</html>