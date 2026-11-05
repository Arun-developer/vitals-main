<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Partners')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'admin', 'page' => 'partner')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/master/partners_list'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4>Add Partner</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="inputplan-structureall plan-structure-new">
                        <form id="partner_form" method="post" action="<?php echo base_url() . 'index.php/master/submit_partner'; ?>" autocomplete="off" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Partner Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="partner_name" maxlength="50" placeholder="Partner name" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Country <span class="text-danger">*</span></label>
                                        <select class="form-control" name="partner_country">
                                            <option value="">-- Select --</option>
                                            <?php foreach ($country as $c_name) { ?>
                                                <option value="<?= $c_name['id']; ?>"><?= $c_name['country_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Currency <span class="text-danger">*</span></label>
                                        <select class="form-control" name="partner_currency">
                                            <option value="">-- Select --</option>
                                            <option value="INR">Indian Rupee</option>
                                            <option value="USD">US Dollar</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="partner_email" placeholder="Partner email" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Phone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="partner_mobile" maxlength="15" placeholder="Phone number" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Address <span class="text-danger">*</span></label>
                                        <textarea rows="3" class="form-control" name="partner_address" maxlength="200" placeholder="Address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-4 col-md-4">
                                    <div>
                                        <div id="user_img">
                                            <div class="form-group display-flex align-bottom">
                                                <div class="profilePicMaster" style="height: auto;">
                                                    <img src="<?php echo base_url() . 'uploads/partner_logo/default_logo.jpg'; ?>" id="new_img" class="img-fluid">
                                                </div>
                                                <div class="masterPicUpdate">
                                                    <label>Partner Logo</label>
                                                    <input type="button" class="form-control masterPicUpdatebtn" value="Upload Logo" />
                                                    <input type="file" name="profile_pic" id="my_file" style="display: none;" />
                                                </div>
                                            </div>
                                            <label class="error display-hide" id="dp_error"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>SMTP Protocol</label>
                                        <input type="text" class="form-control" name="smtp_protocol" placeholder="SMTP protocol" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>SMTP Host</label>
                                        <input type="text" class="form-control" name="smtp_host" placeholder="SMTP host" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>SMTP Port</label>
                                        <input type="text" class="form-control" name="smtp_port" placeholder="SMTP port" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>SMTP Email</label>
                                        <input type="username" class="form-control" name="smtp_username" placeholder="SMTP email" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>SMTP Password</label>
                                        <input type="password" class="form-control" name="smtp_password" placeholder="SMTP password" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>SMTP Subject</label>
                                        <input type="subject" class="form-control" name="smtp_subject" placeholder="SMTP subject" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>AIS Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="partner_ais">
                                            <option value="">-- Select --</option>
                                            <option value="1">Enable</option>
                                            <option value="2">Disable</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-12 col-sm-4  col-md-4 ">
                                    <div class="text-left">
                                        <ul class="vitals-links">
                                            <li><input type="submit" value="Add" class="wdt_100 vital_yellow_btn"></li>
                                            <li><a href="<?php echo base_url() . 'index.php/master/partners_list'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
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

<script type="text/javascript">

    $(document).on('click', '.masterPicUpdatebtn', function () {
        $("input[id='my_file']").click();
    });

    $(document).ready(function () {
        $("#my_file").on('change', function () {
            var countFiles = $(this)[0].files.length;
            var imgPath = $(this)[0].value;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            var imgSize = $(this)[0].files[0].size;
            if (imgSize <= '1048576') {
                if (extn == "png" || extn == "jpg" || extn == "jpeg") {
                    if (typeof (FileReader) != "undefined") {
                        for (var i = 0; i < countFiles; i++) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $('#new_img').attr('src', e.target.result);
                            }
                            reader.readAsDataURL($(this)[0].files[i]);
                        }
                        $('#dp_error').addClass("display-hide");
                        $('#dp_error').html("");
                    } else {
                        $('#dp_error').removeClass("display-hide");
                        $('#dp_error').html("File does not support");
                    }
                } else {
                    $('#dp_error').removeClass("display-hide");
                    $('#dp_error').html("Invalid File. Supports png, jpg, jpeg files only");
                }
            } else {
                $('#dp_error').removeClass("display-hide");
                $('#dp_error').html("File exceeds 1 MB");
            }
        });
    });

    $('#partner_form').validate({
        rules: {
            partner_name: "required",
            partner_email: {
                required: true,
                email: true
            },
            partner_country: "required",
            partner_mobile: "required",
            partner_ais: "required",
            partner_address: "required",
            partner_currency: "required",
            smtp_username: {
                email: true
            }
        },
        messages: {
            partner_name: "Enter partner name",
            partner_email: {
                required: "Enter email",
                email: "Enter a valid email"
            },
            partner_country: "Select country",
            partner_currency: "Select currency",
            partner_ais: "Select AIS status",
            partner_address: "Enter address",
            partner_mobile: "Enter phone number",
            smtp_username: {
                email: "Enter a valid email"
            }
        }
    });

</script>

</body>
</html>