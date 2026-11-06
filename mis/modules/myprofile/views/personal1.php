
<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Profile -Employee Details')); ?>
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
                         <?php $emp_id = $this->session->userdata('emp_number'); ?> 
                         <?php
                        $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
                        $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';
                        ?>
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
                    <div>
                        <div class="tab-slider--navform">
                            <ul class="tab-slider--tabsform">
                                <?php if ($this->session->userdata('user_type') == 'employee') { ?>
                                    <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/myprofile/personal'. $emp_id; ?>">Personal</a></li>
                                <?php } ?>
                                <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/myprofile/reporting/' . $emp_id; ?>">Reporting</a></li>
                                <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/myprofile/contacts'; ?>">Contacts</a></li>
                                <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/myprofile/dependents'; ?>">Dependents</a></li>
                                <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/myprofile/immigration'; ?>">Immigration</a></li>
                                <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/myprofile/job_salary'; ?>">Job & Salary</a></li>
                                <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/myprofile/bank'; ?>">Bank</a></li>
                                <?php if ($this->session->userdata('user_type') == 'employee') { ?>
                                    <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/myprofile/education'; ?>">Education</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <!-- <div class="plan-structure-vital"> -->
                                    <main class="page-content">
                                        <div class="inputplan-structureall plan-structure-new">
                                            <form method="post" id="applyleaveForm" action="<?php echo base_url() . 'index.php/myprofile/editpersonal'; ?>" enctype="multipart/form-data" autocomplete="off">
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">

                                                        <?php
                                                            if (isset($emp_picture)) {
                                                                ?>
                                                                <img src="<?php echo base_url() . '/uploads/profile/'; ?><?php echo $emp_picture;?>" width="100" height="60" alt="profile" class="my_profile">  
                                                            <?php
                                                            }else{
                                                            ?>
                                                        <img src="<?php echo base_url() . '/uploads/partner_logo/profile.png'; ?>" width="100" height="60" alt="profile" class="my_profile"> 
                                                        <?php } ?>  
                                                        <label>Profile Picture:</label>
                                                        <input id="image" type="file" name="emp_picture" >
                                                         </div>

                                                    </div>
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Employee Type </label>
                                                           <input type="text" class="form-control" value="<?php echo $user_type; ?>" disabled />
                                                        </div>                                                  
                                                    </div> 
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Employee Id</label>
                                                           <input type="text" class="form-control disableremove" value="<?= $emp_id; ?>" disabled />
                                                        </div>                                                  
                                                    </div> 
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group ">
                                                            <label>First Name<small class="text-danger">*</small></label>
                                                            <input type="text" name = first_name class="form-control first_name" value=" <?php echo $emp_first_name;?>" disabled />
                                                        </div>

                                                    </div>
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Middle Name </label>
                                                           <input type="text" name= middle_name class="form-control middle_name" value="<?php echo $emp_middle_name; ?>" disabled />
                                                        </div>                                                  
                                                    </div> 
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Last Name</label>
                                                           <input type="text" name= last_name class="form-control last_name" value="<?php echo $emp_last_name; ?>" disabled />
                                                        </div>                                                  
                                                    </div> 
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Date of Birth <small class="text-danger">*</small></label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control dob" id="dob" name= dob required="" value="<?php echo date('d-m-Y',$emp_dob); ?>" placeholder="dd-mm-yyyy" disabled/>
                                                                <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Age</label>
                                                           <input type="text" name= age id="age" class="form-control age" value="<?php echo $emp_age; ?>"  disabled />
                                                        </div>                                                  
                                                    </div>
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Gender </label>
                                                            <select class="form-control gender" name="gender" id="gender" disabled>
                                                                <?php 
                                                                if(php72_cmp($emp_gender) ==1){
                                                                    $emp_gender = 'Male';
                                                                }else{
                                                                    $emp_gender ='Female';
                                                                }
                                                                ?>

                                                                <option value="<?php echo $emp_gender; ?>">Male</option>             
                                                                <option value="<?php echo $emp_gender; ?>">Female</option>             
                                                            </select>
                                                        </div>                                                  
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Blood Group<small class="text-danger">*</small></label>
                                                            <input type="text" name= blood_group class="form-control blood_group" value="<?php echo $blood_group; ?>" disabled />
                                                        </div>

                                                    </div>
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Marital Status</label>
                                                           <select name = marital_status class="form-control"  id="marital_status" disabled>
                                                            <?php 
                                                                if(php72_cmp($marital_status) ==1){
                                                                    $marital_status = '2';
                                                                }else{
                                                                    $marital_status ='3';
                                                                }
                                                                ?>                                     
                                                                <option value="<?php echo $blood_group; ?>">Single </option>             
                                                                <option value="<?php echo $blood_group; ?>">Married</option>             
                                                            </select>
                                                        </div>                                                  
                                                    </div> 
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Nationality</label>
                                                           <select class="form-control" name="nationality" id="nationality" disabled>

                                                                <option value="1" selected>--Select--</option>                                            
                                                                <option value="2">Indian </option>             
                                                                <option value="3">America</option>             
                                                            </select>
                                                        </div>                                                  
                                                    </div> 
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Experience<small class="text-danger">*</small></label>
                                                            <select class="form-control" name="experience" id="experience" disabled>

                                                                <option value="1" selected>--Select--</option>                                            
                                                                <option value="2">01 </option>             
                                                                <option value="3">02</option>             
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>UAN Number</label>
                                                           <input type="text" name= uan_number id="uan_number" class="form-control" value="<?php echo $uan_number; ?>" disabled />
                                                        </div>                                                  
                                                    </div> 
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>PAN Number</label>
                                                           <input type="text" name = pan_number id="pan_number" class="form-control" value="<?php echo $pan_number; ?>" disabled />
                                                        </div>                                                  
                                                    </div> 
                                                </div>

                                                <div class="row ">
                                                    <div class="col-12 col-sm-4  col-md-4 ">
                                                        <ul class="vitals-links">
                                                            <li><button type="submit" id="submit_btn" class="vital_yellow_btn wdt_100 save" disabled>Save</button></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </form>
                                        <!-- </div> -->
                                    </main>
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

  $(document).on('click', '#editpersonal', function (e) {
    $('.first_name').removeAttr('disabled');
    $('.middle_name').removeAttr('disabled');
    $('.last_name').removeAttr('disabled');
    $('#dob').removeAttr('disabled');
    $('#age').removeAttr('disabled');
    $('#gender').removeAttr('disabled');
    $('.blood_group').removeAttr('disabled');
    $('#marital_status').removeAttr('disabled');
    $('#nationality').removeAttr('disabled');
    $('#experience').removeAttr('disabled');
    $('#uan_number').removeAttr('disabled');
    $('#pan_number').removeAttr('disabled');
    $('.save').removeAttr('disabled');
   
     });
    
   

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
