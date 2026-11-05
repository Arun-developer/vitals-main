<?php ?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>Villgro MIS</title>
    </head>

    <body>
        <?php
        $this->load->view('header.php', array('page' => 'master'));
        ?>
        <div class="vi-dashboard-vital onboardtabmenu wdt-100">
            <div class="container-fluid">
                <?php
                $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
                $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';
                if ($successMsg != '') {
                    ?>
                    <div class="position-absolute d-flex flex-column p-4 toastPlace">
                        <div id="toast-container" aria-live="polite" aria-atomic="true">
                            <div id="toast-wrapper">
                                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                    <div class="toast-header bg-success text-white">
                                        <strong class="mr-auto"><?= $successMsg; ?></strong>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                            <span aria-hidden="true" class="text-white">×</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                if ($errorMsg != '') {
                    ?>
                    <div class="position-absolute d-flex flex-column p-4 toastPlace">
                        <div id="toast-container" aria-live="polite" aria-atomic="true">
                            <div id="toast-wrapper">
                                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                    <div class="toast-header bg-danger text-white">
                                        <strong class="mr-auto"><?= $errorMsg; ?></strong>
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                            <span aria-hidden="true" class="text-white">×</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="dataconfig-content page-wrapper vitals_mainContent ">
                    <div class="row">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('master_sidemenu.php', array('page' => 'working_days')); ?>
                            </div>
                            <div class="footer-link">
                                <p>copyright &copy; mis.villgroapps.org</p>
                            </div>
                        </div>
                        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                            <main class="page-content">
                                <div class="row dataconfig d_v_d_c">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">

                                        <span><a href="<?php echo base_url() . 'index.php/leave/working_days'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                        <h4>Working Days</h4>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                        <ul class="vitals-links">
                                            <?php if (isset($working_days[0]['id'])) { ?>
                                                <li ><a href="<?php echo base_url() . 'index.php/leave/add_working_days'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a></li>

                                                <li class="activeTabs"><a href="javascript:void(0)" class="edt_btnVital leave_edit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                                <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                                    <!-- <li>
                                                        <a href="javascript:void(0)" class="master_deluser clr_red" onclick="deleterecord()"><i class="fas fa-trash-alt"></i> Delete</a>
                                                    </li> -->
                                                <?php }
                                            } ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="plan-structure-vital vital_windowScroll">
                                    <main class="page-content">
                                        <div class="inputplan-structureall plan-structure-new ">
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php
                                                    if (isset($working_days[0]['id'])) {
                                                        $disable = 'readonly';
                                                        $pointer_evnt = "style='pointer-events: none'";
                                                        ?>
                                                        <h4 class="vitals_innerSub">View Working Days</h4>
                                                    <?php
                                                    } else {
                                                        $disable = '';
                                                        $pointer_evnt = '';
                                                        ?>
                                                        <h4 class="vitals_innerSub">Add Working Days</h4>
<?php } ?>
                                                </div>
                                            </div>
                                            <form method="post" id="workingdaysForm" action="<?php echo base_url() . 'index.php/leave/addWorkingdays'; ?>" autocomplete="off">
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                        <div class="form-group">
                                                            <label>Name of Working Days <span>*</span></label>
                                                            <input type="text" required="" name="working_days_name" id="working_days_name" class="form-control" <?= $disable; ?> value="<?php echo isset($working_days[0]['workingday_name']) ? $working_days[0]['workingday_name'] : ''; ?>" placeholder="Enter the Working Days" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Date <span>*</span></label>
                                                            <input type="text" required="" name="working_date" id="working_date" class="form-control" <?= $pointer_evnt; ?> readonly=""  value="<?php echo isset($working_days[0]['date']) ? date('d-M-Y', strtotime($working_days[0]['date'])) : ''; ?>" placeholder="Select the Date" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Full Day/ Half Day </label>
                                                            <select class="form-control" name="working_day_type" <?= $pointer_evnt; ?>  <?= $disable; ?> id="working_day_type" required="">
                                                                <option value="1" <?php if (isset($working_days[0]['length']) && $working_days[0]['length'] == 1) {
    echo 'selected';
} ?>>Full Day</option>
                                                                <option value="2" <?php if (isset($working_days[0]['length']) && $working_days[0]['length'] == 2) {
    echo 'selected';
} ?>>Half Day</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <ul class="vitals-links">
                                                                <li><button type="submit" class="wdt_100 vital_yellow_btn">Save</button></li>
                                                                <li><a href="<?php echo base_url() . 'index.php/leave/working_days'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="edit_id" id="edit_id" value="<?php echo isset($working_days[0]['id']) ? $working_days[0]['id'] : ''; ?>" />
                                            </form>
                                        </div>
                                    </main>
                                </div>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            $('#workingdaysForm').validate({
                rules: {
                    working_days_name: "required",
                    working_date: "required"

                },
                messages: {
                    working_days_name: "Enter working day name",
                    working_date: "Select working day date"
                }
            });
            $(document).ready(function () {
                $('.vital_windowScroll').css({'height': (($(window).height()) - 190) + 'px'});
                $('.toast').toast('show');
                setTimeout(function () {
                    $('.success').addClass('display-hide');
                }, 3000);
            });
            $('#working_date').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'd-m-yy',
            });



            $('.leave_edit').click(function () {
                $(this).parent('li').addClass('activeTabs');
                $("#working_days_name").attr("readonly", false);
                $('#working_date').css('pointer-events', '');
                $('#working_day_type').attr("readonly", false);
                $('#working_day_type').css('pointer-events', '');
            });

            function deleterecord() {
                var id = $('#edit_id').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/leave/deleteLeave",
                    data: {
                        id: id,
                        table: 'hr_working_days',
                    },
                    dataType: 'json',
                    success: function (msg) {
                        var url = "<?php echo base_url(); ?>index.php/leave/working_days";
                        window.location.href = url;
                    }
                });
            }
        </script>
    </body>
</html>