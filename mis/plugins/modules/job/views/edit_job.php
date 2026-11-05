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
                        <span><a href="<?php echo base_url() . 'index.php/job/lists'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?= $job[0]['job_title']; ?></h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 text-right">
                        <ul class="vitals-links">
                            <li><a href="<?php echo base_url() . 'index.php/job/add_job'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add Job</a></li>
                            <li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="inputplan-structureall plan-structure-new">
                        <form id="job_form" method="post" action="<?php echo base_url() . 'index.php/job/edit_jobtitle'; ?>" autocomplete="off">
                            <input type="hidden" name="job_id" value="<?= $job[0]['id']; ?>">
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Job Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control jobInput" name="job_title" placeholder="Job title" disabled maxlength="50" value="<?= $job[0]['job_title']; ?>" />
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Job Specification </label>
                                        <select class="form-control jobInput" name="specific_id" disabled>
                                            <option value="">--Select--</option>
                                            <?php foreach ($specification as $specific) { ?>
                                                <option value="<?= $specific['id']; ?>" <?php
                                                if ($specific['id'] == $job[0]['specification_id']) {
                                                    echo "selected";
                                                }
                                                ?>><?= $specific['specification_name']; ?></option>
                                                    <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Pay Grade <span class="text-danger">*</span></label>
                                        <select class="form-control jobInput selectJob" name="pay_grade" disabled>
                                            <option value="">--Select--</option>
                                            <?php foreach ($grade as $name) { ?>
                                                <option value="<?= $name['id']; ?>" <?php
                                                if ($name['id'] == $job[0]['pay_grade']) {
                                                    echo "selected";
                                                }
                                                ?>><?= $name['grade_name']; ?></option>
                                                    <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Job Description <span class="text-danger">*</span></label>
                                        <textarea rows="3" class="form-control jobInput" name="job_desc" maxlength="200" disabled placeholder="Job description"><?= $job[0]['job_description']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Job Comments</label>
                                        <textarea rows="3" class="form-control jobInput" disabled name="job_comments" maxlength="200" placeholder="Job comments"><?= $job[0]['job_comment']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4"></div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-4  col-md-4 ">
                                    <div class="text-left">
                                        <ul class="vitals-links saveLinkView display-hide">
                                            <li><input type="submit" value="Save" class="wdt_100 vital_yellow_btn"></li>
                                            <li><a href="<?php echo base_url() . 'index.php/job/edit_job/' . $job[0]['id']; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
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

    $('#job_form').validate({
        rules: {
            job_title: "required",
            job_desc: "required",
            pay_grade: "required"

        },
        messages: {
            job_title: "Enter job title",
            job_desc: "Enter description",
            pay_grade: "Select grade"
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