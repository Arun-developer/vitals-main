
<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Profile -Bank Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
            <div id="leftMenuLoad">
                <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'change_password', 'page' => 'my_profile')); ?>
            </div>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                        
                        <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"><i class="fas fa-angle-left"></i> Back</a></span>
                        <h4><?= $employee[0]['emp_name']; ?></h4>
                        <?php $emp_id = $this->session->userdata('emp_number'); ?>
                    </div>
                    <!-- <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                        <ul class="vitals-links">
                            <li class="edit"><a href="<?php echo base_url() . 'index.php/myprofile/edit_immigration/' . $emp_id; ?>" id="editpersonal" class="edt_btnVital summaryEdit"><i class="fas fa-pencil-alt" style="text-align:right;"></i> Edit</a></li>
                        </ul>
                    </div> -->
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="display-hide" id="navLoad">
                        <div class="newCLickTabs">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/personal/' . $emp_id; ?>">Personal</a></li>
                                    <!-- <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/login/' . $emp_id; ?>">Login</a></li> -->
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/reporting/' . $emp_id; ?>">Reporting</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/contact/' . $emp_id; ?>">Contacts</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/dependents/' . $emp_id; ?>">Dependents</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/immigration/' . $emp_id; ?>">Immigration</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/job/' . $emp_id; ?>">Job & Salary</a></li>
                                    <li role="presentation" class="active"><a href="javascript:void(0)">Bank</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/education/' . $emp_id; ?>">Education</a></li>
                                    <li role="presentation"><a href="<?php echo base_url() . 'index.php/myprofile/document/' . $emp_id; ?>">Document</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new ">
                                    <form id="bank_form" action="<?php echo base_url() . 'index.php/myprofile/add_bank' ?>" method="POST" autocomplete="off">
                                        <input type="hidden" name="employee_id" value="<?= $emp_id; ?>">
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <h4>Bank</h4>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6  col-12 text-right">
                                                        <ul class="milestone-links">
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" id="addBank" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15 dependent_deluser opacity5 none-pointer" id="delBank"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </li>
                                                            <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue bank_submit opacity5 none-pointer">Save</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table table-hover dt-responsive" id="bank_list" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" class="removeArrow"><input class="form-control bank_checkAll" type="checkbox" onchange="bank_checkAll();"></th>
                                                        <th width="20%">Bank Name</th>
                                                        <th>Account No.</th>
                                                        <th>Branch Name</th>
                                                        <th>IFSC Code</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $j = 1;
                                                    $bank_count = isset($bank_list[0]['id']) ? count($bank_list) : 0;
                                                    if ($bank_count > 0) {
                                                        for ($i = 0; $i < $bank_count; $i++) {
                                                            ?>
                                                            <tr id="bank_tr_<?php echo $j; ?>" class="bank_more">
                                                        <input type="hidden" name="account_id[]" value="<?= $bank_list[$i]['id']; ?>" />
                                                        <td class="valign-center"><input class="form-control bank_checkbox" type="checkbox" name="bank_id[]" id="bank_id_<?= $j; ?>" value="<?= $bank_list[$i]['id']; ?>"></td>
                                                        <td><input class="form-control employeeInput" type="text" placeholder="Bank name" name="bank_name[]" id="bank_name_<?= $j; ?>" maxlength="50" value="<?= $bank_list[$i]['bank_name']; ?>"></td>
                                                        <td><input type="text" class="form-control employeeInput" name="account_number[]" id="account_number_<?= $j; ?>" maxlength="20" placeholder="Account number" value="<?= $bank_list[$i]['account_number']; ?>"></td>
                                                        <td><input type="text" class="form-control employeeInput" name="branch_name[]" id="branch_name_<?= $j; ?>" maxlength="20" placeholder="Branch name" value="<?= $bank_list[$i]['branch_name']; ?>"></td>
                                                        <td><input type="text" class="form-control employeeInput upper-case" name="ifsc_code[]" id="ifsc_code_<?= $j; ?>" maxlength="12" placeholder="IFSC code" value="<?= $bank_list[$i]['ifsc_code']; ?>"></td>
                                                        </tr>
                                                        </tbody>
                                                        <?php
                                                        $j++;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr id="bank_tr_1" class="bank_more">
                                                    <input type="hidden" name="account_id[]" value="" />
                                                    <td id="noDataMsg" valign="top" colspan="7" class="none-pointer" style="text-align: center;">No data available in table</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
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

<input type="hidden" id="enable_bank" value="<?= count($bank_list); ?>">
<input type="hidden" id="enable_save" value="0">

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        var previous_type = localStorage.getItem('emp_type');
        if (previous_type != '') {
            var link = "<?php echo base_url() . 'index.php/myprofile/lists/'; ?>" + previous_type;
            $('#backPage').attr('href', link);
        }

        var bank = $('#enable_bank').val();
        if (bank > 0) {
            $('#bank_list .employeeInput').attr('readonly', 'readonly');
            $('#bank_list .employeeInput').css("pointer-events", "none");
        } else {
            $('#bank_list input').removeClass('employeeInput');
            $('#bank_list .employeeInput').attr('readonly', false);
            $('#bank_list .employeeInput').css("pointer-events", "");
            $('.bank_checkAll').hide();
        }
    });

    $(document).on('click', '.bank_submit', function () {
        $('#bank_form').submit();
    });

    function bank_checkAll() {
        var save = $('#enable_save').val();
        if ($('.bank_checkAll:checked').length > 0) {
            $('.bank_checkbox').prop('checked', true);
            $('#delBank').removeClass('opacity5');
            $('#delBank').removeClass('none-pointer');
            $('#bank_list .employeeInput').attr('readonly', false);
            $('#bank_list .employeeInput').css("pointer-events", "");
            if (save == 0) {
                $('.bank_submit').removeClass('opacity5');
                $('.bank_submit').removeClass('none-pointer');
            }
        } else {
            $('.bank_checkbox').prop('checked', false);
            $('#delBank').addClass('opacity5');
            $('#delBank').addClass('none-pointer');
            $('#bank_list .employeeInput').attr('readonly', 'readonly');
            $('#bank_list .employeeInput').css("pointer-events", "none");
            if (save == 0) {
                $('.bank_submit').addClass('opacity5');
                $('.bank_submit').addClass('none-pointer');
            }
        }
    }

    $(document).on('click', '.bank_checkbox', function () {
        if ($('.bank_checkbox:checked').length == $('.bank_checkbox').length) {
            $('.bank_checkAll').prop('checked', true);
        } else {
            $('.bank_checkAll').prop('checked', false);
        }

        var design_check = $('.bank_checkbox:checkbox:checked').length;
        var save = $('#enable_save').val();
        if (design_check > 0) {
            $('#delBank').removeClass('opacity5');
            $('#delBank').removeClass('none-pointer');
            if (save == 0) {
                $('.bank_submit').removeClass('opacity5');
                $('.bank_submit').removeClass('none-pointer');
            }
        } else {
            $('#delBank').addClass('opacity5');
            $('#delBank').addClass('none-pointer');
            if (save == 0) {
                $('.bank_submit').addClass('opacity5');
                $('.bank_submit').addClass('none-pointer');
            }
        }

        $('#bank_form .bank_checkbox').each(function () {
            var g_id = $(this).closest('tr').attr('id');
            if ($(this).is(":checked")) {
                $('#' + g_id + ' .employeeInput').attr("readonly", false);
                $('#' + g_id + ' .employeeInput').css("pointer-events", "");
            } else {
                $('#' + g_id + ' .employeeInput').attr("readonly", true);
                $('#' + g_id + ' .employeeInput').css("pointer-events", "none");
            }
        });
    });

    $(document).on('click', '#delBank', function () {
        $('#delCount').val('');
        var sel_item = $(".bank_checkbox:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0)
            $('#deletemodal').modal('show');
    });

    $(document).on('click', '#deleteRecord', function () {
        var vals = $('.bank_checkbox:checkbox:checked').map(function () {
            return this.value;
        }).get().join(',');
        var del_id = vals.split(',');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/myprofile/deleteUserData",
            data: {
                id: del_id,
                table: 'hr_user_bank',
                field: 'status'
            },
            dataType: 'json',
            success: function (msg) {
                $('#deletemodal').modal('hide');
                location.reload();
            }
        });
    });

    $(document).on('click', '#addBank', function () {
        $('.bank_submit').removeClass('opacity5');
        $('.bank_submit').removeClass('none-pointer');
    });

    $(document).on('click', '#addBank', function () {
        var dyn = $(".bank_more").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="bank_tr_' + i + '" class="bank_more"><input type="hidden" name="account_id[]" value="" /><td class="valign-center"><input class="form-control bank_checkbox" type="checkbox" name="bank_id[]" id="bank_id_' + i + '" value=""></td>';
        datas += '<td><input class="form-control" type="text" placeholder="Bank name" name="bank_name[]" id="bank_name_' + i + '" maxlength="50" value=""></td>';
        datas += '<td><input type="text" class="form-control" name="account_number[]" id="account_number_' + i + '" maxlength="20" placeholder="Account number" value=""></td>';
        datas += '<td><input type="text" class="form-control" name="branch_name[]" id="branch_name_' + i + '" maxlength="20" placeholder="Branch name" value=""></td>';
        datas += '<td><input type="text" class="form-control upper-case" name="ifsc_code[]" id="ifsc_code_' + i + '" maxlength="12" placeholder="IFSC code" value=""></tr>';
        $(datas).insertBefore($('#bank_tr_1'));
        $('#enable_save').val('1');
        $('#noDataMsg').hide();
        $('.bank_checkAll').show();
    });

</script>

</body>
</html>