
<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Profile -Personal Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'change_password', 'page' => 'change_password')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><i class="fas fa-angle-left"></i> Back</a></span>
                        <h4><?= $emp_name; ?></h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <li class="edit"><a href="javascript:" id="editpersonal" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt" style="text-align:right;"></i> Edit</a></li>
                        </ul>
                    </div>
                </div>

                <div class="plan-structure-vital vital_windowScroll">
                    <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="javascript:void(0)">Personal</a></li>
                                    <!-- <li role="presentation" class="opc_6"><a href="javascript:void(0)">Login</a></li> -->
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/reporting/' . $emp_id; ?>">Reporting</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/contact/' . $emp_id; ?>">Contacts</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/dependents/' . $emp_id; ?>">Dependents</a></li>
                                    <li role="presentation" ><a href="<?php echo base_url() . 'index.php/myprofile/immigration/' . $emp_id; ?>">Immigration</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/job/' . $emp_id; ?>">Job & Salary</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/bank/' . $emp_id; ?>">Bank</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/education/' . $emp_id; ?>">Education</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new ">
                                    <form id="user_form" method="post" action="<?php echo base_url() . 'index.php/myprofile/add_personal'; ?>" autocomplete="off" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div >
                                                    <div id="user_img">
                                                        <div class="form-group display-flex align-bottom">
                                                            <div class="profilePicMaster">
                                                                <img src="<?php echo base_url() . 'uploads/profile/default_picture.png'; ?>" id="new_img" class="img-fluid">
                                                            </div>
                                                            <div class="masterPicUpdate">
                                                                <label>Profile Picture
                                                                </label>
                                                                <input type="button" class="form-control masterPicUpdatebtn" value="Upload/Change Picture" />
                                                                <input type="file" name="profile_pic" id="my_file" class="display-hide" />
                                                                <input type="hidden" name="old_profile_pic" value="">
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

                                                        <select class="form-control" name="txt_employee" id="txt_employee"  >
                                                           <!--  <option value="">--Select--</option> -->

                                                            <?php foreach ($user_type as $user) { ?>
                                                                <option value="<?= $user['id']; ?>">
                                                                   <!--  <?= $user['user_type']; ?></option>  --><?php
                                                                if ($user['id'] == $employee[0]['emp_type']) {
                                                                     
                                                                }
                                                                ?><?= $user['user_type']; ?></option>
            

                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group hgt-100v ">
                                                        <?php $emp_id = $this->session->userdata('emp_number'); ?>
                                                        <label>Employee ID</label>
                                                        <input type="text" class="form-control" name="txt_empid" readonly="" placeholder="Employee ID" value="<?= $emp_id; ?>" disabled />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>First Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="txt_firstname" placeholder="First name" maxlength="50" value="" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Middle Name</label>
                                                    <input type="text" class="form-control" name="txt_middlename" placeholder="Middle name" maxlength="50" value="" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="txt_lastname" placeholder="Last name" maxlength="50" value="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group  ">
                                                    <label>Date of Birth</label>
                                                    <div class="position-relative">
                                                        <input type="text" id='dob' class="form-control form-control-sm dateCalendar" name="txt_dob" placeholder="dd-mm-yyyy" value="" />
                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Age</label>
                                                    <input type="text" class="form-control" name="txt_age" placeholder="Enter age" value="" maxlength="5" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <select class="form-control" name="txt_gender">
                                                        <option value="">--Select--</option>
                                                        <option value="1">Male</option>
                                                        <option value="2">Female</option>
                                                        <option value="3">Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Blood Group</label>
                                                    <input type="text" class="form-control" name="txt_blood" placeholder="Blood group" maxlength="10" value="" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Marital Status</label>
                                                    <select class="form-control" name="txt_marital">
                                                        <option value="">--Select--</option>
                                                        <option value="1">Married</option>
                                                        <option value="2">Unmarried</option>
                                                        <option value="3">Divorced</option>
                                                        <option value="4">Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Nationality</label>
                                                    <select class="form-control" name="txt_nationality">
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
                                                    <select class="form-control" name="txt_experience">
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($experience as $exp) { ?>
                                                            <option value="<?= $exp['id']; ?>"><?= $exp['exp_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>UAN Number</label>
                                                    <input type="text" class="form-control" name="txt_uan" placeholder="UAN number" maxlength="12" value="" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>PAN Number</label>
                                                    <input type="text" class="form-control" name="txt_pan" placeholder="PAN number" maxlength="10" value="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Driving License Number</label>
                                                    <input type="text" class="form-control" name="txt_license" placeholder="License number" maxlength="15" value="" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>If organ donor details</label>
                                                    <input type="text" class="form-control" name="txt_organ" placeholder="Organ donor details" maxlength="50" value="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                                    <div class="form-group">
                                                        <label>Partner Name <span class="text-danger">*</span></label>
                                                        <select class="form-control employeeInput" name="txt_partner">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($partner_type as $partner) { ?>
                                                                <option value="<?= $partner['id']; ?>"><?= $partner['partner_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-sm-4  col-md-4 ">
                                                <div class="text-left">
                                                    <ul class="vitals-links saveLinkView">
                                                        <li><input type="submit" value="Add" class="vital_yellow_btn wdt_100"></li>
                                                        <li><a href="<?php echo base_url() . 'index.php/mprofile/lists/3'; ?>" class="wdt_100 backPage vital_bordered_btn">Cancel</a></li>
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

<?php
if ($this->session->userdata['user_type'] == 'superadmin') {
    $partner_val = '1';
} else {
    $partner_val = '0';
}
?>

<input type="hidden" id="checkAdmin" value="<?= $partner_val; ?>">

<?php $this->load->view('vitals_footer.php'); ?>

<script type="text/javascript">

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


    $(document).ready(function () {
        var previous_type = localStorage.getItem('emp_type');
        if (previous_type != '') {
            $('#txt_employee').val(previous_type);
            var sel_text = $("#txt_employee option:selected").text();
            $('#type_name').html(sel_text);
            var link = "<?php echo base_url() . 'index.php/user/lists/'; ?>" + previous_type;
            $('.backPage').attr('href', link);
        }

        $(".dateCalendar").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy",
            maxDate: 0
        });

        $(".licenseCalendar").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy"
        });
    });

    $(document).on('change', '#txt_employee', function () {
        var type_id = $("#txt_employee").val();
        if (type_id != '') {
            var sel_text = $("#txt_employee option:selected").text();
            $('#type_name').html(sel_text);

            var link = "<?php echo base_url() . 'index.php/mprofile/lists/'; ?>" + type_id;
            $('.backPage').attr('href', link);
        } else {
            $('#type_name').html('Employee');
            var link = "<?php echo base_url() . 'index.php/mprofile/lists/3'; ?>";
            $('.backPage').attr('href', link);
        }
    });

    $(document).on('click', '.masterPicUpdatebtn', function () {
        $("input[id='my_file']").click();
    });

    $(document).on('change', "#my_file", function () {
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

    $('#user_form').validate({
        rules: {
            txt_employee: "required",
            txt_firstname: "required",
            txt_lastname: "required",
            txt_partner: {
                required: function (element) {
                    return $("#checkAdmin").val() == "1";
                }
            }

        },
        messages: {
            txt_employee: "Select type",
            txt_firstname: "Enter first name",
            txt_lastname: "Enter last name",
            txt_partner: "Select partner"
        }
    });
</script>

</body>
</html>