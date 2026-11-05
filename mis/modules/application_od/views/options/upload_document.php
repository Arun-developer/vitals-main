<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => 'Upload Documents - ' . $innovation['name_of_enterprise'])); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'view_document', 'inv_stage' => $innovation['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content ">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>"><i class="fas fa-angle-left"></i> Back</a></span>
                        <h4><?= $innovation['name_of_enterprise']; ?></h4>
                    </div>
                </div>
                <div class="tab-slider--navform">
                    <ul class="tab-slider--tabsform">
                        <li class="tab-slider--triggerform"><a href="<?php echo base_url() . 'index.php/application/view_documents/' . $application_id; ?>">All Documents</a></li>
                        <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/application/upload_document/' . $application_id; ?>">Upload Document</a></li>
                    </ul>
                </div>

                <div id="tab1" class="tab-slider--body pad-none tabpanel-details vital_windowScroll config-wrapper  dataconfig-content page-wrapper chiller-theme">
                    <main class="page-content">
                        <div class="inputplan-structureall plan-structure-new ">
                            <form id="documentForm" method="post" action="<?php echo base_url() . 'index.php/application/add_upload_document'; ?>" autocomplete="off" enctype="multipart/form-data">
                                <input type="hidden" name="innovation" value="<?= $application_id; ?>">
                                <input type="hidden" name="uploader_name" value="<?= $this->session->userdata('emp_name'); ?>"/>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Document Description<span>*</span></label>
                                            <textarea class="form-control" name="document_name"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label>Upload Document<span>*</span><small>&nbsp;(Max 10MB size of ppt, pdf, doc files)</small></label>
                                            <div class="fileUpload blue-btn btn fullWidth100">
                                                <span><i class="fas fa-upload"></i> Upload</span>
                                                <input type="file" class="uploadlogo" name="document_file" />
                                            </div>
                                        </div>
                                        <label for="document_file" class="error wdt-100m" ></label>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-12 col-sm-4  col-md-4 ">
                                        <div class="text-left">
                                            <ul class="vitals-links saveLinkView">
                                                <li><input type="submit" value="Upload" class="vital_yellow_btn wdt_100"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </main>
                </div>
        </div>
    </div>
</div>
</div>
</div>
<style>
    .inputplan-structureall{
        border-top:none;
    }
</style>
<?php $this->load->view('vitals_footer.php'); ?>

<script type="text/javascript">
    $(".uploadlogo").on('change', function () {
        var filename = readURL(this);
        $(this).parent().children('span').html(filename);
    });

    function readURL(input) {
        var url = input.value;
        var path, filename;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "pdf" || ext == "doc" || ext == "docx" || ext == "ppt" || ext == "pptx")) {
            path = $(input).val();
            filename = path.replace(/^.*\\/, "");
            $('#documentForm').valid();
            return filename;
        } else {
            filename = '<span><i class="fas fa-upload"></i> Upload</span>';
            $('#documentForm').valid();
            return filename;
        }
    }

    $.validator.addMethod("maxfilesize", function (value, element) {
        return this.optional(element) || (element.files && element.files[0] && element.files[0].size <= 10008250);
    }, $.format('The file size cannot exceed 10MB'));

    $.validator.addMethod("extension", function (value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    }, "Not a valid file format");

    $('#documentForm').validate({
        rules: {
            document_name: "required",
            document_file: {
                required: true,
                extension: "pdf|ppt|pptx|doc|docx",
                maxfilesize: true
            }
        },
        messages: {
            document_name: "Please enter the description",
            document_file: {
                required: 'Upload document',
                extension: 'Only ppt,pdf,doc files are accepted'
            }
        }
    });

</script>

</body>
</html>