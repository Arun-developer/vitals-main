<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Mail Template')); ?>

<div class="display-hide deleteMsg">
    <div class="position-absolute d-flex flex-column p-4 toastPlace">
        <div id="toast-container" aria-live="polite" aria-atomic="true">
            <div id="toast-wrapper">
                <div class="toast deletetoast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                    <div class="toast-header bg-success text-white">
                        <strong class="mr-auto">Record(s) deleted successfully</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true" class="text-white">×</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'mail_template')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/incubation_master/incubation_master/mail_template'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4>Edit Mail Template</h4>
                    </div>
                    <div class="col-xl-8 col-lg-6 col-md-12 col-12 text-right">
                        <ul class="vitals-links">
                            <li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
                        </ul>
                    </div>
                </div>

                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container tab-content">
                        <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                            <main class="page-content">
                                <form method="post" name="EditMail_template" id="EditMail_template" action="<?php echo base_url() . 'index.php/incubation_master/EditMail_template'; ?>" class="form" novalidate autocomplete="off">
                                    <div class="inputplan-structureall plan-structure-new ">
                                        <input type="hidden" name="id" value="<?php echo $this->uri->segment(3); ?>">
                                        <input type="hidden" name="module" value="<?php echo $this->uri->segment(4); ?>">
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Message Type<span>*</span></label>
                                                    <input  id="messagetype" type="text" value="<?php if (isset($mail_details[0]->messagetype) && $mail_details[0]->messagetype != '') echo $mail_details[0]->messagetype; ?>" class="form-control" readonly disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Message Subject<span>*</span></label>
                                                    <input  id="messagesubject" type="text" value="<?php if (isset($mail_details[0]->messagesubject) && $mail_details[0]->messagesubject != '') echo $mail_details[0]->messagesubject; ?>" class="form-control edit_cls" name="messagesubject" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label>Status<span>*</span></label>
                                                    <select name="status" id="status"  disabled class="form-control edit_cls">
                                                        <option value="">--Select--</option>
                                                        <option <?php if ($mail_details[0]->status == 1) echo"selected"; ?> value="1" >Approved</option>
                                                        <option <?php if ($mail_details[0]->status == 0) echo"selected"; ?> value="0">Disapproved </option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Message Body<span>*</span></label>
                                                    <textarea id="editor"  id="messagebody" class="form-control edit_cls" name="messagebody" disabled>
                                                        <?php if (isset($mail_details[0]->messagebody) && $mail_details[0]->messagebody != '') echo $mail_details[0]->messagebody; ?> </textarea>
                                                    <div id="messagebody_err" ></div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="edit_status">
                                        <div id="submit_btn_cls" style="display:none;" >
                                            <ul class="vitals-links">
                                                <li><input type="submit" id="submit_btn" class="vital_yellow_btn wdt_100"></input></li>
                                                <li><a href="" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                            </ul>
                                        </div>

                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <ul class="milestone-links">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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

<?php $this->load->view('vitals_footer.php', array('multi_select' => 'multiselect')); ?>

<script type="text/javascript" src="<?= base_url() . 'source/tiny_mce/tiny_mce.js'; ?>"></script>
<script type="text/javascript">
    BASE_URL = '<?php echo base_url(); ?>'
    tinyMCE.init({
        // General options
        mode: "exact",
        elements: "editor",
        theme: "advanced",
        skin: "o2k7",
        skin_variant: "silver",
        plugins: "lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
        // Theme options
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


    $('#EditMail_template').validate({
        rules: {
            messagesubject: {
                required: true
            },
            messagebody: {
                required: true
            },
            status: {
                required: true
            }
        },
        messages: {
            messagesubject: "Enter message subject",
            messagebody: "Enter message body",
            status: "Select Status",
        }
    });

    $(".numberField").on("input", function (evt) {
        var self = $(this);
        self.val(self.val().replace(/[^0-9]/g, ''));
        self.val(inrFormat(self.val()));
        if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
            evt.preventDefault();
        }
    });

    $(document).on('click', '.summaryEdit', function () {
        $("#edit_status").val("1");
        $(".edit_cls").attr("disabled", false);
        $(".multiselect").attr("disabled", false);
        $("#submit_btn_cls").css("display", "block");
        $(".edit").addClass("activeTabs");
    });


    $(document).ready(function () {
        $('.scrollsideMenu').scrollTop($('.scrollsideMenu').scrollTop() + 170);
        $('.nav-tabs').scrollingTabs({
            enableSwiping: true
        }).on('ready.scrtabs', function () {
            $('.tab-content').show();
        });
        $('#navLoad').removeClass('display-hide');
        $('.vital_windowScroll').css({
            'height': (($(window).height()) - 190) + 'px'
        });
        $('.toast').toast('show');
        setTimeout(function () {
            $('.success').addClass('display-hide');
        }, 3000);
    });

    $(document).on('click', '#submit_btn', function (e) {
        var messagebody = tinyMCE.activeEditor.getContent();
        $("#messagebody_err").html('');
        if (!$("#EditMail_template").valid() || messagebody == '') {
            $("#messagebody_err").html('<label for="messagebody_err" class="error" style="display: block;margin-left: 263px;">Enter message body</label>');
            e.preventDefault();
        } else {
            $('#EditMail_template').submit();
        }
    });

    $(document).on('keyup', '.apptotal', function () {
        var q1 = $('#app_q1').val();
        var q2 = $('#app_q2').val();
        var q3 = $('#app_q3').val();
        var q4 = $('#app_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#app_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.pardtotal', function () {
        var q1 = $('#pard_q1').val();
        var q2 = $('#pard_q2').val();
        var q3 = $('#pard_q3').val();
        var q4 = $('#pard_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#pard_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.iictotal', function () {
        var q1 = $('#iic_q1').val();
        var q2 = $('#iic_q2').val();
        var q3 = $('#iic_q3').val();
        var q4 = $('#iic_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#iic_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.eictotal', function () {
        var q1 = $('#eic_q1').val();
        var q2 = $('#eic_q2').val();
        var q3 = $('#eic_q3').val();
        var q4 = $('#eic_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#eic_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.cmptotal', function () {
        var q1 = $('#tot_q1').val();
        var q2 = $('#tot_q2').val();
        var q3 = $('#tot_q3').val();
        var q4 = $('#tot_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#tot_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.newtotal', function () {
        var q1 = $('#new_q1').val();
        var q2 = $('#new_q2').val();
        var q3 = $('#new_q3').val();
        var q4 = $('#new_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#new_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.exttotal', function () {
        var q1 = $('#ext_q1').val();
        var q2 = $('#ext_q2').val();
        var q3 = $('#ext_q3').val();
        var q4 = $('#ext_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#ext_annual').val(inrFormat(value));
    });

    function inrFormat(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        var z = 0;
        var len = String(x1).length;
        var num = parseInt((len / 2) - 1);
        while (rgx.test(x1)) {
            if (z > 0) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            } else {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
                rgx = /(\d+)(\d{2})/;
            }
            z++;
            num--;
            if (num == 0) {
                break;
            }
        }
        return x1 + x2;
    }

    $(document).ready(function () {
        $('#multiselect, #accessibleTo').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });
    });

    function getSelectedValues() {
        var selectedVal = $("#multiselect, #accessibleTo").val();
        for (var i = 0; i < selectedVal.length; i++) {
            if (window.CP.shouldStopExecution(0))
                break;

            function innerFunc(i) {
                setTimeout(function () {
                    location.href = selectedVal[i];
                }, i * 2000);
            }
            innerFunc(i);
        }
        window.CP.exitedLoop(0);
    }
</script>

</body>
</html>