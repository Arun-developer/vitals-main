<?php
if ($this->session->userdata('user_type') == 'admin' || $this->session->userdata('user_type') == 'superadmin') {
    $menu_name = 'approve';
} else {
    $menu_name = 'request';
}
$this->load->view('vitals_header.php', array('main_menu' => '', 'page_title' => 'Change Password - ' . $this->session->userdata['emp_number'] . '_' . $this->session->userdata['emp_name']));
?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'change_password', 'page' => 'change_password')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><i class="fas fa-angle-left"></i> Back</a></span>
                        <h4><?= 'Change Password'; ?></h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <li class="edit"><a href="javascript:" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                        </ul>
                    </div>
                </div>

                <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form id="changePassword" method="post" action="<?php echo site_url('changepass/change_pass/'); ?>" autocomplete="off">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div>
                                                <div class="form-group">
                                                    <label>Old Password <span class="text-danger">*</span></label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control employeeInput" disabled name="oldPassword" id="txtOldPassword" placeholder="Enter old password" maxlength="20" />
                                                        <span class="passwordIcon" id="oldPassword"><i class="far fa-eye-slash"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div>
                                                <div class="form-group">
                                                    <label>New Password <span class="text-danger">*</span></label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control employeeInput" disabled name="newPassword" id="txtNewPassword" placeholder="Enter new password" maxlength="20" />
                                                        <span class="passwordIcon" id="newPassword"><i class="far fa-eye-slash"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div>
                                                <div class="form-group">
                                                    <label>Confirm Password <span class="text-danger">*</span></label>
                                                    <div class="position-relative">
                                                        <input type="Password" class="form-control employeeInput" disabled name="confirmPassword" id="txtConfirmPassword" placeholder="Enter confirm password" maxlength="20" />
                                                        <span class="passwordIcon" id="confirmPassword"><i class="far fa-eye-slash"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-12 col-sm-4  col-md-4 ">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView display-hide">
                                                    <li><input type="submit" value="Save" name="txtSubmit" class="vital_yellow_btn wdt_100"></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/changepass'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a>
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
    </div>
</div>
</div>
</div>

<?php $this->load->view('vitals_footer.php'); ?>
<style>
    span.passwordIcon {
        right: 8px !important;
    }
</style>
<script type="text/javascript">
    $('.inputplan-structureall').css({
        'height': (($(window).height()) - 190) + 'px'
    });
    $('#changePassword').validate({
        rules: {
            oldPassword: {
                required: true,
                remote: {
                    url: "<?php echo base_url() . 'index.php/changepass/checkOldPassword'; ?>",
                    type: "post",
                    data: {
                        oldPassword: function () {
                            return $("#txtOldPassword").val();
                        }
                    }
                }
            },
            newPassword: "required",
            confirmPassword: {
                required: function (element) {
                    return $("#txtNewPassword").val() == "";
                },
                equalTo: "#txtNewPassword"
            }
        },
        messages: {
            oldPassword: {
                required: "Enter old password",
                remote: "Enter valid password"
            },
            newPassword: "Enter new password",
            confirmPassword: {
                required: "Enter confirm password",
                equalTo: "Confirm password same as new password"
            }
        }
    });

    $(document).on('click', '#oldPassword', function (e) {
        var target = e.currentTarget;
        $(target).hasClass('show') ? hidePassword($(target), 'txtOldPassword', 'oldPassword') : showPassword($(target), 'txtOldPassword', 'oldPassword');
    });

    $(document).on('click', '#newPassword', function (e) {
        var target = e.currentTarget;
        $(target).hasClass('show') ? hidePassword($(target), 'txtNewPassword', 'newPassword') : showPassword($(target), 'txtNewPassword', 'newPassword');
    });

    $(document).on('click', '#confirmPassword', function (e) {
        var target = e.currentTarget;
        $(target).hasClass('show') ? hidePassword($(target), 'txtConfirmPassword', 'confirmPassword') : showPassword($(target), 'txtConfirmPassword', 'confirmPassword');
    });

    function hidePassword(e, field, icon) {
        e.removeClass('show').addClass('hide');
        $('#' + field).attr('type', 'password');
        $('#' + icon + ' i').removeClass('fa-eye');
        $('#' + icon + ' i').addClass('fa-eye-slash');
    }

    function showPassword(e, field, icon) {
        e.removeClass('hide').addClass('show');
        $('#' + field).attr('type', 'text');
        $('#' + icon + ' i').removeClass('fa-eye-slash');
        $('#' + icon + ' i').addClass('fa-eye');
    }

    $('.summaryEdit').click(function () {
        $(".employeeInput").attr("disabled", false);
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    });

</script>

</body>
</html>