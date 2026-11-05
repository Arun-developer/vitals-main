<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => $this->session->userdata['partner_name'] . ' - User Setup')); ?>

<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'user_setup')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>User Setup</h4>
                    </div>
                    <div class="col-xl-8 col-lg-6 col-md-12 col-12 text-right">
                        <ul class="vitals-links">
                            <li class="edit"><a href="javascript:" class="edt_btnVital summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                        </ul>
                    </div>
                </div>
                <?php if ($successMsg != '') { ?>
                    <div id="toast-container" aria-live="polite" class="manual_msg" aria-atomic="true" style="margin-top: -36px;">
                        <div id="toast-wrapper">
                            <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                <div class="toast-header bg-success text-white">
                                    <strong class="mr-auto"><?= $successMsg; ?></strong>
                                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                        <span aria-hidden="true" class="text-white">×</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane userActiveSetupNew active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <form method="post" name="insertEdit_usersetup" id="insertEdit_usersetup" action="<?php echo base_url() . 'index.php/user/insertEdit_usersetup'; ?>" class="form" novalidate autocomplete="off">
                                    <div class="inputplan-structureall plan-structure-new">
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <?php if ($admin_status != true) { ?>
                                                    <div class="form-group">
                                                        <label>Partner<span>*</span></label>
                                                        <select name="branch" id="branch" disabled class="form-control edit_cls">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($branch as $list) { ?>
                                                                <option value="<?php echo $list->id; ?>" ><?php echo $list->partner_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div id="partner_err"></div>
                                                    </div>
                                                <?php } else { ?>
                                                    <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('partner_id'); ?>" />
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>CEO</label>
                                                    <select name="ceo" id="ceo" disabled class="form-control edit_cls">
                                                        <option value="">--Select--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Chief Incubation Officer</label>
                                                    <select name="cio" id="cio" disabled class="form-control edit_cls">
                                                        <option value="">--Select--</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                                <div class="form-group">
                                                    <label>Incubation Committee Members</label>
                                                    <select id="icm" class="multiselect" multiple="multiple" name="icm[]" >
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Associate: Business Incubation</label>
                                                    <select id="abi" class="multiselect" multiple="multiple" name="abi[]" >
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Finance Members</label>
                                                    <select id="finance" class="multiselect" multiple="multiple" name="finance[]" >
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Donor</label>
                                                    <select id="donor" class="multiselect" multiple="multiple" name="donor_team[]" >
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col col-md-4">
                                                <div class="form-group">
                                                    <label>Pre - Incubation Committee</label>
                                                    <input name="pre_ic" id="pre_ic" disabled class="form-control edit_cls" type="text" placeholder="">
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
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <ul class="milestone-links">
                                                        </ul>
                                                    </div>
                                                </div>
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

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable', 'page_load' => 'user_setup')); ?>

<script type="text/javascript">

    $(document).ready(function () {
        setTimeout(function () {
            $('.manual_msg').addClass('display-hide');
        }, 3000);
        $(".ui-multiselect").width(550);
        $(".ui-multiselect > .available").width(274);
        $('.leaveLabel').css("cursor", "not-allowed");
        $('.leaveLabel').css("pointer-events", "none");
    });

    $(document).on('click', '#submit_btn', function (e) {
        $("#partner_err").html('');
        var partner_val = $("#branch").val();
        e.preventDefault();
        if (partner_val != '') {
            $('#insertEdit_usersetup').submit();
        } else {
            $("#partner_err").html('<label style="text-align:end;color: #FF0000 !important;" >Select Partner</label>');
        }
    });

    $(document).ready(function () {
        $("#branch").change(function () {
            var branch_id = $(this).val();
            if (branch_id != '') {
                $("#partner_err").html('');
            }
            trigger_user_setup(branch_id);
        });
        var admin_status = '<?php echo $admin_status; ?>';
        if (admin_status == true) {
            var partner_id = '<?php echo $partner_id; ?>';
            trigger_user_setup(partner_id);
        }
        $(document).on('click', '.summaryEdit', function () {
            $("#edit_status").val("1");
            $(".edit_cls").attr("disabled", false);
            $(".multiselect").attr("disabled", false);
            $("#submit_btn_cls").css("display", "block");
            $(".edit").addClass("activeTabs");
            $('.leaveLabel').css("cursor", "pointer");
            $('.leaveLabel').css("pointer-events", "");
        });

        function trigger_user_setup(branch_id) {
            branch = branch_id;
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<?php echo site_url('incubation_master/user_setup_sa'); ?>",
                data: {'branch': branch},
                success: function (response) {
                    var options = '';
                    var options_finance = '';
                    if (response.users == '' && response.defaultt == null) {
                        options = '<option value=""> Select </option>';
                        options_finance = '<option value=""> Select </option>';
                        $("#ceo").html(options);
                        $("#cio").html(options);
                        $("#icm").html('');
                        $('#icm').multiselect('destroy');
                        $("#icm").multiselect();
                        $("#abi").html('');
                        $('#abi').multiselect('destroy');
                        $("#abi").multiselect();
                        $("#pre_ic").val('');
                    } else if (response.users != '' || response.defaultt != null) {
                        '<option value="">Select </option>';
                        for (var i = 0; i < response.users.length; i++) {
                            options += '<option value="' + response.users[i].id + '">' + response.users[i].emp_name + '</option>';
                        }
                        for (var i = 0; i < response.users.length; i++)
                        {
                            options_finance += '<option value="' + response.users[i].id + '">' + response.users[i].emp_name + '</option>';
                        }
                        $("#ceo").html(options);
                        if (response.defaultt != null)
                        {
                            $("#ceo").find("option[value=" + response.defaultt.ceo + "]").prop("selected", "selected");
                        }
                        $("#cio").html(options);
                        if (response.defaultt != null)
                        {
                            $("#cio").find("option[value=" + response.defaultt.cio + "]").prop("selected", "selected");
                        }
                        $('#icm').multiselect('destroy');
                        $("#icm").html(options);
                        if (response.defaultt != null)
                        {
                            for (var i = 0; i < response.users.length; i++) {
                                if ($.inArray(response.users[i].id, response.defaultt.icm) != -1)
                                {
                                    $("#icm").find("option[value=" + response.users[i].id + "]").prop("selected", "selected");
                                }
                            }
                        }
                        $('#icm').multiselect();
                        $("#icm").multiselect("refresh");
                        $('#abi').multiselect('destroy');
                        $("#abi").html(options);

                        $('#donor').multiselect('destroy');
                        $("#donor").html(options);

                        if (response.defaultt != null) {
                            for (var i = 0; i < response.users.length; i++) {
                                if ($.inArray(response.users[i].id, response.defaultt.donor_team) != -1) {
                                    $("#donor").find("option[value=" + response.users[i].id + "]").prop("selected", "selected");
                                }
                            }
                        }
                        $('#donor').multiselect();
                        $("#donor").multiselect("refresh");
                        if (response.defaultt != null) {
                            for (var i = 0; i < response.users.length; i++) {
                                if ($.inArray(response.users[i].id, response.defaultt.abi) != -1) {

                                    $("#abi").find("option[value=" + response.users[i].id + "]").prop("selected", "selected");
                                }
                            }
                        }
                        $('#abi').multiselect();
                        $("#abi").multiselect("refresh");

                        $('#finance').multiselect('destroy');
                        $("#finance").html(options_finance);

                        if (response.defaultt != null) {
                            for (var i = 0; i < response.users.length; i++) {
                                if ($.inArray(response.users[i].id, response.defaultt.finance) != -1) {

                                    $("#finance").find("option[value=" + response.users[i].id + "]").prop("selected", "selected");
                                }
                            }
                        }
                        $('#finance').multiselect();
                        $("#finance").multiselect("refresh");

                        if (response.defaultt != null) {
                            for (var i = 0; i < response.users.length; i++) {
                                user_con = 'USR' + response.users[i].id;
                                if ($.inArray(user_con, response.defaultt.finance) != -1) {
                                    $("#finance").find("option[value=" + response.users[i].id + "]").prop("selected", "selected");
                                }
                            }
                        }

                        $('#donor').multiselect();
                        $("#donor").multiselect("refresh");

                        $("#pre_ic").val('');
                        if (response.defaultt != null) {
                            $("#pre_ic").val(response.defaultt.pre_ic);
                        }
                    }
                }
            });
        }
    });

</script>

<style type="text/css">
    .vitals_mainContent .tabpanel-details label {
        color: #212529;
        font-size: 13px !important;
    }


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
        height: 250px !important;
    }

</style>

</body>
</html>