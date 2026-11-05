<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Edit Job Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'job')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/job/location'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?= $job_loc[0]['location_name']; ?></h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                        <ul class="vitals-links">
                            <li><a href="<?php echo base_url() . 'index.php/job/add_job_location'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add Job Location</a></li>
                            <li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="inputplan-structureall plan-structure-new">
                        <form id="edit_location_form" method="post" action="<?php echo base_url() . 'index.php/job/edit_joblocation'; ?>" autocomplete="off">
                            <input type="hidden" name="location_id" value="<?= $job_loc[0]['id']; ?>">
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control jobInput" disabled name="job_location" placeholder="Job location" maxlength="50" value="<?= $job_loc[0]['location_name']; ?>" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>State / Province </label>
                                        <input type="text" class="form-control jobInput" disabled name="loc_state" maxlength="30" placeholder="State name" value="<?= $job_loc[0]['state']; ?>" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Mobile </label>
                                        <input type="text" class="form-control jobInput" disabled name="loc_mobile" maxlength="15" placeholder="Mobile" value="<?= $job_loc[0]['phone']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Country <span class="text-danger">*</span></label>
                                        <select class="form-control jobInput" disabled name="loc_country">
                                            <option value="">-- Select --</option>
                                            <?php foreach ($country as $c_name) { ?>
                                                <option value="<?= $c_name['id']; ?>" <?php
                                                if ($c_name['id'] == $job_loc[0]['country']) {
                                                    echo "selected";
                                                }
                                                ?>><?= $c_name['country_name']; ?></option>
                                                    <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>City </label>
                                        <input type="text" class="form-control jobInput" disabled name="loc_city" maxlength="30" placeholder="City name" value="<?= $job_loc[0]['city']; ?>" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Fax </label>
                                        <input type="text" class="form-control jobInput" disabled name="loc_fax" maxlength="15" placeholder="Fax number" value="<?= $job_loc[0]['fax']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Address <span class="text-danger">*</span></label>
                                        <textarea rows="3" class="form-control jobInput" disabled name="loc_address" maxlength="200" placeholder="Address"><?= $job_loc[0]['address']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>ZIP Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control jobInput" disabled name="loc_zipcode" placeholder="Zipcode" maxlength="10" value="<?= $job_loc[0]['zipcode']; ?>" />
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea rows="3" class="form-control jobInput" disabled name="loc_comments" maxlength="200" placeholder="Comments"><?= $job_loc[0]['comments']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-4  col-md-4 ">
                                    <div class="text-left">
                                        <ul class="vitals-links saveLinkView display-hide">
                                            <li><input type="submit" value="Save" class="wdt_100 vital_yellow_btn"></li>
                                            <li><a href="<?php echo base_url() . 'index.php/job/edit_job_location/' . $job_loc[0]['id']; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
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

    $('#edit_location_form').validate({
        rules: {
            job_location: "required",
            loc_country: "required",
            loc_address: "required",
            loc_zipcode: "required"

        },
        messages: {
            job_location: "Enter job location",
            loc_country: "Select country",
            loc_address: "Enter address",
            loc_zipcode: "Enter zipcode"
        }
    });

    $('.summaryEdit').click(function () {
        $(".jobInput").attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    });

</script>

</body>
</html>