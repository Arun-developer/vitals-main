<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Employee - Edit Education info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'emp_list')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/user/education/' . $emp_id; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <?php
                        if ($education[0]['qualification'] == 1) {
                            $graduate = 'UG';
                        } else if ($education[0]['qualification'] == 2) {
                            $graduate = 'PG';
                        }
                        $qualify = $graduate . ' (' . $education[0]['qualification_name'] . ')';
                        ?>
                        <h4><?= $employee[0]['emp_name']; ?></h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                        <ul class="vitals-links">
                            <li><a href="<?php echo base_url() . 'index.php/user/add_education/' . $emp_id; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add Education</a></li>
                            <li class="edit"><a href="javascript:void(0)" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/personal/' . $emp_id; ?>">Personal</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/login/' . $emp_id; ?>">Login</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/reporting/' . $emp_id; ?>">Reporting</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/contact/' . $emp_id; ?>">Contacts</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/dependents/' . $emp_id; ?>">Dependents</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/immigration/' . $emp_id; ?>">Immigration</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/job/' . $emp_id; ?>">Job & Salary</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/bank/' . $emp_id; ?>">Bank</a></li>
                                    <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/user/education/' . $emp_id; ?>">Education</a></li>
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
                                            <h4 class="vitals_innerSub">Education Details</h4>
                                        </div>
                                    </div>
                                    <form id="education_form" method="post" action="<?php echo base_url() . 'index.php/user/update_education'; ?>" autocomplete="off">
                                        <input type="hidden" name="education_id" value="<?= $education[0]['id']; ?>">
                                        <input type='hidden' id='qual_id' value="<?= $education[0]['qualification']; ?>">
                                        <input type='hidden' id='spec_id' value="<?= $education[0]['degree']; ?>">
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>Qualification</label>
                                                        <select class="form-control employeeInput" disabled name="edu_graduate" onchange="getDegree(this.value)">
                                                            <option value="">--Select--</option>
                                                            <option value="1" <?php
                                                            if ($education[0]['qualification'] == 1) {
                                                                echo "selected";
                                                            }
                                                            ?>>Under Graduate</option>
                                                            <option value="2" <?php
                                                            if ($education[0]['qualification'] == 2) {
                                                                echo "selected";
                                                            }
                                                            ?>>Post Graduate</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Major/Specialization</label>
                                                        <select class="form-control employeeInput" disabled name="edu_degree" id="loadSSpecialization" >
                                                            <option value="">--Select--</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Number of Years</label>
                                                        <input type="text" class="form-control employeeInput" disabled name="edu_years" maxlength="1" placeholder="Number of years" value="<?= $education[0]['year_numbers']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>Institute Name</label>
                                                        <input type="text" class="form-control employeeInput" disabled name="institute_name" maxlength="50" placeholder="Institute name" value="<?= $education[0]['institute_name']; ?>" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>City</label>
                                                        <input type="text" class="form-control employeeInput" disabled name="edu_city" maxlength="20" placeholder="City" value="<?= $education[0]['city']; ?>" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Year From</label>
                                                        <input type="text" class="form-control employeeInput" disabled name="edu_yearfrom" maxlength="4" placeholder="Year from" value="<?= $education[0]['year_from']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>GPA/Score</label>
                                                        <input type="text" class="form-control employeeInput" disabled name="gpa_score" maxlength="5" placeholder="GPA score" value="<?= $education[0]['gpa_score']; ?>" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>State</label>
                                                        <input type="text" class="form-control employeeInput" disabled name="edu_state" maxlength="20" placeholder="State" value="<?= $education[0]['state']; ?>" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Year To</label>
                                                        <input type="text" class="form-control employeeInput" disabled name="edu_yearto" maxlength="4" placeholder="Year to" value="<?= $education[0]['year_to']; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row ">
                                            <div class="col-12 col-sm-4  col-md-4 ">
                                                <div class="text-left">
                                                    <ul class="vitals-links saveLinkView display-hide">
                                                        <li><input type="submit" value="Save" class="vital_yellow_btn wdt_100"></li>
                                                        <li><a href="<?php echo base_url() . 'index.php/user/edit_education/' . $education[0]['id']; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
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
            var link = "<?php echo base_url() . 'index.php/user/lists/'; ?>" + previous_type;
            $('.backPage').attr('href', link);
        }

        var qual_id = $('#qual_id').val();
        getDegree(qual_id);
    });

    function getDegree(val) {
        var myarray = new Array();
        if (val != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/user/getEducationDegree",
                data: {type: val},
                dataType: 'json',
                success: function (msg) {
                    $('#loadSSpecialization').find('option').not(':first').remove().end();
                    $.each(msg, function (i, value) {
                        myarray.push(value.id);
                        $('#loadSSpecialization').append($('<option>').text(value.qualification_name).attr('value', value.id));
                    });
                    var spec_id = $('#spec_id').val();
                    if ($.inArray(spec_id, myarray) != -1) {
                        $('#loadSSpecialization').val(spec_id);
                    } else {
                        $('#loadSSpecialization').val('');
                    }
                }
            });
        } else {
            $('#loadSSpecialization').find('option').not(':first').remove().end();
        }
    }

    $('.summaryEdit').click(function () {
        $(".employeeInput").attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    });

</script>

</body>
</html>