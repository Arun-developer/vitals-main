<?php $this->load->view('vitals_header.php', array('main_menu' => 'funder', 'page_title' => 'Employee - Document info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'change_password', 'page' => 'change_password')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/user/document/'.$emp_id; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?= $employee[0]['emp_name']; ?></h4>                        
                    </div>
                </div>
                <?php
                $menu_access = explode(',', $employee_detail[0]['tab_access']);
                $bank_opacity = $depent_opacity = $edu_opacity = $immig_opacity = $job_opacity = $report_opacity = $doc_opacity = '';
                $bank_blur = $depent_blur = $edu_blur = $immig_blur = $job_blur = $report_blur = $doc_blur = '';
                if (in_array('1', $menu_access)) {
                  $bank_menu_url = base_url() . 'index.php/user/bank/' . $emp_id;
              } else {
                  $bank_menu_url = 'javascript:void(0);';
                  $bank_opacity = 'opacity5 nocursor';
                  $bank_blur = 'menu-blur';
              }

              if (in_array('2', $menu_access)) {
                  $depent_menu_url = base_url() . 'index.php/user/dependents/' . $emp_id;
              } else {
                  $depent_menu_url = 'javascript:void(0);';
                  $depent_opacity = 'opacity5 nocursor';
                  $depent_blur = 'menu-blur';
              }

              if (in_array('3', $menu_access)) {
                  $edu_menu_url = base_url() . 'index.php/user/education/' . $emp_id;
              } else {
                  $edu_menu_url = 'javascript:void(0);';
                  $edu_opacity = 'opacity5 nocursor';
                  $edu_blur = 'menu-blur';
              }

              if (in_array('4', $menu_access)) {
                  $immig_menu_url = base_url() . 'index.php/user/immigration/' . $emp_id;
              } else {
                  $immig_menu_url = 'javascript:void(0);';
                  $immig_opacity = 'opacity5 nocursor';
                  $immig_blur = 'menu-blur';
              }

              if (in_array('5', $menu_access)) {
                  $job_menu_url = base_url() . 'index.php/user/job/' . $emp_id;
              } else {
                  $job_menu_url = 'javascript:void(0);';
                  $job_opacity = 'opacity5 nocursor';
                  $job_blur = 'menu-blur';
              }

              if (in_array('6', $menu_access)) {
                  $report_menu_url = base_url() . 'index.php/user/reporting/' . $emp_id;
              } else {
                  $report_menu_url = 'javascript:void(0);';
                  $report_opacity = 'opacity5 nocursor';
                  $report_blur = 'menu-blur';
              }

              if (in_array('7', $menu_access)) {
                  $doc_menu_url = base_url() . 'index.php/user/document/' . $emp_id;
              } else {
                  $doc_menu_url = 'javascript:void(0);';
                  $doc_opacity = 'opacity5 nocursor';
                  $doc_blur = 'menu-blur';
              }
              ?>
              <div class="plan-structure-vital vital_windowScroll">
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" ><a href="<?php echo base_url() . 'index.php/user/personal/' . $emp_id; ?>">Personal</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/login/' . $emp_id; ?>">Login</a></li>
                                <li role="presentation"><a class="<?= $report_opacity; ?> <?= $report_menu; ?>" href="<?php echo $report_menu_url; ?>">Reporting</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/contact/' . $emp_id; ?>">Contacts</a></li>
                                <li role="presentation"><a class="<?= $depent_opacity; ?> <?= $depent_menu; ?>" href="<?php echo $depent_menu_url; ?>">Dependents</a></li>
                                <li role="presentation" class="active"><a href="javascript:void(0);">Immigration</a></li>
                                <li role="presentation"><a class="<?= $job_opacity; ?> <?= $job_menu; ?>" href="<?php echo $job_menu_url; ?>">Job & Salary</a></li>
                                <li role="presentation"><a class="<?= $bank_opacity; ?> <?= $bank_menu; ?>" href="<?php echo $bank_menu_url; ?>">Bank</a></li>
                                <li role="presentation"><a class="<?= $edu_opacity; ?> <?= $edu_menu; ?>" href="<?php echo $edu_menu_url; ?>">Education</a></li>
                                <li role="presentation" class="active"><a href="javascript:void(0);">Document</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                        <main class="page-content">
                            <form id="add_furnder_form" name="add_furnder_form" action="<?php echo base_url() . 'index.php/user/add_document/'?>" enctype="multipart/form-data" method="POST">
                                <div class="inputplan-structureall plan-structure-new">

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
                                                    <!-- <?php echo'<pre>';print_r($this->uri->segment('3')); ?> -->
                                                        <th width="20%">Upload Document </th>
                                                        <th width="20%">Document Description</th>
                                                        <th width="20%">Date Uploaded</th>
                                                        <th width="20%">Uploaded By</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="body_content">
                                                    <?php
                                                    $j = 1;
                                                    $document_count = isset($document[0]['id']) ? php72_count($document) : 0;
                                                    if (php72_cmp($document_count) > 0) {
                                                        for ($i = 0; $i < $document_count; $i++) {
                                                            $uploaded_date = isset($document[$i]['created_at']) && $document[$i]['created_at'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($document[$i]['created_at'])) : '';
                                                            ?>
                                                            <tr class="metric_more" id="document_len_0<?php echo $j; ?>">
                                                                <td class="valign-center"><input value="<?php echo $document[$i]['id'] ?>" class="form-control doc_checkbox" type="checkbox"></td>
                                                                <input type="hidden" disabled name="doc_id[]" value="<?php echo $document[$i]['id'] ?>" ></input>

                                                                <?php echo form_hidden('employee_id',($this->uri->segment('3')));?>

                                                                <td>
                                                                    <input type="button" class="form-control masterPicUpdatebtn employeeInput" id="file_btn_0<?php echo $j; ?>" data_attr_id='file_upload_0' value="Choose/Upload File">
                                                                    <input name=file_upload[][0] type="file" id="file_upload_0" data-btn-id="file_btn_0" style="display: none;" data-err='file_err_0'  disabled />
                                                                    <div id="file_err_0"></div>

                                                                    <?php

                                                                    $document_download = base_url() . 'uploads/profile_document/'.  $document[$i]['document']; 

                                                           // print_r($document_download);

                                                                    ?>

                                                                    <a href="<?php echo $document_download; ?>" target="_blank"><i class="far fa-file-pdf" aria-hidden="true"></i> Download</a>

                                                                </td>
                                                                <td style="width: 20%;"><input title="Enter description" name='description[][0]' id="description<?php echo $j; ?>" class="form-control" type="text" placeholder="Enter description" value="<?= $document[$i]['description']; ?>" disabled></td>

                                                                <td style="width: 20%;">
                                                                    <div class="position-relative">           
                                                                        <input type="text" id='dob<?php echo $j; ?>' title="Uploaded Date" class="form-control form-control-sm dateCalendar" name="uploaded_date[][0]" placeholder="dd-mm-yyyy" value="<?php echo date('d/m/Y',strtotime($document[$i]['created_at'])); ?>" disabled />

                                                                    </div>
                                                                </td>
                                                                <!-- <td style="width: 20%;"><input title="Date Uploaded" name='uploaded_date[][0]' class="form-control" type="text" placeholder="Uploaded Date"></td> -->
                                                                <?php
                                                                $updated_by_name='-';
                                                                if(isset($employee_data[$document[$i]['updated_by']]))
                                                                {
                                                                    $updated_by_name=$employee_data[ $document[$i]['updated_by']]['emp_name'];
                                                                }


                                                                ?>
                                                                <td style="width: 20%;"><input title="Uploaded by" name='uploaded_by[][0]' id="uploaded_by<?php echo $j; ?>" class="form-control" type="text" placeholder="Uploaded By" value="<?= $updated_by_name; ?>" disabled></td>

                                                                <td></td>
                                                            </tr>

                                                            <?php
                                                            $j++;
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr id="document_len_0" class="metric_more">
                                                            <input type="hidden" name="document_len_0[]" value="" />
                                                            <td id="noDataMsg" valign="top" colspan="7" class="none-pointer" style="text-align: center;">No data available in table</td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="height:20px"></div>
                                        <div class="row">
                                            <div class="col-12 col-sm-4  col-md-4 text-right">
                                                <div class="text-left">
                                                    <ul class="vitals-links saveLinkView ">
                                                        <li><a class="vital_yellow_btn wdt_100" id="submit_form">Save</a></input></li>
                                                        <li><a href="<?php echo base_url() . 'index.php/user/document/'.$emp_id; ?>" id="cancel_btn" class="vital_bordered_btn wdt_100">Cancel</a></li>
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

<div class="modal" id="deletemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Document - Are you sure you want to delete selected items?</h4>
                            <p>you are about delete <span id="delCount"></span> selected information fields, you can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('load_currency' => 'currency')); ?>

<script type="text/javascript">

    $(document).ready(function () {

    //Disable input box by table id
    $(document).on('click', '.doc_checkbox', function() {
        if (!$(this).is(":checked")) {
            $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"]').prop("disabled", true);
        } else {
            $(this).parents("tr").find('input[type="button"],input[type="file"],input[type="text"],input[type="hidden"]').prop("disabled", false);
        }
    });


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
    $(function () {
        $("#add_furnder_form").validate();
    });

    $(document).on('click', '.delete_cls', function () {
        var cur_attr = $(this).attr("data-chk-attr");

        $('#delCount').val('');
        var sel_item = $('input:checkbox.' + cur_attr + ':checked').length;
        $('#delCount').html(sel_item);
    });

    

    function datePicker() {
        $(".dateCalendar").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy",
            yearRange: "-100:+0",
            maxDate: 0
        });
    }

    $(document).ready(function () {
        datePicker();
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

        // $("#delete_document").click(function () {
        //     if ($('input:checkbox.doc_checkbox:checked').length > 0) {
        //         $("#hid_table_type").val('hid_document_table');
        //     }
        //     $('#deleteModal').modal('show');
        // });

        $(document).on('click', '#delete_document', function () {
            $('#delCount').val('');
            var sel_item = $(".doc_checkbox:checkbox:checked").length;
            $('#delCount').html(sel_item);
            if (sel_item > 0)
                $('#deletemodal').modal('show');
        });

        $(document).on('click', '#deleteRecord', function () {
            var vals = $('.doc_checkbox:checkbox:checked').map(function () {
                return this.value;
            }).get().join(',');
            var del_id = vals.split(',');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/user/deleteUserData",
                data: {
                    id: del_id,
                    table: 'hr_user_document',
                    field: 'status'
                },
                dataType: 'json',
                success: function (msg) {
                    $('#deletemodal').modal('hide');
                    location.reload();
                }
            });
        });
        


        $("#add_document").click(function () {
            datePicker();
            var funder_doc_len = $('#funder_document tbody tr').length ;

            var markup = "<tr class='metric_more' id=document_len_" + funder_doc_len + ">"+
            "<td class='valign-center'><input class='form-control doc_checkbox' type='checkbox'></td>"+
            "<td><input type='button' class='form-control masterPicUpdatebtn employeeInput' id=file_btn_" + funder_doc_len + " data_attr_id='file_upload_" + funder_doc_len + "' value='Choose file to upload'><input type='file' data-btn-id=file_btn_" + funder_doc_len + " data-err=file_err_" + funder_doc_len + "  name='file_upload[]' id='file_upload_" + funder_doc_len + "' title='Please upload the file' style='display:none'><div id=file_err_" + funder_doc_len + "></div></td>"+

            "<td><input class='form-control'  name=description[] type='text' title='Enter the description' placeholder='Enter description'></td>"+
            "<td><div class='position-relative'><input type='text' id='dob' title='Uploaded_date' class='form-control form-control-sm dateCalendar'  name=uploaded_date[]  placeholder=' dd-mm-yyyy'><span class='calendar-position'><i class='far fa-calendar-alt'></i></span></div></td>"+
            "<td><input class='form-control'  name=uploaded_by[] type='text' title='Uploaded by' placeholder='Uploaded By'></td>"+
            "<td></td>"+
            "</tr>";
            $("#body_content").append(markup);
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
