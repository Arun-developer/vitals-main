<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => 'Assign Incharge - ' . $innovation['name_of_enterprise'])); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'app_option', 'inv_stage' => $innovation['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                        <h4><?= $innovation['name_of_enterprise']; ?></h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                        <ul class="vitals-links">
                            <?php if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || in_array($this->session->userdata('emp_number'), $assigned_incharge)) { ?>
                                <li class="edit"><a href="javascript:" class="edt_btnVital summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <?php $get_app_status = $this->Mportfolio->get_appStatus($application_id); ?>

                <div class="plan-structure-vital vital_windowScroll">
                    <div>
                        <div class="tab-slider--navform">
                            <ul class="tab-slider--tabsform">
                                <li class="tab-slider--triggerform active"><a  href="<?php echo base_url() . 'index.php/application/assign_incharge/' . $application_id; ?>">Assign Incharge</a></li>
                                <?php if ($get_app_status[0]['status'] == '3' && $get_app_status[0]['status'] != '8') { ?>
                                    <li class="tab-slider--triggerform"><a  href="<?php echo base_url() . 'index.php/application/reopen/' . $application_id; ?>">Reopen</a></li>
                                <?php } else if ($get_app_status[0]['status'] != '3' && $get_app_status[0]['status'] != '8') { ?>
                                    <li class="tab-slider--triggerform"><a  href="<?php echo base_url() . 'index.php/application/close_application/' . $application_id; ?>">Close/Bank</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane userActiveSetupNew active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <form method="post" name="update_assignUser" id="update_assignUser" action="<?php echo base_url() . 'index.php/application/update_assignUser'; ?>" class="form" novalidate autocomplete="off">
                                    <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                    <div class="inputplan-structureall plan-structure-new">
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                <div class="form-group">
                                                    <select id="select_assign" class="multiselect" multiple="multiple" name="select_assign[]" >
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row leaveLabel">
                                            <div id="submit_btn_cls" class="col-12 col-sm-4  col-md-4" style="display:none;" >
                                                <ul class="vitals-links">
                                                    <li><input type="submit" value="Save" id="submit_btn" class="vital_yellow_btn wdt_100"></input></li>
                                                    <li><a href="" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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

<input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('partner_id'); ?>" />

<?php $this->load->view('vitals_footer.php', array('page_load' => 'user_setup')); ?>

<script type="text/javascript">
    $('.vital_windowScroll').css({
        'height': (($(window).height()) - 190) + 'px'
    });
    $(document).ready(function () {
        $(".ui-multiselect").width(550);
        $(".ui-multiselect > .available").width(274);
        $('.leaveLabel').css("cursor", "not-allowed");
        $('.leaveLabel').css("pointer-events", "none");
    });

    $(document).ready(function () {
        var partner_val = $("#branch").val();
        get_userLists(partner_val);
    });

    $(document).on('click', '.summaryEdit', function () {
        $(".multiselect").attr("disabled", false);
        $("#submit_btn_cls").css("display", "block");
        $(".edit").addClass("activeTabs");
        $('.leaveLabel').css("cursor", "pointer");
        $('.leaveLabel').css("pointer-events", "");
    });

    function get_userLists(branch_id) {
        var branch = branch_id;
        var inv_id = "<?= $application_id; ?>";
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('application/load_assign_incharge'); ?>",
            data: {'branch': branch, 'inv_id': inv_id},
            success: function (response) {
                var options = '';
                if (response.all_users == '' && response.ext_user == null) {
                    options = '<option value=""> Select </option>';
                    $("#select_assign").html('');
                    $('#select_assign').multiselect('destroy');
                    $("#select_assign").multiselect();
                } else if (response.all_users != '' || response.ext_user != null) {
                    '<option value="">Select </option>';
                    for (var i = 0; i < response.all_users.length; i++) {
                        options += '<option value="' + response.all_users[i].emp_number + '">' + response.all_users[i].emp_name + '</option>';
                    }
                    $('#select_assign').multiselect('destroy');
                    $("#select_assign").html(options);
                    if (response.ext_user != null) {
                        for (var i = 0; i < response.all_users.length; i++) {
                            if ($.inArray(response.all_users[i].emp_number, response.ext_user.assign_user) != -1) {
                                $("#select_assign").find("option[value=" + response.all_users[i].emp_number + "]").prop("selected", "selected");
                            }
                        }
                    }
                    $('#select_assign').multiselect();
                    $("#select_assign").multiselect("refresh");
                }
            }
        });
    }

</script>

<style type="text/css">
    .vitals_mainContent .tabpanel-details label {
        color: #212529;
        font-size: 13px !important;
    }
    .selected{
        width: 225px;
    }
    .ui-multiselect.ui-helper-clearfix.ui-widget {
        width: 100% !important;
    }
    .ui-multiselect.ui-helper-clearfix.ui-widget .selected,.ui-multiselect.ui-helper-clearfix.ui-widget .available{
        width: 50% !important;
    }
    .ui-multiselect.ui-helper-clearfix.ui-widget .selected .selected.connected-list.ui-sortable,.ui-multiselect.ui-helper-clearfix.ui-widget .available .available.connected-list{
        width: 100% !important;
    }
    .multiselect {
        height: 300px !important;
    }
</style>

</body>
</html>