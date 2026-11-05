<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Add Job Location')); ?>
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
                        <h4>Add Job Location</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="inputplan-structureall plan-structure-new">
                        <form id="job_location_form" method="post" action="<?php echo base_url() . 'index.php/job/add_joblocation'; ?>" autocomplete="off">
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="job_location" maxlength="50" placeholder="Job location" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>State / Province </label>
                                        <input type="text" class="form-control" name="loc_state" maxlength="30" placeholder="State name" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Mobile </label>
                                        <input type="text" class="form-control" name="loc_mobile" maxlength="15" placeholder="Mobile" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Country <span class="text-danger">*</span></label>
                                        <select class="form-control employeeInput" name="loc_country">
                                            <option value="">-- Select --</option>
                                            <?php foreach ($country as $c_name) { ?>
                                                <option value="<?= $c_name['id']; ?>"><?= $c_name['country_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>City </label>
                                        <input type="text" class="form-control" name="loc_city" maxlength="30" placeholder="City name" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Fax </label>
                                        <input type="text" class="form-control" name="loc_fax" maxlength="15" placeholder="Fax number" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Address <span class="text-danger">*</span></label>
                                        <textarea rows="3" class="form-control" name="loc_address" maxlength="200" placeholder="Address"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>ZIP Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="loc_zipcode" maxlength="10" placeholder="Zipcode" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea rows="3" class="form-control" name="loc_comments" maxlength="200" placeholder="Comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-4  col-md-4 ">
                                    <div class="text-left">
                                        <ul class="vitals-links">
                                            <li><input type="submit" value="Add" class="vital_yellow_btn wdt_100"></li>
                                            <li><a href="<?php echo base_url() . 'index.php/job/location'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
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

    $('#job_location_form').validate({
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

    $(document).on('input', '.alphaonly', function () {
        if (this.value.match(/[^a-zA-Z,'&\- ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z,'&\- ]/g, '');
        }
    });

</script>

</body>
</html>