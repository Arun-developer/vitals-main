
<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Profile -Employee Details')); ?>
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
                        <h4><?= $emp_name; ?></h4>
                        <?php $emp_id = $this->session->userdata('emp_number'); ?>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <li class="edit"><a href="<?php echo base_url() . 'index.php/myprofile/edit_education/' . $emp_id; ?>" id="editpersonal" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt" style="text-align:right;"></i> Edit</a></li>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/personal/' . $emp_id; ?>">Personal</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/login/' . $emp_id; ?>">Login</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/reporting/' . $emp_id; ?>">Reporting</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/contact/' . $emp_id; ?>">Contacts</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/dependents/' . $emp_id; ?>">Dependents</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/immigration/' . $emp_id; ?>">Immigration</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/job/' . $emp_id; ?>">Job & Salary</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/bank/' . $emp_id; ?>">Bank</a></li>
                                    <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/myprofile/education/' . $emp_id; ?>">Education</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/document/' . $emp_id; ?>">Document</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new ">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="vitals_innerSub">Add Education Details</h4>
                                        </div>
                                    </div>
                                    <form id="education_form" method="post" action="<?php echo base_url() . 'index.php/myprofile/submit_education'; ?>" autocomplete="off">
                                        <input type="hidden" name="employee_id" value="<?= $emp_id; ?>">
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>Qualification</label>
                                                        <select class="form-control employeeInput" name="edu_graduate" onchange="getDegree(this.value)">
                                                            <option value="">--Select--</option>
                                                            <option value="1">Under Graduate</option>
                                                            <option value="2">Post Graduate</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>Institute Name</label>
                                                        <input type="text" class="form-control employeeInput" name="institute_name" maxlength="50" placeholder="Institute name" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>GPA/Score</label>
                                                        <input type="text" class="form-control employeeInput" name="gpa_score" maxlength="5" placeholder="GPA score" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Major/Specialization</label>
                                                    <select class="form-control employeeInput" name="edu_degree" id="loadSSpecialization">
                                                        <option value="">--Select--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" class="form-control employeeInput" name="edu_city" maxlength="20" placeholder="City" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <input type="text" class="form-control employeeInput" name="edu_state" maxlength="20" placeholder="State" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Number of Years</label>
                                                    <input type="text" class="form-control employeeInput" name="edu_years" maxlength="1" placeholder="Number of years" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Year From</label>
                                                    <input type="text" class="form-control employeeInput" name="edu_yearfrom" maxlength="4" placeholder="Year from" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Year To</label>
                                                    <input type="text" class="form-control employeeInput" name="edu_yearto" maxlength="4" placeholder="Year to" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row ">
                                            <div class="col-12 col-sm-4  col-md-4 ">
                                                <div class="text-left">
                                                    <ul class="vitals-links saveLinkView">
                                                        <li><input type="submit" value="Add" class="vital_yellow_btn wdt_100"></li>
                                                        <li><a href="<?php echo base_url() . 'index.php/myprofile/education/' . $emp_id; ?>" class="vital_bordered_btn wdt_100">Cancel</a></li>
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

<?php $this->load->view('vitals_footer.php'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        var previous_type = localStorage.getItem('emp_type');
        if (previous_type != '') {
            var link = "<?php echo base_url() . 'index.php/myprofile/lists/'; ?>" + previous_type;
            $('.backPage').attr('href', link);
        }
    });

    function getDegree(val) {
        var myarray = new Array();
        if (val != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/myprofile/getEducationDegree",
                data: {
                    type: val
                },
                dataType: 'json',
                success: function (msg) {
                    $('#loadSSpecialization').find('option').not(':first').remove().end();
                    $.each(msg, function (i, value) {
                        myarray.push(value.id);
                        $('#loadSSpecialization').append($('<option>').text(value.qualification_name).attr('value', value.id));
                    });
                }
            });
        } else {
            $('#loadSSpecialization').find('option').not(':first').remove().end();
        }
    }
</script>

</body>
</html>