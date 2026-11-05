<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Employee - Login info')); ?>

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
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/personal/' . $emp_id; ?>">Personal</a></li>
                                    <li role="presentation" class="active"><a href="javascript:void(0)">Login</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/reporting/' . $emp_id; ?>">Reporting</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/contact/' . $emp_id; ?>">Contacts</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/dependents/' . $emp_id; ?>">Dependents</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/immigration/' . $emp_id; ?>">Immigration</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/job/' . $emp_id; ?>">Job & Salary</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/bank/' . $emp_id; ?>">Bank</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/education/' . $emp_id; ?>">Education</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/document/' . $emp_id; ?>">Document</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new ">
                                    <form id="login_form" method="post" action="<?php echo base_url() . 'index.php/user/add_login'; ?>" autocomplete="off" onsubmit="return validateForm();">
                                        <input type="hidden" name="employee_id" value="<?= $emp_id; ?>">
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>User Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control employeeInput" name="user_name" id="user_name" value="<?= $login[0]['user_name']; ?>" disabled placeholder="User name" />
                                                        <label class="error display-hide" id="nameErr"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            if (count($login) > 0) {
                                                $pwrd = '******';
                                            } else {
                                                $pwrd = '';
                                            }
                                            ?>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>New Password <span class="text-danger">*</span></label>
                                                        <input type="Password" class="form-control employeeInput" disabled name="user_newpass" id="user_newpass" value="<?= $pwrd; ?>" placeholder="New password" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>Confirm Password <span class="text-danger">*</span></label>
                                                        <input type="Password" class="form-control employeeInput" disabled name="user_password" value="<?= $pwrd; ?>" placeholder="Confirm password" />
                                                    </div>
                                                    <?php
                                                    $partner_access = explode(',', $login[0]['partner_access']);
                                                    $partner_val = '';
                                                    if (count($partner_access) > 0) {
                                                        $partner_val = "'" . implode("', '", $partner_access) . "'";
                                                    }

                                                    $split_menu = explode(',', $login[0]['menu_access']);
                                                    $split_sector = explode(',', $login[0]['sector_access']);
                                                    $split_program = explode(',', $login[0]['program_access']);

                                                    $deals_from = isset($login[0]['deals_from_date']) && $login[0]['deals_from_date'] != '0000-00-00' ? date('d-m-Y', strtotime($login[0]['deals_from_date'])) : '';
                                                    $deals_to = isset($login[0]['deals_to_date']) && $login[0]['deals_to_date'] != '0000-00-00' ? date('d-m-Y', strtotime($login[0]['deals_to_date'])) : '';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Partner Name <span class="text-danger">*</span></label>
                                                    <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                                        <select class="form-control employeeInput" disabled name="user_partner">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($partner_type as $partner) { ?>
                                                                <option value="<?= $partner['id']; ?>" <?php
                                                                if ($partner['id'] == $employee[0]['partner_id']) {
                                                                    echo 'selected';
                                                                }
                                                                ?>><?= $partner['partner_name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                <?php } else { ?>
                                                    <input type="text" readonly="" class="form-control employeeInput" value="<?= $this->session->userdata['partner_name']; ?>">
                                                    <input type="hidden" name="user_partner" value="<?= $this->session->userdata['partner_id']; ?>">
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>User Role <span class="text-danger">*</span></label>
                                                <select class="form-control employeeInput" disabled name="user_role" id="user_role" onchange="loadCustomFields(this.value);">
                                                    <option value="">--Select--</option>
                                                    <option value="4" <?php
                                                    if ($login[0]['user_role'] == 4) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Custom User</option>
                                                    <option value="2" <?php
                                                    if ($login[0]['user_role'] == 2) {
                                                        echo 'selected';
                                                    }
                                                    ?>>Partner Admin</option>
                                                    <option value="1" <?php
                                                    if ($login[0]['user_role'] == 1) {
                                                        echo 'selected';
                                                    }
                                                    ?>>User</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Additional Partner Access</label>
                                                <select class="form-control employeeInput" id="accessibleTo" disabled multiple="multiple" name="user_partner_access[]">
                                                    <?php foreach ($partner_type as $partner) { ?>
                                                        <option value="<?= $partner['id']; ?>" <?php
                                                        if (in_array($partner['id'], $partner_access)) {
                                                            echo 'selected';
                                                        }
                                                        ?>><?= $partner['partner_name']; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select class="form-control employeeInput" disabled name="user_status">
                                                <option value="">--Select--</option>
                                                <option value="1" <?php
                                                if ($login[0]['status'] != 2) {
                                                    echo 'selected';
                                                }
                                                ?>>Enabled</option>
                                                <option value="2" <?php
                                                if ($login[0]['status'] == 2) {
                                                    echo 'selected';
                                                }
                                                ?>>Disabled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4 customeRole">
                                        <div class="form-group">
                                            <label>Modules</label>
                                            <select class="form-control employeeInput" id="moduleaccess" disabled multiple="multiple" name="user_module_access[]">
                                                <option value="1" <?php
                                                if (in_array('1', $split_menu)) {
                                                    echo "selected";
                                                }
                                                ?>>Home</option>
                                                <option value="2" <?php
                                                if (in_array('2', $split_menu)) {
                                                    echo "selected";
                                                }
                                                ?>>Deals</option>
                                                <option value="3" <?php
                                                if (in_array('3', $split_menu)) {
                                                    echo "selected";
                                                }
                                                ?>>Applications</option>
                                                <option value="4" <?php
                                                if (in_array('4', $split_menu)) {
                                                    echo "selected";
                                                }
                                                ?>>Preliminary Assessment</option>
                                                <option value="5" <?php
                                                if (in_array('5', $split_menu)) {
                                                    echo "selected";
                                                }
                                                ?>>Detailed Diligence</option>
                                                <option value="6" <?php
                                                if (in_array('6', $split_menu)) {
                                                    echo "selected";
                                                }
                                                ?>>Portfolio</option>
                                                <option value="7" <?php
                                                if (in_array('7', $split_menu)) {
                                                    echo "selected";
                                                }
                                                ?>>Reports</option>
                                                <option value="8" <?php
                                                if (in_array('8', $split_menu)) {
                                                    echo "selected";
                                                }
                                                ?>>Funds/Grants</option>
                                                <option value="9" <?php
                                                if (in_array('9', $split_menu)) {
                                                    echo "selected";
                                                }
                                                ?>>Requests</option>
                                                <option value="10" <?php
                                                if (in_array('10', $split_menu)) {
                                                    echo "selected";
                                                }
                                                ?>>Approve</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 col-md-4 customeRole">
                                        <div class="form-group">
                                            <label>Sector</label>
                                            <select class="form-control employeeInput" id="sectoraccess" disabled multiple="multiple" name="user_sector_access[]">
                                                <?php foreach ($sector_list as $list) { ?>
                                                    <option value="<?php echo $list['id']; ?>" <?php
                                                    if (in_array($list['id'], $split_sector)) {
                                                        echo "selected";
                                                    }
                                                    ?>><?php echo $list['sector']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row customeRole">
                                <div class="col-12 col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>Programmes</label>
                                        <select class="form-control employeeInput" id="programaccess" disabled multiple="multiple" name="user_program_access[]">
                                            <option value="0" <?php
                                            if (in_array('0', $split_program)) {
                                                echo "selected";
                                            }
                                            ?>>Incubation</option>
                                            <option value="3" <?php
                                            if (in_array('3', $split_program)) {
                                                echo "selected";
                                            }
                                            ?>>Pitch</option>
                                            <option value="5" <?php
                                            if (in_array('5', $split_program)) {
                                                echo "selected";
                                            }
                                            ?>>FPAI - IC</option>
                                            <option value="6" <?php
                                            if (in_array('6', $split_program)) {
                                                echo "selected";
                                            }
                                            ?>>UBS Challenge</option>
                                            <option value="7" <?php
                                            if (in_array('7', $split_program)) {
                                                echo "selected";
                                            }
                                            ?>>YSVF</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>Deals Duration From</label>
                                        <div class="position-relative">
                                            <input type="text" class="startDat form-control dateCalendar employeeInput" disabled name="deals_from" placeholder="dd-mm-yyyy" value="<?= $deals_from; ?>" />
                                            <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>Deals Duration To</label>
                                        <div class="position-relative">
                                            <input type="text" class="endDat form-control dateCalendar employeeInput" disabled name="deals_to" placeholder="dd-mm-yyyy" value="<?= $deals_to; ?>" />
                                            <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-4 col-md-4 customeRole">
                                    <div class="form-group">
                                        <label>Independent Shortlist</label>
                                        <input type="checkbox" class="employeeInput" id="shortlistID" disabled name="shortlistID" value="1" <?php
                                        if ($login[0]['independent_shortlist'] == '1') {
                                            echo "checked";
                                        }
                                        ?>>
                                        <label for="shortlistID">Yes</label>
                                    </div>
                                </div>
                                <?php
                                if ($this->session->userdata['user_type'] == 'superadmin') {
                                    $all_access = array('1', '2', '3', '4', '5', '6');
                                    $tab_access = explode(',', $login[0]['tab_access']);
                                    $tab_val = '';
                                    if (count($tab_access) > 0) {
                                        $tab_val = "'" . implode("', '", $tab_access) . "'";
                                    }
                                    $reset_access = array_diff($all_access, $tab_access);
                                    ?>
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Allow Access Tabs <span class="text-danger">*</span></label>
                                            <select class="form-control employeeInput" disabled id="multiselect" multiple name="tab_access[]">
                                                <option value="1" <?php
                                                if (in_array('1', $tab_access)) {
                                                    echo 'selected';
                                                }
                                                ?>>Bank</option>
                                                <option value="2" <?php
                                                if (in_array('2', $tab_access)) {
                                                    echo 'selected';
                                                }
                                                ?>>Dependents</option>
                                                <option value="3" <?php
                                                if (in_array('3', $tab_access)) {
                                                    echo 'selected';
                                                }
                                                ?>>Education</option>
                                                <option value="4" <?php
                                                if (in_array('4', $tab_access)) {
                                                    echo 'selected';
                                                }
                                                ?>>Immigration</option>
                                                <option value="5" <?php
                                                if (in_array('5', $tab_access)) {
                                                    echo 'selected';
                                                }
                                                ?>>Job & Salary</option>
                                                <option value="6" <?php
                                                if (in_array('6', $tab_access)) {
                                                    echo 'selected';
                                                }
                                                ?>>Report-to</option>
                                            </select>
                                            <label class="error display-hide" id="sel_error">Select
                                            access tab</label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row ">
                                <div class="col-12 col-sm-4  col-md-4 ">
                                    <div class="text-left">
                                        <ul class="vitals-links saveLinkView display-hide">
                                            <li><input type="submit" value="Save" class="vital_yellow_btn wdt_100"></li>
                                            <li><a href="<?php echo base_url() . 'index.php/user/login/' . $emp_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a>
                                            </li>
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

<input type="hidden" id="login_data" value="<?= count($login); ?>">
<?php $this->load->view('vitals_footer.php', array('multi_select' => 'multiselect')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('.customeRole').hide();

        var cust_id = "<?php echo $login[0]['user_role']; ?>";
        if (cust_id == 4) {
            $('.customeRole').show();
        }

        var previous_type = localStorage.getItem('emp_type');
        if (previous_type != '') {
            var link = "<?php echo base_url() . 'index.php/user/lists/'; ?>" + previous_type;
            $('.backPage').attr('href', link);
        }
    });

    $(document).ready(function () {
        $('#multiselect, #accessibleTo, #moduleaccess, #sectoraccess, #programaccess').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });
    });

    $('.summaryEdit').click(function () {
        $(".employeeInput").attr("disabled", false);
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
        datepickerEachFunction();
    });

    function loadCustomFields(id) {
        if (id == 4) {
            $('.customeRole').show();
        } else {
            $('.customeRole').hide();
        }
    }

    function datepickerEachFunction() {
        $('.startDat').datepicker({
            onSelect: function (selected) {
                $('.startDat').datepicker("option", "dateFormat", 'mm/dd/yy');
                $('.endDat').val('');
                var dt = new Date(selected);
                var dateval = dt.getDate();
                var monthval = dt.getMonth() + 1;
                var yearval = dt.getFullYear();
                if (monthval < 10) {
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
                $('.startDat').val(fulldatevalue);
                dt.setDate(dt.getDate() + 1);
                $('.endDat').datepicker("option", {minDate: dt});
            }
        });

        $('.endDat').datepicker({
            onSelect: function (selected) {
                var dt = new Date(selected);
                var dateval = dt.getDate();
                var monthval = dt.getMonth() + 1;
                var yearval = dt.getFullYear();
                if (monthval < 10) {
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
                $('.endDat').val(fulldatevalue);
                dt.setDate(dt.getDate() - 1);
            }
        });
    }

    function validateForm() {
        var access = $('#multiselect').val();
        var tab_length = access.length;
        var sr_error = 0;

        if (tab_length >= 1) {
            sr_error = 0;
            $('#sel_error').addClass("display-hide");
            $('#sel_error').removeClass("display-show");
        } else {
            sr_error = 1;
            $('#sel_error').removeClass("display-hide");
            $('#sel_error').addClass("display-show");
            return false;
        }

        if (sr_error == 0) {
            $('#sel_error').addClass("display-hide");
            $('#sel_error').removeClass("display-show");
            $('form#login_form').submit();
            return false;
        }
    }

    $(document).on('change', '#user_name', function () {
        var userid = "<?php echo $emp_id; ?>";
        var partnerid = "<?php echo $employee[0]['partner_id']; ?>";
        var username = $('#user_name').val();
        $.ajax({
            url: "<?php echo base_url() . 'index.php/user/loginName'; ?>",
            type: "post",
            data: {id: userid, partner: partnerid, check_user: username},
            success: function (msg) {
                if (msg == '1') {
                    $('#nameErr').html("<b>" + username + "</b> already exist");
                    $('#nameErr').addClass("display-show");
                    $('#user_name').val('');
                    $('#user_name').focus();
                }
                setTimeout(function () {
                    $('#nameErr').html('');
                    $('#nameErr').addClass('display-hide');
                }, 3000);
            }
        });
    });

    $('#login_form').validate({
        rules: {
            user_name: "required",
            user_newpass: {
                required: function (element) {
                    return $("#login_data").val() == "0";
                }
            },
            user_password: {
                required: function (element) {
                    return $("#user_newpass").val() != "";
                },
                equalTo: "#user_newpass"
            },
            user_partner: "required",
            user_status: "required",
            user_role: "required"
        },
        messages: {
            user_name: "Enter name",
            user_newpass: "Enter new password",
            user_password: {
                required: "Enter confirm password",
                equalTo: "Confirm password same as new password"
            },
            user_partner: "Select partner",
            user_status: "Select status",
            user_role: "Select role"
        }
    });
</script>

</body>
</html>