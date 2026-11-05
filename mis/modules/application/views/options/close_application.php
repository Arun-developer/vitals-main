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
                                <li class="tab-slider--triggerform"><a  href="<?php echo base_url() . 'index.php/application/assign_incharge/' . $application_id; ?>">Assign Incharge</a></li>
                                <?php if ($get_app_status[0]['status'] == '3' && $get_app_status[0]['status'] != '8') { ?>
                                    <li class="tab-slider--triggerform active"><a  href="<?php echo base_url() . 'index.php/application/reopen/' . $application_id; ?>">Reopen</a></li>
                                <?php } else if ($get_app_status[0]['status'] != '3' && $get_app_status[0]['status'] != '8') { ?>
                                    <li class="tab-slider--triggerform active"><a  href="<?php echo base_url() . 'index.php/application/close_application/' . $application_id; ?>">Close/Bank</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane userActiveSetupNew active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form method="post" name="update_closeBank" id="update_closeBank" action="<?php echo base_url() . 'index.php/application/updateCloseAction'; ?>" class="form" autocomplete="off">
                                        <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Status<span>*</span></label>
                                                    <select class="form-control employeeInput" name="status" id="status" class="required">
                                                        <option value="">--Select--</option>
                                                        <option <?php
                                                        if ($innovation['status'] == '3') {
                                                            echo 'selected';
                                                        }
                                                        ?> value="3">Close</option>
                                                        <option <?php
                                                        if ($innovation['status'] == '24') {
                                                            echo 'selected';
                                                        }
                                                        ?> value="24">Open-Banked</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Reason<span>*</span></label>
                                                    <select class="form-control employeeInput" name="reasons" id="reasons" class="required">
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        foreach ($reasonsList as $row):
                                                            ?>
                                                            <option value="<?= $row['id']; ?>" <?php
                                                            if ($innovation['reasons'] == $row['id']) {
                                                                echo 'selected';
                                                            }
                                                            ?> ><?= $row['master_name']; ?></option>
                                                            <?php
                                                        endforeach;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div>
                                                    <div class="form-group">
                                                        <label>Comments<span>*</span></label>
                                                        <textarea class="form-control employeeInput" name="comments" maxlength="200" rows="5" placeholder="Enter comments"></textarea>
                                                    </div>
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
        $('.employeeInput').attr('readonly', true);
        $('select, textarea').css("cursor", "not-allowed");
        $('select, textarea').css('pointer-events', 'none');
    });

    $(document).on('click', '.summaryEdit', function () {
        $(".employeeInput").attr("readonly", false);
        $('select, textarea').css("cursor", "pointer");
        $('select, textarea').css('pointer-events', '');
        $("#submit_btn_cls").css("display", "block");
        $(".edit").addClass("activeTabs");
    });

    $('#update_closeBank').validate({
        rules: {
            "status": "required",
            "reasons": "required",
            "comments": "required",
        },
        messages: {
            "status": "Select status",
            "reasons": "Select reasons",
            "comments": "Enter comments"
        }
    });

</script>

</body>
</html>