<?php
 $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Employee - Document info')); 
$funder_id = $this->uri->segment(3);
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
         <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'change_password', 'page' => 'my_profile')); ?>
        </div>

        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                 <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><i class="fas fa-angle-left"></i> Back</a></span>
                         <h4><?= $user_name; ?></h4>
                        <?php $emp_id = $this->session->userdata('emp_number'); ?>
                        <!-- <h4>Add Funder</h4> -->
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                           <ul class="nav nav-tabs" role="tablist">
                                 <li role="presentation" ><a href="<?php echo base_url() . 'index.php/myprofile/personal/' . $emp_id; ?>">Personal</a></li>
                                   
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/reporting/' . $emp_id; ?>">Reporting</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/contact/' . $emp_id; ?>">Contacts</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/dependents/' . $emp_id; ?>">Dependents</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/immigration/' . $emp_id; ?>">Immigration</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/job/' . $emp_id; ?>">Job & Salary</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/bank/' . $emp_id; ?>">Bank</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/education/' . $emp_id; ?>">Education</a></li>
                                <li class="tab-slider--triggerform active"><a href="<?php echo base_url() . 'index.php/myprofile/edit_document/' . $emp_id; ?>">Documents</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
                                    <form id="edit_document_form" name="edit_document_form" action="<?php echo base_url() . 'index.php/myprofile/editFunder_Documents' ?>" enctype="multipart/form-data" method="POST">
                                        <input type="hidden" id="hid_table_type" >
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
                                                                    <a href="javascript:void(0)" class="edit-btnconfig none-pointer opacity5 mar-tp15 delete_cls" data-chk-attr='doc_checkbox' data-toggle="modal" data-target=""  id="delete_document"><i class="fas fa-trash-alt"></i>&nbsp;Delete</a>
                                                                </li>
                                                                <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue none-pointer opacity5 mar-tp15" id="save_document" >Save</a></li>
                                                            </ul>
                                                        </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table" id="funder_document" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" style="<?php
                                                        if ($this->auth == '0') {
                                                            echo"display:none;";
                                                        }
                                                        ?>" class="removeArrow"><input <?php
                                                            if ($this->auth == '0') {
                                                                echo"disabled";
                                                            }
                                                            ?> class="form-control common_checkbox"  data-attr='funder_document' id="document_checkbox"  type="checkbox"></th>
                                                        <th style="width:25%;">Document</small></th>
                                                        <th width="20%">Date Uploaded</th>
                                                        <th width="20%">Uploaded By</th>
                                                        <th width="30%">Document Description</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <input type="hidden" name="delete_doc_id" id="delete_doc_id" value="">
                                                <input type="hidden" name="funder_id" value="<?php echo $funder_id; ?>" >
                                                <?php
                                                $i = 0;
                                                if (!empty($funder_document)) {
                                                    foreach ($funder_document as $lists) {
                                                        ?>
                                                        <tr class="metric_more" id="document_len_<?php echo $i; ?>">
                                                        <input disabled type="hidden" name="document_id[]" value="<?php echo $lists->id; ?>" >
                                                        <td class="valign-center" style="<?php
                                                        if ($this->auth == '0') {
                                                            echo"display:none;";
                                                        }
                                                        ?>" ><input <?php
                                                                if ($this->auth == '0') {
                                                                    echo"disabled";
                                                                }
                                                                ?> class="form-control doc_checkbox" type="checkbox" value="<?php echo $lists->id; ?>"></td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input disabled type="button" class="form-control masterPicUpdatebtn employeeInput fileUpload blue-btn" id="file_btn_<?php echo $i; ?>" data_attr_id='file_upload_<?php echo $i; ?>' value="<?php
                                                                if (isset($lists->file_name) && $lists->file_name != '') {
                                                                    echo substr($lists->file_name, -35);
                                                                } else {
                                                                    echo "Choose file to upload";
                                                                }
                                                                ?>">
                                                                <input disabled name="file_upload[][<?php echo $i; ?>]" title="View Document" data-btn-id="file_btn_<?php echo $i; ?>" type="file"  id="file_upload_<?php echo $i; ?>" data-err="file_err_<?php echo $i; ?>" style="display: none;"><div id="file_err_<?php echo $i; ?>"></div>
                                                                <?php if ($lists->file_name != '') { ?>
                                                                    <span class="download-btn"><a href="<?php
                                                                        if (isset($lists->file_name) && $lists->file_name != '') {
                                                                            echo base_url() . '/uploads/profile_document/' . $lists->file_name;
                                                                        }
                                                                        ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="" onclick="showDeletePop(<?php echo $lists->id; ?>)" title="Delete Document" class="<?php
                                                                    if ($this->auth == '0') {
                                                                        echo"none-pointer";
                                                                    }
                                                                    ?> removeDoc initial_doc_delete delete-btnconfig" data-dyn="initial_agreement"><i class="fas fa-trash"></i></a>
                                                                   <?php } ?>
                                                            </div>
                                                        </td>

                                                        <td><div class='position-relative'><input readonly disabled  class="form-control"  type="text" value="<?php if (isset($updated_date_doc) && $updated_date_doc != '') echo $updated_date_doc; ?>" class="form-controln" /><span class="calendar-position"><i class="far fa-calendar-alt"></i></span><span class='calendar-position'><i class='far fa-calendar-alt'></i></span></div></td>
                                                        <td><div class='position-relative'>
                                                            
                                                                 <input  disabled name="uploaded_by[][<?php echo $i; ?>]" class="form-control"  value="<?php if (isset($lists->emp_first_name) && $lists->emp_last_name != '') echo $lists->emp_first_name.' '.$lists->emp_last_name; ?>" type="text" placeholder="Uploaded By" class="form-controln"></div></td>

                                                       
                                                        <td><input disabled name="description[][<?php echo $i; ?>]"  class="form-control"  value="<?php if (isset($lists->description) && $lists->description != '') echo $lists->description; ?>" type="text" placeholder="Enter description"></td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    }
                                                }else {
                                                    ?>
                                                    <tr class="metric_more no_data">
                                                        <td colspan="6" style="text-align: center;">No data available in table</td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
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

<style type="text/css">
    .exe_doc{
        width:180px;
    }
</style>

<?php $this->load->view('vitals_footer.php'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        emp_name = '<?php echo $user_name; ?>';
        if ($('input:checkbox.new_doc_checkbox').length > 0) {
            $("#save_document").removeClass("opacity5 none-pointer");
            $(".new_doc_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
        }

        $(document).on('click', '.delete_cls', function () {
            var cur_attr = $(this).attr("data-chk-attr");
            $('#delCount').val('');
            var sel_item = $('input:checkbox.' + cur_attr + ':checked').length;
            $('#delCount').html(sel_item);
        });

        $(document).on('click', '.masterPicUpdatebtn', function () {
            $current = $(this).attr('data_attr_id');
            $("input[id=" + $current + "]").click();
        });
    });

    function showDeletePop(ids) {
        $("#delCount").text('');
        $('#deleteModal').modal('toggle');
        $("#delete_doc_id").val(ids);
    }

    $(".portfolioclose").click(function () {
        $("#delete_doc_id").val('');
    });

    function call_ajax_doc_delete(id) {
        $.ajax({
            url: '<?php echo base_url() . 'index.php/myprofile/ajax_delete_funder_document' ?>',
            cache: false,
            type: "POST",
            data: {id: id},
            dataType: "json",
            success: function (response) {
                if (response.status == 1) {
                    location.reload();
                    return false;
                }
            }
        });
    }

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

    $(document).ready(function () {
        $("#add_document").click(function () {
            $(".no_data").css('display', 'none');

            var funder_doc_len = $('#funder_document tr').length + 1;
            var markup = "<tr class='metric_more' id=document_len_" + funder_doc_len + "><td class='valign-center'><input type='hidden' name='document_id[]' value='' ><input class='form-control doc_checkbox new_doc_checkbox' type='checkbox'></td><td><input type='button' class='form-control masterPicUpdatebtn employeeInput'  id=file_btn_" + funder_doc_len + " data_attr_id='file_upload_" + funder_doc_len + "' value='Choose file to upload'><input type='file' data-btn-id=file_btn_" + funder_doc_len + " data-err=file_err_" + funder_doc_len + " name=file_upload[][" + funder_doc_len + "] id='file_upload_" + funder_doc_len + "' style='display:none'><div id=file_err_" + funder_doc_len + "></div></td><td><div class='position-relative'><input readonly class='form-control'  type='text' value='<?php echo date('d-m-Y', time()); ?>'><span class='calendar-position'><i class='far fa-calendar-alt'></i></span></div></td><td><input disabled class='form-control uploaded_by'   type='text' placeholder='Uploaded by'  value ='<?php echo $this->session->userdata['emp_name']; ?>' ></td><td><input class='form-control'  name=description[][" + funder_doc_len + "] type='text' placeholder='Enter description'></td></tr>";
            $("#funder_document tbody").prepend(markup);
            $('#document_checkbox').prop('checked', false);
            $("#save_document").removeClass("opacity5 none-pointer");
        });

        $(document).on('change', '.doc_checkbox,#document_checkbox', function () {
            if ($('input:checkbox.doc_checkbox').length > 0) {
                if ($('input:checkbox.doc_checkbox').length != $('input:checkbox.doc_checkbox:checked').length) {
                    $('#document_checkbox').prop('checked', false);
                } else if ($('input:checkbox.doc_checkbox').length == $('input:checkbox.doc_checkbox:checked').length) {
                    $('#document_checkbox').prop('checked', true);
                }
            }

            if ($('input:checkbox.doc_checkbox:checked').length > 0) {
                $("#delete_document").removeClass("opacity5 none-pointer");
                $("#save_document").removeClass("opacity5 none-pointer");
            } else {
                $("#delete_document").addClass("opacity5 none-pointer");
                $("#save_document").addClass("opacity5 none-pointer");
            }

            if ($('input:checkbox.new_doc_checkbox').length > 0) {
                $("#save_document").removeClass("opacity5 none-pointer");
                $(".new_doc_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
                $(".uploaded_by").prop("disabled", true);
            }
        });

        $(document).on('change', '.new_doc_checkbox', function () {
            $("#save_document").removeClass("opacity5 none-pointer");
        });

        $("#delete_document").click(function () {
            $('#deleteModal').modal('show');
            if ($('input:checkbox.doc_checkbox:checked').length > 0) {
                $("#hid_table_type").val('hid_document_table');
            }
        });

        $("#edit_document").click(function () {
            var current_tbl_id = $(this).attr("data-attr");
            $("#" + current_tbl_id + " tbody").find('input[type="checkbox"]').each(function () {
                if ($(this).is(":checked")) {
                    $(this).parents("tr").find('input[type="button"],input[type="text"],input[type="file"],input[type="hidden"],select,textarea').prop("disabled", false);
                    $(".uploaded_by").prop("disabled", true);
                }
            });
        });

        $(document).on('click', '.doc_checkbox', function () {
            if (!$(this).is(":checked")) {
                $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", true);
            } else {
                $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
                $(".uploaded_by").prop("disabled", true);
            }
        });

        $("#editSubmit").click(function () {
            $('#delCount').val('');
            var delete_doc_val = $('#delete_doc_id').val();
            if (delete_doc_val != '' && delete_doc_val != undefined) {
                call_ajax_doc_delete(delete_doc_val);
                return false;
            }
            var cur_val = $("#hid_table_type").val();
            var common_ids = [];
            if (cur_val == 'hid_document_table') {
                $("#funder_document tbody").find('input[type="checkbox"]').each(function (index) {
                    if ($(this).is(":checked")) {
                        if (this.value != '' && this.value != undefined) {
                            common_ids[index] = this.value;
                        }
                        $(this).parents("tr").remove();
                    }
                });
                ajax_common_delete(common_ids, 'hr_user_document');
            }
            $("#hid_table_type").val('');

            if ($('input:checkbox.doc_checkbox').length == 0) {
                $('#document_checkbox').prop('checked', false);
            }

            if ($('input:checkbox.doc_checkbox:checked').length > 0) {
                $("#delete_document").removeClass("opacity5 none-pointer");
                $("#save_document").removeClass("opacity5 none-pointer");
            } else {
                $("#delete_document").addClass("opacity5 none-pointer");
                $("#save_document").addClass("opacity5 none-pointer");
            }

            if ($('input:checkbox.new_doc_checkbox').length > 0) {
                $("#save_document").removeClass("opacity5 none-pointer");
                $(".new_doc_checkbox").parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
            }
        });

        $('.common_checkbox').click(function (e) {
            var table = $(e.target).closest('table');
            var cur_tbl_id = $(e.target).closest('table').attr('id');
            $('td input:checkbox', table).prop('checked', this.checked);
            if (!this.checked) {
                $("#" + cur_tbl_id + " tbody").find('input[type="checkbox"]').each(function () {
                    if (!$(this).is(":checked")) {
                        $(this).parents("tr").find('input[type="text"],input[type="button"],input[type="file"],input[type="hidden"],select,textarea').prop("disabled", true);
                    }
                });
            } else {
                $("#" + cur_tbl_id + " tbody").find('input[type="checkbox"]').each(function () {
                    if ($(this).is(":checked")) {
                        $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"],select,textarea').prop("disabled", false);
                    }
                });
            }
            $(".uploaded_by").prop("disabled", true);
        });
    });

    $('#save_document').click(function () {
        var disabled_count = $('#funder_document').find('input[type="text"]').not(":disabled").length;
        if (disabled_count > 0) {
            if (error_count == 0) {
                if ($("#edit_document_form").valid() == true) {
                    $("#save_document").addClass("none-pointer");
                    $("#edit_document_form").submit();
                }
            }
        }
    });

    function ajax_common_delete(common_id, formType) {
        $.ajax({
            url: '<?php echo base_url() . 'index.php/myprofile/ajax_common_delete' ?>',
            cache: false,
            type: "POST",
            data: {common_id: common_id, formType: formType},
            dataType: "json",
            success: function (response) {
                window.location.reload();
            }
        });
    }

    $(document).ready(function () {
        var checkBoxStatus = '<?php echo $this->auth; ?>';
        if (checkBoxStatus == '0') {
            $("input[type='button'],input[type='file'],input[type='text'],input[type='hidden'],select,textarea").prop("disabled", true);
        }
    });

</script>

</body>
</html>