<?php $this->load->view('vitals_header.php', array('main_menu' => 'funder', 'page_title' => 'Add Funder')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'funder', 'page' => 'funder_grant')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/funder/display_summary_list'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4>Add Funder</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <form id="add_furnder_form" name="add_furnder_form" action="<?php echo base_url() . 'index.php/funder/insertEdit_funder' ?>" enctype="multipart/form-data" method="POST">
                                    <div class="inputplan-structureall plan-structure-new">
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                                                <h4 class="vitals_innerSub">Funder Details</h4>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Funder Name <span>*</span></label>
                                                    <input name="name" title="Enter name" id="name" class="form-control required" placeholder="Name" type="text">
                                                    <div id="name_error"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Type <span>*</span></label>
                                                    <select title="Select type" name="type" id="type" class="form-control required">
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($fundertypeList as $key => $value) { ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input name="address" title="Enter address" id="address" class="form-control" type="text" placeholder="Address">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>FCRA Status <span>*</span></label>
                                                    <select name="fcra_status" title="Select FCRA" id="fcra_status" class="form-control required">
                                                        <option value="">--Select--</option>
                                                        <option value="fcra">FCRA</option>
                                                        <option value="non_fcra">Non FCRA</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Grant/Service <span>*</span></label>
                                                    <select name="grant_service" title="Select service" id="grant_service" class="form-control required">
                                                        <option value="">--Select--</option>
                                                        <option value="grant">Grant</option>
                                                        <option value="service">Service Agreement</option>
                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row leaveLabel">
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>PAN</label>
                                                    <input name="pan" id="pan" class="form-control alphanum" type="text" placeholder="PAN">
                                                    <div id="pan_error"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>City/State</label>
                                                        <input name="city" id="city" class="form-control" type="text" placeholder="City">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select name="country" id="country" class="form-control">
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        if ($country_list) {
                                                            foreach ($country_list as $list) {
                                                                ?>
                                                                <option value="<?php echo $list->country_code; ?>"><?php echo $list->country_name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="height:30px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <h4>Contact Details</h4>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <ul class="milestone-links">
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15" id="add_contact"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" data-chk-attr='contact_checkbox' class="edit-btnconfig none-pointer opacity5 mar-tp15 delete_cls" data-toggle="modal" data-target="" id="delete_contact"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="hid_table_type">
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table" id="contact_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" class="removeArrow"><input class="form-control" id="contact_checkbox" type="checkbox"></th>
                                                        <th width="20%">Name</th>
                                                        <th width="20%">Designation</th>
                                                        <th width="20%">Phone</th>
                                                        <th width="25%">Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="metric_more" id="contact_tbl_0">
                                                        <td class="valign-center"><input class="form-control contact_checkbox" type="checkbox"></td>
                                                        <td><input class="form-control" title="Enter contact name" name="contact_name[][0]" type="text" placeholder="Enter name"></td>
                                                        <td><input class="form-control" title="Enter designation" name="designation[][0]" type="text" placeholder="Enter designation"></td>
                                                        <td><input class="form-control" title="Enter mobile number" data-attr='phone_err_0' maxlength="15" name="mobile_number[][0]" type="text" placeholder="Enter phone">
                                                            <div id="phone_err_0"></div>
                                                        </td>
                                                        <td><input class="form-control email email_spc" title="Enter valid email" data-attr='email_err_0' name="email[][0]" type="text" placeholder="Enter email">
                                                            <div id="email_err_0"></div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="height:30px"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                                        <h4>Upload Document</h4>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <ul class="milestone-links">
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15" id="add_document"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig none-pointer opacity5 mar-tp15 delete_cls" data-chk-attr='doc_checkbox' data-toggle="modal" data-target="" id="delete_document"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table" id="funder_document" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" class="removeArrow"><input class="form-control" id="document_checkbox" type="checkbox"></th>
                                                        <th width="20%">Document Description</th>
                                                        <th style="width:47%;">Upload Document <small>(Max 10MB size of xls, ppt, xlsx,doc,docx,pptx files)</small></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="metric_more" id="document_len_0">
                                                        <td class="valign-center"><input class="form-control doc_checkbox" type="checkbox"></td>
                                                        <td style="width: 35%;"><input title="Enter description" name='description[][0]' class="form-control" type="text" placeholder="Enter description"></td>
                                                        <td>
                                                            <input type="button" class="form-control masterPicUpdatebtn employeeInput" id="file_btn_0" data_attr_id='file_upload_0' value="Choose file to upload">
                                                            <input name=file_upload[][0] type="file" id="file_upload_0" data-btn-id="file_btn_0" style="display: none;" data-err='file_err_0' />
                                                            <div id="file_err_0"></div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="height:20px"></div>
                                        <div class="row">
                                            <div class="col-12 col-sm-4  col-md-4 text-right">
                                                <div class="text-left">
                                                    <ul class="vitals-links saveLinkView ">
                                                        <li><a class="vital_yellow_btn wdt_100" id="submit_form">Save</a></input></li>
                                                        <li><a href="<?php echo base_url() . 'index.php/funder/display_summary_list'; ?>" id="cancel_btn" class="vital_bordered_btn wdt_100">Cancel</a></li>
                                                    </ul>
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

<style type="text/css">
    .masterPicUpdatebtn{
        width: 80%;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('load_currency' => 'currency')); ?>

<script type="text/javascript">
    $(function () {
        $("#add_furnder_form").validate();
    });

    $(document).on('click', '.delete_cls', function () {
        var cur_attr = $(this).attr("data-chk-attr");

        $('#delCount').val('');
        var sel_item = $('input:checkbox.' + cur_attr + ':checked').length;
        $('#delCount').html(sel_item);
    });

    $(document).ready(function () {
        $(document).on('click', '.masterPicUpdatebtn', function () {
            $current = $(this).attr('data_attr_id');
            $("input[id=" + $current + "]").click();
        });

        error_count = 0;
        $(document).on('change', 'input[type="file"]', function () {
            var error_id = $(this).attr('data-err');
            var file_btn_id = $(this).attr('data-btn-id');
            var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
            var last_char = filename.slice(-40);

            var countFiles = $(this)[0].files.length;
            var imgPath = $(this)[0].value;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            var imgSize = $(this)[0].files[0].size;

            $('#' + error_id).html("");
            if (imgSize <= 10485760) {
                var file_typeArr = ["pdf", "xls", "ppt", "xlsx", "doc", "docx", "pptx"];
                if (file_typeArr.indexOf(extn) <= -1) {
                    error_count = 1;
                    $('#' + error_id).html("<label class='tbl_err'>Invalid File</label>");
                } else {
                    $('#' + file_btn_id).val(last_char);
                    error_count = 0;
                }
            } else {
                error_count = 1;
                $('#' + error_id).html("<label class='tbl_err'>File exceeds 10 MB</label>");
            }
        });

        $(document).on('change keyup paste', '#pan', function () {
            $("#pan_error").html('');
            var pan_val = this.value;
            if (pan_val != '' && pan_val != undefined) {
                var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/;
                if (!pan_val.match(regExp)) {
                    $("#pan_error").html('<label  class="tbl_err" >Enter valid pan number format</label>');
                }
            }
        });

        $("#add_furnder_form").validate();
        $('.vital_windowScroll').css({
            'height': (($(window).height()) - 190) + 'px'
        });
        check_err_count = 0;
    });

    $(document).ready(function () {
        $("#add_contact").click(function () {
            var contact_tbl_len = $('#contact_table tr').length - 1;
            var markup = "<tr class='metric_more' id=contact_tbl_" + contact_tbl_len + "><td class='valign-center'><input class='form-control contact_checkbox' type='checkbox'></td><td><input  name='contact_name[][" + contact_tbl_len + "]'  class='form-control' title='Enter contact name' type='text' placeholder='Enter name'></td><td><input class='form-control' name='designation[][" + contact_tbl_len + "]'  type='text' title='Enter designation' placeholder='Enter designation'></td><td><input maxlength='15' class='form-control' name='mobile_number[][" + contact_tbl_len + "]' type='text' data-attr=phone_err_" + contact_tbl_len + " title='Enter mobile number' placeholder='Enter phone'><div id=phone_err_" + contact_tbl_len + "></div></td><td><input class='form-control email email_spc' title=Enter valid email' data-attr=email_err_" + contact_tbl_len + " name='email[][" + contact_tbl_len + "]' type='text' placeholder='Enter email'><div id=email_err_" + contact_tbl_len + "></div></td></tr>";
            $("#contact_table tbody").prepend(markup);
            $('#contact_checkbox').prop('checked', false);
        });

        $(document).on('change', '.contact_checkbox,#contact_checkbox', function () {
            if ($('input:checkbox.contact_checkbox').length != $('input:checkbox.contact_checkbox:checked').length) {
                $('#contact_checkbox').prop('checked', false);
            } else {
                $('#contact_checkbox').prop('checked', true);
            }

            if ($('input:checkbox.contact_checkbox:checked').length > 0) {
                $("#delete_contact").removeClass("opacity5 none-pointer");
            } else {
                $("#delete_contact").addClass("opacity5 none-pointer");
            }
        });

        $(document).on('change', '.doc_checkbox,#document_checkbox', function () {
            if ($('input:checkbox.doc_checkbox').length != $('input:checkbox.doc_checkbox:checked').length) {
                $('#document_checkbox').prop('checked', false);
            } else {
                $('#document_checkbox').prop('checked', true);
            }

            if ($('input:checkbox.doc_checkbox:checked').length > 0) {
                $("#delete_document").removeClass("opacity5 none-pointer");

            } else {
                $("#delete_document").addClass("opacity5 none-pointer");
            }
        });

        $("#delete_contact").click(function () {
            if ($('input:checkbox.contact_checkbox:checked').length > 0) {
                $("#hid_table_type").val('hid_contact_table');
            }
            $('#deleteModal').modal('show');
        });

        $("#delete_document").click(function () {
            if ($('input:checkbox.doc_checkbox:checked').length > 0) {
                $("#hid_table_type").val('hid_document_table');
            }
            $('#deleteModal').modal('show');
        });

        $("#editSubmit").click(function () {
            var cur_val = $("#hid_table_type").val();
            if (cur_val == 'hid_contact_table') {
                $("#contact_table tbody").find('input[type="checkbox"]').each(function () {
                    if ($(this).is(":checked")) {
                        $(this).parents("tr").remove();
                    }
                });
                $('#deleteModal').modal('toggle');
            } else if (cur_val == 'hid_document_table') {
                $("#funder_document tbody").find('input[type="checkbox"]').each(function () {
                    if ($(this).is(":checked")) {
                        $(this).parents("tr").remove();
                    }
                });
                $('#deleteModal').modal('toggle');
            }
            $("#hid_table_type").val('');

            if ($('input:checkbox.doc_checkbox').length == 0) {
                $('#document_checkbox').prop('checked', false);
            }
            if ($('input:checkbox.contact_checkbox').length == 0) {
                $('#contact_checkbox').prop('checked', false);
            }

            if ($('input:checkbox.doc_checkbox:checked').length > 0) {
                $("#delete_document").removeClass("opacity5 none-pointer");
            } else {
                $("#delete_document").addClass("opacity5 none-pointer");
            }

            if ($('input:checkbox.contact_checkbox:checked').length > 0) {
                $("#delete_contact").removeClass("opacity5 none-pointer");
            } else {
                $("#delete_contact").addClass("opacity5 none-pointer");
            }

            var funder_id = '<?php echo $funder_id; ?>'
            $.ajax({
                url: '<?php echo base_url() . 'index.php/funder/ajax_common_delete' ?>',
                cache: false,
                type: "POST",
                data: {},
                dataType: "json",
                success: function (response) {
                    window.location.reload();
                }
            });

        });

        $("#add_document").click(function () {
            var funder_doc_len = $('#funder_document tr').length + 1;
            var markup = "<tr class='metric_more' id=document_len_" + funder_doc_len + "><td class='valign-center'><input class='form-control doc_checkbox' type='checkbox'></td><td><input class='form-control'  name=description[][" + funder_doc_len + "] type='text' title='Enter the description' placeholder='Enter description'></td><td><input type='button' class='form-control masterPicUpdatebtn employeeInput' id=file_btn_" + funder_doc_len + " data_attr_id='file_upload_" + funder_doc_len + "' value='Choose file to upload'><input type='file' data-btn-id=file_btn_" + funder_doc_len + " data-err=file_err_" + funder_doc_len + "  name=file_upload[][" + funder_doc_len + "] id='file_upload_" + funder_doc_len + "' title='Please upload the file' style='display:none'><div id=file_err_" + funder_doc_len + "></div></td><td></td></tr>";
            $("#funder_document tbody").prepend(markup);
            $('#document_checkbox').prop('checked', false);
        });

        $('#contact_checkbox').click(function (e) {
            var table = $(e.target).closest('table');
            $('td input:checkbox', table).prop('checked', this.checked);
        });

        $('#document_checkbox').click(function (e) {
            var table = $(e.target).closest('table');
            $('td input:checkbox', table).prop('checked', this.checked);
        });
    });

    $('.vital_yellow_btn').click(function () {
        if ($("#add_furnder_form").valid() == true) {
            $("#submit_form").addClass("none-pointer");
            $("#cancel_btn").addClass("none-pointer");
            ajax_funder_validate();
        }
    });

    function ajax_funder_validate(common_id, formType) {
        var name = $("#name").val();
        var pan = $("#pan").val();

        $.ajax({
            url: '<?php echo base_url() . 'index.php/funder/ajax_funder_validate' ?>',
            cache: false,
            type: "POST",
            data: {
                name: name
            },
            dataType: "json",
            success: function (response) {
                if (response.status > 0) {
                    for (const [key, value] of Object.entries(response.response)) {
                        $("#" + key).html('<label  class="error tbl_err" >' + value + '</label>');
                    }
                }
                if (response.status == 0 && error_count == 0) {
                    $("#add_furnder_form").submit();
                } else {
                    $("#submit_form").removeClass("none-pointer");
                    $("#cancel_btn").removeClass("none-pointer");
                }
            }
        });
    }
</script>
