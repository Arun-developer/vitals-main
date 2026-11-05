<?php
$form_type = $this->uri->segment(3);
$this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - ' . ucfirst($form_type) . ' Vendor', 'page_table' => 'datatable'));
?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('page' => 'vendor_master')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/master/vendor_master'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?= ucfirst($form_type); ?> Vendor Master</h4>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <?php if (isset($editid) && $editid != '') { ?>
                                <li <?php if (!isset($editid)) { ?>class="activeTabs" <?php } ?>><a href="<?php echo base_url() . 'index.php/master/vendor_master/add'; ?>" class="edt_btnVital"><i class="fas fa-plus-circle"></i> Add</a></li>
                                <li class="edit"><a href="javascript:void(0)" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt"></i> Edit</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="inputplan-structureall plan-structure-new ">
                        <form id="vendor_form" method="post" action="<?php echo base_url() . 'index.php/master/addVendor'; ?>" autocomplete="off">
                            <div class="row">
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Vendor Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="vendor_name" id="vendor_name" value="<?php echo isset($editid) && $editid != '' ? $vendorList[0]['vendor_name'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Website <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="website" id="website" value="<?php echo isset($editid) && $editid != '' ? $vendorList[0]['website'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Company Address <span class="text-danger">*</span></label>
                                        <textarea class="form-control additionalInput" <?= $disabled; ?> name="address" id="address"><?php echo isset($editid) && $editid != '' ? $vendorList[0]['address'] : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Contact Person <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="contact_person" id="contact_person" value="<?php echo isset($editid) && $editid != '' ? $vendorList[0]['contact_person'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Contact Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput numeric" <?= $disabled; ?> name="contact_no" id="contact_no" value="<?php echo isset($editid) && $editid != '' ? $vendorList[0]['contact_no'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="form-group">
                                        <label>Email Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control additionalInput" <?= $disabled; ?> name="vendor_email" id="vendor_email" value="<?php echo isset($editid) && $editid != '' ? $vendorList[0]['vendor_email'] : ''; ?>" >
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4 col-xl-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-4  col-md-4 ">
                                    <div class="text-left">
                                        <ul class="vitals-links saveLinkView <?= $dis_hide; ?>">
                                            <li><input type="submit" value="Add" class="wdt_100 vital_yellow_btn"></li>
                                            <li><a href="<?php echo base_url() . 'index.php/master/vendor_master'; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="edit_id" id="edit_id" value="<?php echo isset($editid) ? $editid : '' ?>" />
                            <input type="hidden" name="type" id="type" value="<?php echo isset($type) ? $type : '' ?>" />

                            <div class="table_configcontentnew pad-bt0">
                                <div class="tabpanel-title">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                            <h4>More Contacts</h4>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                            <ul class="milestone-links">
                                                <li class="brd-left-onboard">
                                                    <a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15 <?= $opt; ?>"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                </li>
                                                <li class="brd-left-onboard">
                                                    <a href="javascript:void(0)" class="edit-btnconfig mar-tp15  opacity5 none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                <table class="table table-hover dt-responsive" id="contactmore_table">
                                    <thead>
                                        <tr>
                                            <th width="10%"><input class='form-control type_check_all' type='checkbox'  name='type_check_all' id='type_check_all' onchange="selectall_chk();" ></th>
                                            <th width="30%">Contact Person</th>
                                            <th width="30%">Contact Number</th>
                                            <th width="30%">Email Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $t = 1;
                                        $cont_len = php72_count($vendorcontacts) > 0 ? php72_count($vendorcontacts) : 1;
                                        for ($j = 0; $j < $cont_len; $j++) {
                                            ?>
                                            <tr id="contact_tr_<?= $t; ?>" class="contact_more">
                                        <input type="hidden" name="contact_edit_id[]" id="contact_edit_id_<?= $t; ?>" value="<?= isset($vendorcontacts[$j]['contact_id']) ? $vendorcontacts[$j]['contact_id'] : 0; ?>" />
                                        <td class="valign-center"><input class="form-control new_field typecheck master_check" type="checkbox" name="contact_check" id="contact_check_<?= $t; ?>" onchange="deleteids(this.value);" value="<?= $t; ?>"></td>
                                        <td><input type="text" class="form-control additionalInput" <?= $disabled; ?> name="contactmore_person[]" id="contactmore_person_<?= $t; ?>" value="<?= isset($vendorcontacts[$j]['name']) ? $vendorcontacts[$j]['name'] : ''; ?>" placeholder="Enter contact person" /></td>
                                        <td><input type="text" class="form-control additionalInput numeric" <?= $disabled; ?> name="contactmore_no[]" id="contactmore_no_<?= $t; ?>" value="<?= isset($vendorcontacts[$j]['contact_no']) ? $vendorcontacts[$j]['contact_no'] : ''; ?>" placeholder="Enter contact number" /></td>
                                        <td><input type="text" name="contactmore_email[]" id="contactmore_email_<?= $t; ?>" class="form-control commonAlphaNum inline_field_<?= $t; ?> additionalInput" <?= $disabled; ?> value="<?= isset($vendorcontacts[$j]['email']) ? $vendorcontacts[$j]['email'] : ''; ?>" placeholder="Enter contact email" /></td>
                                        </tr>
                                        <?php
                                        $t++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <input type="hidden" name="delete_ids" id="delete_ids" />
                                <input type="hidden" name="code_count" id="code_count" value="<?= $count_types; ?>" />
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
                            <h4>Are you sure you want to delete selected items?</h4>
                            <p>you are about to delete <span id="delCount"></span> selected row, you can't undo this</p>
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

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $('.numeric').on('input', function (event) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $('#vendor_form').validate({
        rules: {
            vendor_name: "required",
            website: "required",
            address: "required",
            contact_person: "required",
            contact_no: "required",
            vendor_email: {
                required: true,
                email: true
            }

        },
        messages: {
            vendor_name: "Enter vendor name",
            website: "Enter website",
            address: "Enter contact address",
            contact_person: "Enter contact person",
            contact_no: "Enter contact number",
            vendor_email: "Enter contact email id"
        }
    });

    $('.summaryEdit').click(function () {
        $(".additionalInput").attr("disabled", false);
        $("#addMore").removeClass("opacity5 none-pointer");
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').removeClass("display-hide");
        $('.saveLinkView').addClass("display-show");
    });

    function deleteids(checkid) {
        var store = $('#delete_ids').val();
        var arr = store.split(',');
        var leavelen = $('.typecheck').length;
        var leaveinput = $('.typecheck:checked').length;

        var delete_id = $('#contact_edit_id_' + checkid).val();
        if (leavelen != leaveinput) {
            $('.type_check_all').prop('checked', false);
        } else {
            $('.type_check_all').prop('checked', true);
        }

        if ($('#contact_check_' + checkid).prop('checked') == true) {
            // $("#delUser").addClass("clr_red");
            $("#delUser").removeClass("opacity5 none-pointer");
            var idx = $.inArray(delete_id, arr);
            if (idx === -1) {
                arr.push(delete_id)
                arr.join(',')
                $('#delete_ids').val(arr);
            }
            $('.inline_field_' + delete_id).attr('readonly', false);
        } else {
            var idx = $.inArray(delete_id, arr);
            if (idx === -1) {
            } else {
                $('.inline_field_' + delete_id).attr('readonly', true);
                arr.splice(arr.indexOf(delete_id), 1);
                arr.join(',')
                $('#delete_ids').val(arr);
            }
            if (arr == '') {
                $("#delUser").addClass("opacity5 none-pointer");
            }
        }
    }

    $(document).on('click', '#delUser', function () {
        $('#delCount').val('');
        var sel_item = $(".master_check:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0)
            $('#deletemodal').modal('show');
    });

    $(document).on('click', '#deleteRecord', function () {
        var id = $('#delete_ids').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/master/deleteMasterSetting",
            data: {
                id: id,
                field: 'contact_id',
                delval: '0',
                table: 'master_vendor_contact',
            },
            dataType: 'json',
            success: function (msg) {
                $('#deletemodal').modal('hide');
                // $('.deletetoast').toast('show');
                $('.deleteMsg').removeClass('display-hide');
                // setTimeout(function() {
                location.reload();
                // }, 3000);
            }
        });
    });

    function selectall_chk() {
        if ($('input[name="type_check_all"]:checked').length > 0) {
            $('.typecheck').prop('checked', true);
            // var favorite = [];
            $.each($(".typecheck:checked"), function () {
                // favorite.push($(this).val());
                deleteids($(this).val());
            });
        } else {
            $('.typecheck').prop('checked', false);
            $.each($(".typecheck"), function () {
                // favorite.push($(this).val());
                deleteids($(this).val());
            });
        }
    }

    $(document).on('click', '#addMore', function () {
        var dyn = $("#contactmore_table tr").length + 1;
        var empty_dT = $(".dataTables_empty").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="contact_tr_' + i + '" class="contact_more"><input type="hidden" name="contact_edit_id[]" id="contact_edit_id_' + i + '" value="0"> <td class="valign-center"><input class="form-control new_field typecheck master_check" type="checkbox" name="contact_check" id="contact_check_' + i + '" onchange="deleteids(this.value);" value="' + i + '"></td>';
        datas += '<td><input type="text" class="form-control" name="contactmore_person[]" id="contactmore_person_' + i + '" value="" placeholder="Enter contact person" /></td>';
        datas += '<td><input type="text" class="form-control" name="contactmore_no[]" id="contactmore_no_' + i + '" value="" placeholder="Enter contact number" /></td>';
        datas += '<td><input type="text" name="contactmore_email[]" id="contactmore_email_' + i + '" class="form-control commonAlphaNum inline_field_' + i + '" value="" placeholder="Enter contact email" /></td></tr>';

        $("#contactmore_table tbody").prepend(datas);
        // if(empty_dT = 1){
        //     $(".dataTables_empty").parent('tr').remove();
        // }
    });

    $(document).on('click', '.master_check_all', function () {
        if (!$(this).is(":checked")) {
            $('.master_check_all').prop('checked', false);
            $('.master_check').prop('checked', false);
        }
    });

</script>

</body>
</html>