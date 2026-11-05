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
                                <?php $this->load->view('master_sidemenu.php', array('page' => 'work_type')); ?>
                            </div>
                            <div class="footer-link">
                                <p>copyright &copy; mis.villgroapps.org</p>
                            </div>
                        </div>
                        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                            <main class="page-content">
                                <div class="row dataconfig d_v_d_c">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                        <span><a href="<?php echo base_url() . 'index.php/leave/leave_type'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                        <h4>Leave Type</h4>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                        <ul class="vitals-links">
                                            <?php if (isset($leave_types[0]['id'])) { ?>
                                                <li class="">
                                                    <a href="<?php echo base_url() . 'index.php/leave/add_leave_type'; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add</a>
                                                </li>

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

                                    <div class="tab-slider--container">
                                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                            <main class="page-content">
                                                <div class="inputplan-structureall plan-structure-new">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <?php
                                                            if (isset($leave_types[0]['id'])) {
                                                                $disable = 'readonly';
                                                                ?>
                                                                <h4 class="vitals_innerSub">View Leave Type</h4>
                                                            <?php
                                                            } else {
                                                                $disable = '';
                                                                ?>
                                                                <h4 class="vitals_innerSub">Add Leave Type</h4>
<?php } ?>
                                                        </div>
                                                    </div>
                                                    <form method="post" id="leavetypeForm" action="<?php echo base_url() . 'index.php/leave/addLeavetype'; ?>" autocomplete="off">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                                <div class="form-group">
                                                                    <label>Leave Type Id <span>*</span></label>
                                                                    <input type="text" required="" name="leave_type_id" id="leave_type_id" class="form-control" placeholder="Enter the Leave Type Id" <?= $disable; ?> value="<?php echo isset($leave_types[0]['leave_type_id']) ? $leave_types[0]['leave_type_id'] : ''; ?>" />
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Leave Type Name <span>*</span></label>
                                                                    <input type="text" required="" name="leave_type_name" id="leave_type_name" class="form-control" <?= $disable ?> placeholder="Enter the Leave Type Name" value="<?php echo isset($leave_types[0]['leave_type_name']) ? $leave_types[0]['leave_type_name'] : ''; ?>" />
                                                                </div>

                                                                <div>
                                                                    <ul class="vitals-links">
                                                                        <li><button type="submit" class=" wdt_100 vital_yellow_btn">Save</button></li>
                                                                        <li><a href="<?php echo base_url() . 'index.php/leave/leave_type'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                                    </ul>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="edit_id" id="edit_id" value="<?php echo isset($leave_types[0]['id']) ? $leave_types[0]['id'] : ''; ?>" />
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
            $('#leavetypeForm').validate({
                rules: {
                    leave_type_id: "required",
                    leave_type_name: "required"

                },
                messages: {
                    leave_type_id: "Enter leave type id",
                    leave_type_name: "Enter type name"
                }
            });
            $(document).ready(function () {
                $('.vital_windowScroll').css({'height': (($(window).height()) - 190) + 'px'});
                setTimeout(function () {
                    $('.success').addClass('display-hide');
                }, 3000);

                $('.toast').toast('show');
            });

            $('.leave_edit').click(function () {
                $(this).parent('li').addClass('activeTabs');
                $("#leave_type_name").attr("readonly", false);
            });

            function deleterecord() {
                var id = $('#edit_id').val();
                if (confirm("Are you sure, you want to delete it?")) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/leave/deleteLeave",
                        data: {
                            id: id,
                            table: 'hr_leave_type',
                        },
                        dataType: 'json',
                        success: function (msg) {
                            var url = "<?php echo base_url(); ?>index.php/leave/leave_type";
                            window.location.href = url;
                        }
                    });
                }
            }
        </script>
    </body>

</html>