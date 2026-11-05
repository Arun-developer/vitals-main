<?php
$form_type = $this->uri->segment(3);
$this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - ' . ucfirst($form_type) . ' Visitors Log'));
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'visitors_log')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/master/visitors_log'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?= ucfirst($form_type); ?> Visitors Log</h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <?php if (isset($editid) && $editid != '') { ?>
                                <li <?php if (!isset($editid)) { ?>class="activeTabs" <?php } ?>><a href="<?php echo base_url() . 'index.php/master/visitors_log/add'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a></li>
                                <li class="edit"><a href="javascript:void(0)" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="inputplan-structureall plan-structure-new ">
                        <form id="visitors_form" method="post" action="<?php echo base_url() . 'index.php/master/addVisitorslog'; ?>" autocomplete="off">
                            <?php
                            if (isset($editid) && $editid != '') {
                                $disabled = 'disabled';
                                $dis_hide = 'display-hide';
                            } else {
                                $disabled = '';
                                $dis_hide = '';
                            }
                            ?>
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Date <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput logdate" <?= $disabled; ?> name="log_date" id="log_date" value="<?php echo isset($editid) && $editid != '' ? date('d-m-Y', strtotime($visitorsList[0]['date'])) : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Name Of Visitor <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="name_of_visitor" id="name_of_visitor" value="<?php echo isset($editid) && $editid != '' ? $visitorsList[0]['name_of_visitor'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Name Of Organization</label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="name_of_organization" id="name_of_organization" value="<?php echo isset($editid) && $editid != '' ? $visitorsList[0]['name_of_organization'] : ''; ?>" >
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Intending to Meet <span class="text-danger">*</span></label>
                                        <select name="intending_to_meet" id="intending_to_meet" class="form-control additionalInput" <?= $disabled; ?>>
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach ($userList as $list) {
                                                if (isset($editid) && $editid != '') {
                                                    if ($visitorsList[0]['intending_to_meet'] == $list['id']) {
                                                        $selected = 'selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                } else {
                                                    $selected = '';
                                                }
                                                ?>
                                                <option value="<?= $list['id'] ?>" <?= $selected; ?>><?= $list['user_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Purpose</label>
                                        <textarea type="text" class="form-control additionalInput" <?= $disabled; ?> name="purpose" id="purpose" ><?php echo isset($editid) && $editid != '' ? $visitorsList[0]['purpose'] : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Time In</label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="time_in" id="time_in" value="<?php echo isset($editid) && $editid != '' ? $visitorsList[0]['time_in'] : ''; ?>" >
                                    </div>
                                    <div id="time_in_err"></div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Time Out</label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="time_out" id="time_out" value="<?php echo isset($editid) && $editid != '' ? $visitorsList[0]['time_out'] : ''; ?>" >
                                    </div>
                                    <div id="time_out_err"></div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Innovation</label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="innovation" id="innovation" value="<?php echo isset($editid) && $editid != '' ? $visitorsList[0]['innovation'] : ''; ?>" >
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-4 col-xl-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-4  col-md-4 ">
                                    <div class="text-left">
                                        <ul class="vitals-links saveLinkView <?= $dis_hide; ?>">
                                            <li><input type="submit" id="submit" value="Add" class="wdt_100 vital_yellow_btn"></li>
                                            <li><a href="<?php echo base_url() . 'index.php/master/books_master'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="edit_id" id="edit_id" value="<?php echo isset($editid) ? $editid : '' ?>" />
                            <input type="hidden" name="type" id="type" value="<?php echo isset($type) ? $type : '' ?>" />
                        </form>
                    </div>

                </div>
            </main>
        </div>
    </div>
</div>
</div>
</div>

<?php $this->load->view('vitals_footer.php'); ?>

<!-- 
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script> -->
<script src="<?php echo base_url() . 'source/timepicker/jquery.ui.timepicker.js?v=0.1.0'; ?>"></script>


<script>

    $(document).ready(function () {

        setDatepicker();
        $('#time_in').timepicker({
            showPeriod: true,
            showLeadingZero: true,
        });
        $('#time_out').timepicker({
            showPeriod: true,
            showLeadingZero: true,
            checkTime: function () {
                alert('');
            },
        });


    });
    $('#visitors_form').validate({
        rules: {
            log_date: "required",
            name_of_visitor: "required",
            intending_to_meet: "required"

        },
        messages: {
            log_date: "Select log date",
            name_of_visitor: "Enter visitor name",
            intending_to_meet: "Select user"
        }
    });
	

    date_err = err_type = 0;
    $('#time_in').on('change', function () {  
        date_err = err_type = 0;
        var current_time = $(this).val();
        var current_time_out = $("#time_out").val();
        var currentdate = new Date();
        var current_date = currentdate.getDate();
        
        var months = [ "January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December" ];
        var current_month = currentdate.getMonth();
        var current_month = months[current_month];
        var current_year = currentdate.getFullYear();

        var date1 = Date.parse("'" + current_date + "'" + "'" + current_month + "'" + "'" + current_year + "'" + ' ' + current_time);
        var date2 = Date.parse("'" + current_date + "'" + "'" + current_month + "'" + "'" + current_year + "'" + ' ' + current_time_out);

        $("#time_in_err").html('');
        $("#time_out_err").html('');
        
        if (current_time != '' && current_time_out != '') {
            if (date1 > date2) {
                date_err = 1;
                err_type = 1;
                $("#time_in_err").html('<label for="log_date" class="error">Enter valid Time</label>');
            }
        }
    });

    $('#time_out').on('change', function () {
        date_err = err_type = 0;
        var current_time = $(this).val();
        var current_time_in = $("#time_in").val();
        var currentdate = new Date();
        var current_date = currentdate.getDate();

        var months = [ "January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December" ];
        var current_month = currentdate.getMonth();
        var current_month = months[current_month];

        var current_year = currentdate.getFullYear();
        var date1 = Date.parse("'" + current_date + "'" + "'" + current_month + "'" + "'" + current_year + "'" + ' ' + current_time);
        var date2 = Date.parse("'" + current_date + "'" + "'" + current_month + "'" + "'" + current_year + "'" + ' ' + current_time_in);
        $("#time_in_err").html('');
        $("#time_out_err").html('');
        if (current_time != '' && current_time_in != '') {
            if (date1 < date2) {
                date_err = 1;
                err_type = 2;
                $("#time_out_err").html('<label for="log_date" class="error">Enter valid Time</label>');
            }
        }
    });

    $('#submit').click(function (e) {
        $("#visitors_form").valid();
        if (err_type == 1) {
            $("#time_in_err").html('<label for="log_date" class="error">Enter valid Time</label>');
            return false;
        } else if (err_type == 2) {
            $("#time_out_err").html('<label for="log_date" class="error">Enter valid Time</label>');
            return false;
        }
        //e.preventDefault();
        if ($("#visitors_form").valid() == true && date_err == 0) {
            $("#visitors_form").submit();
            return true;
        }
    });


    function setDatepicker() {
       $('.logdate').datepicker({
            changeMonth: true,
            changeYear: true,
            // showButtonPanel: true,
            dateFormat: 'dd-mm-yy',
        });
    }

    $('.summaryEdit').click(function () {
        $(".additionalInput").attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    });

</script>

</body>
</html>