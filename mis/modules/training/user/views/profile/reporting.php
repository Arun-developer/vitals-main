<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Employee - Reporting info', 'page_table' => 'datatable')); ?>

<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('page' => 'emp_list')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/user/lists/3'; ?>" id="backPage"><i class="fas fa-angle-left"></i> Back </a></span>
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
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/personal/' . $emp_id; ?>">Personal</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/login/' . $emp_id; ?>">Login</a></li>
                                <li role="presentation" class="active"><a href="javascript:void(0)">Reporting</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/user/contact/' . $emp_id; ?>">Contacts</a></li>
                                <li role="presentation"><a class="<?= $depent_opacity; ?> <?= $depent_menu; ?>" href="<?php echo $depent_menu_url; ?>">Dependents</a></li>
                                <li role="presentation"><a class="<?= $immig_opacity; ?> <?= $immig_menu; ?>" href="<?php echo $immig_menu_url; ?>">Immigration</a></li>
                                <li role="presentation"><a class="<?= $job_opacity; ?> <?= $job_menu; ?>" href="<?php echo $job_menu_url; ?>">Job & Salary</a></li>
                                <li role="presentation"><a class="<?= $bank_opacity; ?> <?= $bank_menu; ?>" href="<?php echo $bank_menu_url; ?>">Bank</a></li>
                                <li role="presentation"><a class="<?= $edu_opacity; ?> <?= $edu_menu; ?>" href="<?php echo $edu_menu_url; ?>">Education</a></li>
                                <li role="presentation"><a class="<?= $doc_opacity; ?> <?= $doc_menu; ?>" href="<?php echo $doc_menu_url; ?>">Document</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new ">
                                <form id="supervisor_form" action="<?php echo base_url() . 'index.php/user/add_supervisor' ?>" method="POST" autocomplete="off">
                                    <input type="hidden" name="employee_id" value="<?= $emp_id; ?>">
                                    <div class="table_configcontentnew pad-bt0">
                                        <div class="tabpanel-title">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                    <h4>Supervisors</h4>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                                    <ul class="milestone-links">
                                                        <li class="brd-left-onboard">
                                                            <a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                        </li>
                                                        <li class="brd-left-onboard">
                                                            <a href="javascript:void(0)" class="edit-btnconfig mar-tp15 supervisor_deluser opacity5 none-pointer" id="delSupervisor"><i class="fas fa-trash-alt"></i> Delete</a>
                                                        </li>
                                                        <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue supervisor_submit opacity5 none-pointer">Save</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                        <table class="table table-hover dt-responsive" id="supervisor_list" style="margin-top: 0">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="removeArrow"><input class="form-control supervisor_checkAll" type="checkbox" onchange="supervisor_checkAll();"></th>
                                                    <th width="25%">Employee ID</th>
                                                    <th width="40%">Employee Name</th>
                                                    <th width="30%">Reporting Method</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $j = 1;
                                                $supervisor_count = isset($supervisor_list[0]['id']) ? php72_count($supervisor_list) : 0;
                                                if ($supervisor_count > 0) {
                                                    for ($i = 0; $i < $supervisor_count; $i++) {
                                                        ?>
                                                        <tr id="supervisor_tr_<?php echo $j; ?>" class="supervisor_more">
                                                            <input type="hidden" name="report_sup[]" value="<?= $supervisor_list[$i]['id']; ?>" />
                                                            <td class="valign-center"><input class="form-control sup_checkbox" type="checkbox" name="supervisor_id[]" id="supervisor_id_<?= $j; ?>" value="<?= $supervisor_list[$i]['id']; ?>"></td>
                                                            <td><input class="form-control" disabled type="text" placeholder="Employee ID" name="supervisor_report[]" id="supervisor_report_<?= $j; ?>" value="<?= $supervisor_list[$i]['report_subordinate']; ?>"></td>
                                                            <td>
                                                                <select class="form-control employeeInput" readonly name="supervisor_employee[]" id="supervisor_employee_<?= $j; ?>" onchange="loadSupEmployee(<?= $j; ?>, this.value);">
                                                                    <option value="">-- Select --</option>
                                                                    <?php foreach ($employee_list as $e_name) { ?>
                                                                        <option value="<?= $e_name['id']; ?>" <?php
                                                                        if ($e_name['id'] == $supervisor_list[$i]['report_subordinate']) {
                                                                            echo "selected";
                                                                        }
                                                                        ?>><?= $e_name['emp_name']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control employeeInput" readonly name="supervisor_method[]" id="supervisor_method_<?= $j; ?>">
                                                                    <option value="">--Select--</option>
                                                                    <option value="1" <?php
                                                                    if ($supervisor_list[$i]['report_method'] == 1) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Direct</option>
                                                                    <option value="2" <?php
                                                                    if ($supervisor_list[$i]['report_method'] == 2) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Indirect</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $j++;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr id="supervisor_tr_1" class="supervisor_more">
                                                        <input type="hidden" name="report_sup[]" value="" />
                                                        <td id="noSupervisorDataMsg" valign="top" colspan="7" class="none-pointer" style="text-align: center;">No data available in table</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                                <div style="height:15px"></div>
                                <form id="subordinate_form" action="<?php echo base_url() . 'index.php/user/add_subordinate' ?>" method="POST" autocomplete="off">
                                    <input type="hidden" name="employee_id" value="<?= $emp_id; ?>">
                                    <div class="table_configcontentnew pad-bt0">
                                        <div class="tabpanel-title">
                                            <div class="row">

                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                    <h4>Subordinates</h4>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                                    <ul class="milestone-links">
                                                        <li class="brd-left-onboard">
                                                            <a href="javascript:void(0)" id="addSubordinate" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                        </li>
                                                        <li class="brd-left-onboard">
                                                            <a href="javascript:void(0)" class="edit-btnconfig mar-tp15 subordinate_deluser opacity5 none-pointer" id="delSubordinate"><i class="fas fa-trash-alt"></i> Delete</a>
                                                        </li>
                                                        <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue subordinate_submit opacity5 none-pointer">Save</a></li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                        <table class="table table-hover dt-responsive" id="subordinate_list" style="margin-top: 0">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="removeArrow"><input class="form-control subordinate_checkAll" type="checkbox" onchange="subordinate_checkAll();"></th>
                                                    <th width="25%">Employee ID</th>
                                                    <th width="40%">Employee Name</th>
                                                    <th width="30%">Reporting Method</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $j = 1;
                                                $subordinate_count = isset($subordinate_list[0]['id']) ? php72_count($subordinate_list) : 0;
                                                if ($subordinate_count > 0) {
                                                    for ($i = 0; $i < $subordinate_count; $i++) {
                                                        ?>
                                                        <tr id="subordinate_tr_<?php echo $j; ?>" class="subordinate_more">
                                                            <input type="hidden" name="report_subor[]" value="<?= $subordinate_list[$i]['id']; ?>" />
                                                            <td class="valign-center"><input class="form-control subor_checkbox" type="checkbox" name="subordinate_id[]" id="subordinate_id_<?= $j; ?>" value="<?= $subordinate_list[$i]['id']; ?>"></td>
                                                            <td><input class="form-control" disabled type="text" placeholder="Employee ID" name="subordinate_report[]" id="subordinate_report_<?= $j; ?>" value="<?= $subordinate_list[$i]['report_supervisor']; ?>"></td>
                                                            <td>
                                                                <select class="form-control employeeInput" readonly name="subordinate_employee[]" id="subordinate_employee_<?= $j; ?>" onchange="loadSuborEmployee(<?= $j; ?>, this.value);">
                                                                    <option value="">-- Select --</option>
                                                                    <?php foreach ($employee_list as $e_name) { ?>
                                                                        <option value="<?= $e_name['id']; ?>" <?php
                                                                        if ($e_name['id'] == $subordinate_list[$i]['report_supervisor']) {
                                                                            echo "selected";
                                                                        }
                                                                        ?>><?= $e_name['emp_name']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control employeeInput" readonly name="subordinate_method[]" id="subordinate_method_<?= $j; ?>">
                                                                    <option value="">--Select--</option>
                                                                    <option value="1" <?php
                                                                    if ($subordinate_list[$i]['report_method'] == 1) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Direct</option>
                                                                    <option value="2" <?php
                                                                    if ($subordinate_list[$i]['report_method'] == 2) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Indirect</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        

                                                        <?php
                                                        $j++;
                                                    }
                                                } else {
                                                    ?>
                                                    <tr id="subordinate_tr_1" class="subordinate_more">
                                                        <input type="hidden" name="report_subor[]" value="" />
                                                        <td id="noSubordinateDataMsg" valign="top" colspan="7" class="none-pointer" style="text-align: center;">No data available in table</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                
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
                <button type="button" class="btn btn-success deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="enable_supervisor" value="<?= php72_count($supervisor_list); ?>">
<input type="hidden" id="enable_subordinate" value="<?= php72_count($subordinate_list); ?>">
<input type="hidden" id="enable_supervisor_save" value="0">
<input type="hidden" id="enable_subordinate_save" value="0">

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        var previous_type = localStorage.getItem('emp_type');
        if (previous_type != '') {
            var link = "<?php echo base_url() . 'index.php/user/lists/'; ?>" + previous_type;
            $('#backPage').attr('href', link);
        }

        var supervisor = $('#enable_supervisor').val();
        if (supervisor > 0) {
            $('#supervisor_list .employeeInput').attr('readonly', 'readonly');
            $('#supervisor_list .employeeInput').css("pointer-events", "none");
        } else {
            $('#supervisor_list input, #supervisor_list select').removeClass('employeeInput');
            $('#supervisor_list input, #supervisor_list select').attr('readonly', false);
            $('#supervisor_list select').removeClass('employeeInput');
            $('#supervisor_list .employeeInput').attr('readonly', false);
            $('#supervisor_list .employeeInput').css("pointer-events", "");
            $('.supervisor_checkAll').hide();
        }

        var subordinate = $('#enable_subordinate').val();
        if (subordinate > 0) {
            $('#subordinate_list .employeeInput').attr('readonly', 'readonly');
            $('#subordinate_list .employeeInput').css("pointer-events", "none");
        } else {
            $('#subordinate_list input, #subordinate_list select').removeClass('employeeInput');
            $('#subordinate_list input, #subordinate_list select').attr('readonly', false);
            $('#subordinate_list select').removeClass('employeeInput');
            $('#subordinate_list .employeeInput').attr('readonly', false);
            $('#subordinate_list .employeeInput').css("pointer-events", "");
            $('.subordinate_checkAll').hide();
        }

    });


    $(document).on('click', '.supervisor_submit', function () {
        $('#supervisor_form').submit();
    });

    function supervisor_checkAll() {
        var save = $('#enable_supervisor_save').val();
        if ($('.supervisor_checkAll:checked').length > 0) {
            $('.sup_checkbox').prop('checked', true);
            $('#delSupervisor').removeClass('opacity5');
            $('#delSupervisor').removeClass('none-pointer');
            $('#supervisor_list .employeeInput').attr('readonly', false);
            $('#supervisor_list .employeeInput').css("pointer-events", "");
            if (save == 0) {
                $('.supervisor_submit').removeClass('opacity5');
                $('.supervisor_submit').removeClass('none-pointer');
            }
        } else {
            $('.sup_checkbox').prop('checked', false);
            $('#delSupervisor').addClass('opacity5');
            $('#delSupervisor').addClass('none-pointer');
            $('#supervisor_list .employeeInput').attr('readonly', 'readonly');
            $('#supervisor_list .employeeInput').css("pointer-events", "none");
            if (save == 0) {
                $('.supervisor_submit').addClass('opacity5');
                $('.supervisor_submit').addClass('none-pointer');
            }
        }
    }

    $(document).on('click', '.sup_checkbox', function () {
        if ($('.sup_checkbox:checked').length == $('.sup_checkbox').length) {
            $('.supervisor_checkAll').prop('checked', true);
        } else {
            $('.supervisor_checkAll').prop('checked', false);
        }

        var design_check = $('.sup_checkbox:checkbox:checked').length;
        var save = $('#enable_supervisor_save').val();
        if (design_check > 0) {
            $('#delSupervisor').removeClass('opacity5');
            $('#delSupervisor').removeClass('none-pointer');
            if (save == 0) {
                $('.supervisor_submit').removeClass('opacity5');
                $('.supervisor_submit').removeClass('none-pointer');
            }
        } else {
            $('#delSupervisor').addClass('opacity5');
            $('#delSupervisor').addClass('none-pointer');
            if (save == 0) {
                $('.supervisor_submit').addClass('opacity5');
                $('.supervisor_submit').addClass('none-pointer');
            }
        }

        $('#supervisor_form .sup_checkbox').each(function () {
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

    $(document).on('click', '#delSupervisor', function () {
        $('#delCount').val('');
        var sel_item = $(".sup_checkbox:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0) {
            $('#deletemodal').modal('show');
            $('.deleteRecord').attr('id', 'delete_supervisor');
        }
    });

    $(document).on('click', '#delete_supervisor', function () {
        var vals = $('.sup_checkbox:checkbox:checked').map(function () {
            return this.value;
        }).get().join(',');
        var del_id = vals.split(',');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/user/deleteUserData",
            data: {
                id: del_id,
                table: 'hr_user_reporting',
                field: 'status'
            },
            dataType: 'json',
            success: function (msg) {
                $('#deletemodal').modal('hide');
                location.reload();
            }
        });
    });

    $(document).on('click', '.subordinate_submit', function () {
        $('#subordinate_form').submit();
    });

    function subordinate_checkAll() {
        var save = $('#enable_subordinate_save').val();
        if ($('.subordinate_checkAll:checked').length > 0) {
            $('.subor_checkbox').prop('checked', true);
            $('#delSubordinate').removeClass('opacity5');
            $('#delSubordinate').removeClass('none-pointer');
            $('#subordinate_list .employeeInput').attr('readonly', false);
            $('#subordinate_list .employeeInput').css("pointer-events", "");
            if (save == 0) {
                $('.subordinate_submit').removeClass('opacity5');
                $('.subordinate_submit').removeClass('none-pointer');
            }
        } else {
            $('.subor_checkbox').prop('checked', false);
            $('#delSubordinate').addClass('opacity5');
            $('#delSubordinate').addClass('none-pointer');
            $('#subordinate_list .employeeInput').attr('readonly', 'readonly');
            $('#subordinate_list .employeeInput').css("pointer-events", "none");
            if (save == 0) {
                $('.subordinate_submit').addClass('opacity5');
                $('.subordinate_submit').addClass('none-pointer');
            }
        }
    }

    $(document).on('click', '.subor_checkbox', function () {
        if ($('.subor_checkbox:checked').length == $('.subor_checkbox').length) {
            $('.subordinate_checkAll').prop('checked', true);
        } else {
            $('.subordinate_checkAll').prop('checked', false);
        }

        var design_check = $('.subor_checkbox:checkbox:checked').length;
        var save = $('#enable_subordinate_save').val();
        if (design_check > 0) {
            $('#delSubordinate').removeClass('opacity5');
            $('#delSubordinate').removeClass('none-pointer');
            if (save == 0) {
                $('.subordinate_submit').removeClass('opacity5');
                $('.subordinate_submit').removeClass('none-pointer');
            }
        } else {
            $('#delSubordinate').addClass('opacity5');
            $('#delSubordinate').addClass('none-pointer');
            if (save == 0) {
                $('.subordinate_submit').addClass('opacity5');
                $('.subordinate_submit').addClass('none-pointer');
            }
        }

        $('#subordinate_form .subor_checkbox').each(function () {
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

    $(document).on('click', '#delSubordinate', function () {
        $('#delCount').val('');
        var sel_item = $(".subor_checkbox:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0) {
            $('#deletemodal').modal('show');
            $('.deleteRecord').attr('id', 'delete_subordinate');
        }
    });

    $(document).on('click', '#delete_subordinate', function () {
        var vals = $('.subor_checkbox:checkbox:checked').map(function () {
            return this.value;
        }).get().join(',');
        var del_id = vals.split(',');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/user/deleteUserData",
            data: {
                id: del_id,
                table: 'hr_user_reporting',
                field: 'status'
            },
            dataType: 'json',
            success: function (msg) {
                $('#deletemodal').modal('hide');
                location.reload();
            }
        });
    });

    function loadSupEmployee(id, emp) {
        $('#supervisor_report_' + id).val(emp);
    }

    $(document).on('click', '#addMore', function () {
        $('.supervisor_submit').removeClass('opacity5');
        $('.supervisor_submit').removeClass('none-pointer');
    });

    function loadSuborEmployee(id, emp) {
        $('#subordinate_report_' + id).val(emp);
    }

    $(document).on('click', '#addSubordinate', function () {
        $('.subordinate_submit').removeClass('opacity5');
        $('.subordinate_submit').removeClass('none-pointer');
    });

    $(document).on('click', '#addMore', function () {
        var dyn = $(".supervisor_more").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="supervisor_tr_' + i + '" class="supervisor_more"><input type="hidden" name="report_sup[]" value="" /><td class="valign-center"><input class="form-control sup_checkbox" type="checkbox" name="supervisor_id[]" id="supervisor_id_' + i + '" value=""></td>';
        datas += '<td><input class="form-control" type="text" name="supervisor_report[]" id="supervisor_report_' + i + '" placeholder="Employee ID" disabled value=""></td>';
        datas += '<td><select class="form-control" name="supervisor_employee[]" id="supervisor_employee_' + i + '"  onchange="loadSupEmployee(' + i + ',this.value);"><option value="">-Select-</option><?php
        foreach ($employee_list as $e_name) {
            ?> <option value="<?php echo $e_name['id']; ?>" <?= $selected; ?> ><?php echo $e_name['emp_name']; ?></option> <?php } ?></select></td>';
            datas += '<td><select class="form-control" name="supervisor_method[]" id="supervisor_method_' + i + '"><option value="">-Select-</option><option value="1">Direct</option><option value="2">Indirect</option></select></td></tr>';
            $(datas).insertBefore($('#supervisor_tr_1'));
            $('#enable_supervisor_save').val('1');
            $('#noSupervisorDataMsg').hide();
            $('.supervisor_checkAll').show();
        });

    $(document).on('click', '#addSubordinate', function () {
        var dyn = $(".subordinate_more").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="subordinate_tr_' + i + '" class="subordinate_more"><input type="hidden" name="report_subor[]" value="" /><td class="valign-center"><input class="form-control subor_checkbox" type="checkbox" name="subordinate_id[]" id="subordinate_id_' + i + '" value=""></td>';
        datas += '<td><input class="form-control" type="text" name="subordinate_report[]" id="subordinate_report_' + i + '" placeholder="Employee ID" disabled value=""></td>';
        datas += '<td><select class="form-control" name="subordinate_employee[]" id="subordinate_employee_' + i + '" onchange="loadSuborEmployee(' + i + ',this.value);"><option value="">-Select-</option><?php
        foreach ($employee_list as $e_name) {
            ?> <option value="<?php echo $e_name['id']; ?>" <?= $selected; ?> ><?php echo $e_name['emp_name']; ?></option> <?php } ?></select></td>';
            datas += '<td><select class="form-control" name="subordinate_method[]" id="subordinate_method_' + i + '"><option value="">-Select-</option><option value="1">Direct</option><option value="2">Indirect</option></select></td></tr>';
            $(datas).insertBefore($('#subordinate_tr_1'));
            $('#enable_subordinate_save').val('1');
            $('#noSubordinateDataMsg').hide();
            $('.subordinate_checkAll').show();
        });

    </script>

</body>
</html>