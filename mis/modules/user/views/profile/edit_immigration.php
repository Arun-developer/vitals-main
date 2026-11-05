<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Employee - Edit Immigration info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'emp_list')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/user/immigration/' . $emp_id; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?= $employee[0]['emp_name']; ?></h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                        <ul class="vitals-links">
                            <li><a href="<?php echo base_url() . 'index.php/user/add_immigration/' . $emp_id; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add Immigration</a></li>
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
                                    <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/user/immigration/' . $emp_id; ?>">Immigration</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/job/' . $emp_id; ?>">Job & Salary</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/bank/' . $emp_id; ?>">Bank</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/education/' . $emp_id; ?>">Education</a></li>
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
                                            <h4 class="vitals_innerSub">Immigration Details</h4>
                                        </div>
                                    </div>
                                    <?php
                                    $pass_issue = (isset($immigration[0]['passport_issue_date']) && $immigration[0]['passport_issue_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($immigration[0]['passport_issue_date'])) : '';
                                    $pass_expire = (isset($immigration[0]['passport_expiry_date']) && $immigration[0]['passport_expiry_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($immigration[0]['passport_expiry_date'])) : '';
                                    $visa_issue = (isset($immigration[0]['visa_issue_date']) && $immigration[0]['visa_issue_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($immigration[0]['visa_issue_date'])) : '';
                                    $visa_expire = (isset($immigration[0]['visa_expiry_date']) && $immigration[0]['visa_expiry_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($immigration[0]['visa_expiry_date'])) : '';
                                    ?>
                                    <form id="education_form" method="post" action="<?php echo base_url() . 'index.php/user/update_immigration'; ?>" autocomplete="off">
                                        <input type="hidden" name="immigration_id" value="<?= $immigration[0]['id']; ?>">
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>Passport Citizenship</label>
                                                        <select class="form-control employeeInput" disabled name="img_country">
                                                            <option value="">-- Select --</option>
                                                            <?php foreach ($country as $c_name) { ?>
                                                                <option value="<?= $c_name['id']; ?>" <?php
                                                                if ($immigration[0]['citizenship'] == $c_name['id']) {
                                                                    echo "selected";
                                                                }
                                                                ?>><?= $c_name['country_name']; ?></option>
                                                                    <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Passport Number</label>
                                                        <input type="text" class="form-control employeeInput" disabled name="pass_number" maxlength="15" placeholder="Passport number" value="<?= $immigration[0]['passport_number']; ?>" />
                                                    </div>
                                                    <div class="form-group  ">
                                                        <label>Passport Issued Date</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control employeeInput dateCalendar" disabled name="pass_issue_date" placeholder="dd-mm-yyyy" value="<?= $pass_issue; ?>" />
                                                            <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>Type of Visa</label>
                                                        <input type="text" class="form-control employeeInput" disabled name="visa_type" maxlength="20" placeholder="Type of visa" value="<?= $immigration[0]['visa_type']; ?>" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Visa Number</label>
                                                        <input type="text" class="form-control employeeInput" disabled name="visa_number" maxlength="15" placeholder="Visa number" value="<?= $immigration[0]['visa_number']; ?>" />
                                                    </div>
                                                    <div class="form-group  ">
                                                        <label>Passport Expiry Date</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control employeeInput dateCalendar" disabled name="pass_expiry" placeholder="dd-mm-yyyy" value="<?= $pass_expire; ?>" />
                                                            <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group ">
                                                        <label>Visa Issued Date</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control employeeInput dateCalendar" disabled name="visa_issue_date" placeholder="dd-mm-yyyy" value="<?= $visa_issue; ?>" />
                                                            <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <label>Visa Expiry Date</label>
                                                        <div class="position-relative">
                                                            <input type="text" class="form-control employeeInput dateCalendar" disabled name="visa_expiry" placeholder="dd-mm-yyyy" value="<?= $visa_expire; ?>" />
                                                            <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Comments</label>
                                                        <textarea class="form-control employeeInput" disabled name="img_comments" maxlength="200" placeholder="Comments" ><?= $immigration[0]['img_comments']; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-sm-4  col-md-4 ">
                                                <div class="text-left">
                                                    <ul class="vitals-links saveLinkView display-hide">
                                                        <li><input type="submit" value="Save" class="vital_yellow_btn wdt_100"></li>
                                                        <li><a href="<?php echo base_url() . 'index.php/user/edit_immigration/' . $immigration[0]['id']; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
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
        $(".dateCalendar").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy"
        });

        var previous_type = localStorage.getItem('emp_type');
        if (previous_type != '') {
            var link = "<?php echo base_url() . 'index.php/user/lists/'; ?>" + previous_type;
            $('.backPage').attr('href', link);
        }
    });

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