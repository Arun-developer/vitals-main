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
                <div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
                    <div class="row">
                        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
                            <div id="leftMenuLoad">
                                <?php $this->load->view('master_sidemenu.php', array('page' => 'holiday')); ?>
                            </div>
                            <div class="footer-link">
                                <p>copyright &copy; mis.villgroapps.org</p>
                            </div>
                        </div>
                        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                            <main class="page-content">
                                <div class="row dataconfig d_v_d_c">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                        <span><a href="<?php echo base_url() . 'index.php/leave/current_holiday_calendar'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                        <h4>Holiday Details</h4>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                        <ul class="vitals-links">
                                         <!--  <li><a href="" class="edt_btnVital"><i class="fas fa-eye"></i> View Calendar</a></li> -->
                                            <?php if (isset($holiday_detail[0]['id'])) { ?>
                                                <li <?php if (!isset($holiday_detail[0]['id'])) { ?>class="activeTabs" <?php } ?>><a href="<?php echo base_url() . 'index.php/leave/add_holiday'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a></li>

                                                <li class=""><a href="javascript:void(0)" class="edt_btnVital leave_edit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                                                <?php if ($this->session->userdata['user_type'] == 'superadmin') { ?>
                                                     <!--  <li><a href="javascript:void(0)" class="master_deluser clr_red"><i class="fas fa-trash-alt"></i> Delete</a></li> -->
                                                <?php }
                                            } ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="plan-structure-vital vital_windowScroll">
                                    <!-- <div>
                                        <div class="tab-slider--navform">
                                            <ul class="tab-slider--tabsform">
                                                <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/leave/current_holiday_calendar'; ?>">Holiday Calendar-Current</a></li>
                                                <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/leave/archive_holiday_calendar'; ?>">Holiday Calendar-Archive</a></li>
                                            </ul>
                                        </div>
                                    </div> -->
                                    <div class="tab-slider--container">
                                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                            <main class="page-content">
                                                <div class="inputplan-structureall plan-structure-new ">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <?php
                                                            if (isset($holiday_detail[0]['id'])) {
                                                                $disable = 'readonly';
                                                                $pointer_evnt = "style='pointer-events: none'";
                                                                ?>
                                                                <h4 class="vitals_innerSub">View HoliDay</h4>
                                                            <?php
                                                            } else {
                                                                $disable = '';
                                                                $pointer_evnt = '';
                                                                ?>
                                                                <h4 class="vitals_innerSub">Add Holiday</h4>
<?php } ?>
                                                        </div>
                                                    </div>
                                                    <form method="post" id="holidayForm" action="<?php echo base_url() . 'index.php/leave/addHolidays'; ?>" autocomplete="off">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                                <div class="form-group">
                                                                    <label>Name of Holiday <span>*</span></label>
                                                                    <input type="text" required="" name="holiday_name" id="holiday_name" class="form-control" placeholder="Enter the Holiday Name" <?= $disable; ?> value="<?php echo isset($holiday_detail) ? $holiday_detail[0]['holiday_name'] : ''; ?>" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Date <span>*</span></label>
                                                                    <div class="position-relative">
                                                                        <input type="text" required="" name="holiday_date" id="holiday_date" <?= $pointer_evnt; ?> readonly="" class="form-control" placeholder="Select the Date" value="<?php echo isset($holiday_detail) && $holiday_detail[0]['date'] != '' ? date('d-m-Y', strtotime($holiday_detail[0]['date'])) : ''; ?>" />
                                                                        <span class="calendar-position"><i class="far fa-calendar-alt"></i></span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Repeats Annually </label>
                                                                    <select class="form-control" name="holiday_repeat" id="holiday_repeat" <?= $pointer_evnt; ?>  <?= $disable; ?> >
                                                                        <option value="1" <?php if (isset($holiday_detail) && php72_cmp($holiday_detail[0]['repeat_annually']) == 1) {
    echo 'selected';
} ?>>Yes</option>
                                                                        <option value="2" <?php if (isset($holiday_detail) && php72_cmp($holiday_detail[0]['repeat_annually']) == 2) {
    echo 'selected';
} ?> >No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Full Day/ Half Day </label>
                                                                    <select class="form-control" name="holiday_type" id="holiday_type" <?= $pointer_evnt; ?>  <?= $disable; ?> >
                                                                        <option value="1" <?php if (isset($holiday_detail) && php72_cmp($holiday_detail[0]['length']) == 1) {
    echo 'selected';
} ?>>Full Day</option>
                                                                        <option value="2" <?php if (isset($holiday_detail) && php72_cmp($holiday_detail[0]['length']) == 2) {
    echo 'selected';
} ?>>Half Day</option>
                                                                    </select>
                                                                </div>
                                                                <div>
                                                                    <ul class="vitals-links">
                                                                        <li><button type="submit" class="vital_yellow_btn wdt_100">Save</button></li>
                                                                        <li><a href="<?php echo base_url() . 'index.php/leave/current_holiday_calendar'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                                    </ul>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="edit_id" id="edit_id" value="<?php echo isset($holiday_detail[0]['id']) ? $holiday_detail[0]['id'] : ''; ?>" />
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



        <script>
            $('#holidayForm').validate({
                rules: {
                    holiday_name: "required",
                    holiday_date: "required"

                },
                messages: {
                    holiday_name: "Enter holiday name",
                    holiday_date: "Select holiday date"
                }
            });

            $(document).ready(function () {
                $('.vital_windowScroll').css({'height': (($(window).height()) - 190) + 'px'});
                $('.toast').toast('show');
                setTimeout(function () {
                    $('.success').addClass('display-hide');
                }, 3000);
            });
            $('#holiday_date').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'd-m-yy',
            });

            $('.leave_edit').click(function () {
                $(this).parent('li').addClass('activeTabs');
                $("#holiday_name").attr("readonly", false);
                $('#holiday_date').css('pointer-events', '');
                $('#holiday_repeat').attr("readonly", false);
                $('#holiday_repeat').css('pointer-events', '');
                $('#holiday_type').attr("readonly", false);
                $('#holiday_type').css('pointer-events', '');
            });

            function deleterecord() {
                var id = $('#edit_id').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/leave/deleteLeave",
                    data: {
                        id: id,
                        table: 'hr_holidays',
                    },
                    dataType: 'json',
                    success: function (msg) {
                        var url = "<?php echo base_url(); ?>index.php/leave/current_holiday_calendar";
                        window.location.href = url;
                    }
                });
            }
        </script>
    </body>

</html>