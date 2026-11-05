<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => 'Add External Mail - ' . $innovation['name_of_enterprise'])); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'mail_history', 'inv_stage' => $innovation['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <!-- <span><a href="<?php echo base_url() . 'index.php/portfolio/alldeals'; ?>"><i class="fas fa-angle-left"></i> Back</a></span> -->
                        <h4><?= $innovation['name_of_enterprise']; ?></h4>
                    </div>
                </div>
                <div class="tab-slider--navform">
                    <ul class="tab-slider--tabsform">
                        <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/application/mail_history/' . $application_id; ?>">All Mails</a></li>
                        <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/application/external_mail/' . $application_id; ?>">Add External Mail</a></li>
                        <li class="tab-slider--triggerform "><a href="<?php echo base_url() . 'index.php/application/send_mail/' . $application_id; ?>">Send Mail</a></li>
                    </ul>
                </div>

                <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                    <main class="page-content">
                        <div class="inputplan-structureall plan-structure-new">
                            <form id="externalMailForm" method="post" action="<?php echo base_url() . 'index.php/application/add_external_mail'; ?>" autocomplete="off" enctype="multipart/form-data">
                                <input type="hidden" name="innovation" value="<?= $application_id; ?>">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>To<span>*</span></label>
                                            <input class="form-control" type="text" name="messageTo" id="messageTo" placeholder="Enter email id">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Message Subject<span>*</span></label>
                                            <input class="form-control" type="text" name="messageSubject" id="messageSubject" placeholder="Enter subject">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Upload Document&nbsp;<small>(Max 10MB size of ppt, pdf, doc files)</small></label>
                                            <div class="form-group">
                                                <div class="fileUpload blue-btn btn fullWidth100">
                                                    <span><i class="fas fa-upload"></i> Upload</span>
                                                    <input type="file" class="uploadlogo" name="document_file" />
                                                </div>
                                                <label for="document_file" class="error wdt-100m" style="width: 85% !important"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-7 col-lg-7 col-xl-7">
                                        <div class="form-group">
                                            <label>Message Body<span>*</span></label>
                                            <textarea id="editor" id="messageBody" class="form-control edit_cls" name="messageBody">
                                                <?php if (isset($mail_details[0]->messagebody) && $mail_details[0]->messagebody != '') echo $mail_details[0]->messagebody; ?> </textarea>
                                                <div id="messagebody_err" ></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-12 col-sm-4  col-md-4 ">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView">
                                                    <?php // if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || in_array($this->session->userdata('emp_number'), $assign_incharge_id)) { ?>
                                                        <li><input type="submit" id="submit_btn" value="Send" class="vital_yellow_btn wdt_100"></li>
                                                        <li><input type="reset" value="Reset" name="txtReset" class="vital_bordered_btn wdt_100" onclick="setTimeout(function () {
                                                            window.location = '<?= base_url(); ?>index.php/application/external_mail/<?= $application_id; ?>'
                                                        }, 500)"></li>
                                                    <?php // } ?>
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

<?php $this->load->view('vitals_footer.php', array('text_editor' => 'textEditor')); ?>

<script type="text/javascript">
    var BASE_URL = '<?php echo base_url(); ?>';
    tinyMCE.init({
        mode: "exact",
        elements: "editor",
        theme: "advanced",
        skin: "o2k7",
        skin_variant: "silver",
        plugins: "lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
        theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,
        file_browser_callback: "airfilemanager",
        document_base_url: BASE_URL,
        relative_urls: true,
        remove_scripts_host: false
    });

    function airfilemanager(field_name, url, type, win) {
        switch (type) {
            case "media":
            case "image":
            case "flash":
            case "file":
            break;
            default:
            return !1;
        }
        tinyMCE.activeEditor.windowManager.open({
            url: BASE_URL + "source/airfilemanager/afm.php" + "?type=" + type,
            width: 780,
            height: 500,
            inline: "yes",
            close_previous: "no"
        }, {window: win, input: field_name});
    }

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
            $('#externalMailForm').valid();
            return filename;
        } else {
            filename = '<span><i class="fas fa-upload"></i> Upload</span>';
            $('#externalMailForm').valid();
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

    $('#externalMailForm').validate({
        rules: {
            messageTo: {
                required: true,
                email: true
            },
            messageSubject: "required",
            messageBody: "required",
            document_file: {
                extension: "pdf|ppt|pptx|doc|docx",
                maxfilesize: true
            }
        },
        messages: {
            messageTo: {
                required: "Enter email id",
                email: "Enter a valid email"
            },
            messageSubject: "Enter message subject",
            messageBody: "Enter message body",
            document_file: {
                extension: 'Only ppt,pdf,doc files are accepted'
            }
        }
    });

    $(document).on('click', '#submit_btn', function (e) {
        var messagebody = tinyMCE.activeEditor.getContent();
        $("#messagebody_err").html('');
        if (!$("#externalMailForm").valid() || messagebody == '') {
            $("#messagebody_err").html('<label for="messagebody_err" class="error" style="display: block;">Enter message body</label>');
            e.preventDefault();
        } else {
            $('#externalMailForm').submit();
        }
    });

</script>

</body>
</html>