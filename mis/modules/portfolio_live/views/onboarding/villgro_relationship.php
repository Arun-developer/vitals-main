<?php
$inv_data = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $inv_data['name_of_enterprise'];

$vil_relation = $relationDetails[0];

$company_link = base_url() . 'index.php/portfolio/company_data/' . $innovation_id;
$nature_link = base_url() . 'index.php/portfolio/business_nature/' . $innovation_id;
$mgmnt_link = base_url() . 'index.php/portfolio/management/' . $innovation_id;
$govern_link = base_url() . 'index.php/portfolio/governance/' . $innovation_id;
$increl_link = base_url() . 'index.php/portfolio/incubation_relationship/' . $innovation_id;
$cap_link = base_url() . 'index.php/portfolio/cap_table/' . $innovation_id;
$int_link = base_url() . 'index.php/portfolio/interested_parties/' . $innovation_id;
$dataconfig_link = base_url() . 'index.php/portfolio/product/' . $innovation_id;

$assign_incharge = isset($assign) && count($assign) > 0 ? $assign[0]['associate_employee'] : '';
$assign_sector = isset($lead) && count($lead) > 0 ? $lead[0]['employee_id'] : '';

$relation_id = isset($vil_relation) ? $vil_relation['id'] : '';
$managerName = isset($vil_relation) ? $vil_relation['manager'] : $assign_incharge;
$seniorName = isset($vil_relation) ? $vil_relation['senior'] : $assign_sector;
$memberName = isset($vil_relation) ? $vil_relation['member'] : '';
$observerName = isset($vil_relation) ? $vil_relation['observer'] : '';

$vil_mentor = $mentorDetails[0];
$mentorDetails_count = isset($vil_mentor) ? count($mentorDetails) : 1;
$reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Info', 'company_name' => $company_name, 'port_action' => 'plan', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'add_class' => 'mar-tp140'));
?>

<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <div id="deleteMsg" class="msg hidden_cls text-success text-center"><strong><i class="fas fa-check-circle"></i></strong>&nbsp;Record(s) deleted successfully</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link filled-data" id="nav-Companymaster-tab" href="<?= $company_link; ?>" aria-selected="false">Company Master Data</a>
                        <a class="nav-item nav-link filled-data" id="nav-business-tab" href="<?= $nature_link; ?>" aria-controls="nav-business" aria-selected="false">Nature of Business</a>
                        <a class="nav-item nav-link filled-data" id="nav-management-tab" href="<?= $mgmnt_link; ?>"  aria-controls="nav-management" aria-selected="false">Management</a>
                        <a class="nav-item nav-link filled-data" id="nav-governance-tab" href="<?= $govern_link; ?>" aria-controls="nav-governance" aria-selected="false">Governance</a>
                        <a class="nav-item nav-link active" id="nav-relationship-tab"  aria-controls="nav-relationship" aria-selected="true">05</a>
                        <a class="nav-item nav-link" id="nav-incubation-tab" href="<?= $increl_link; ?>" aria-controls="nav-incubation" aria-selected="true">Incubation Relationship</a>
                        <a class="nav-item nav-link" id="nav-cap-tab" href="<?= $cap_link; ?>" aria-controls="nav-cap" aria-selected="false">Cap Table</a>
                        <a class="nav-item nav-link" id="nav-interested-tab" href="<?= $int_link; ?>" aria-controls="nav-interested" aria-selected="false">Other Interested Parties</a>
                        <a class="nav-item nav-link brd-none bg-trasnparent" id="nav-about-tab"  href="#nav-about"  aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                        <a class="nav-item nav-link dataconfig_btn" id="nav-dataconfig-tab" href="<?= $dataconfig_link; ?>" role="tab" aria-controls="nav-dataconfig" aria-selected="false">Plan Setup</a>
                    </div>
                </nav>
                <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-Companymaster" role="tabpanel" aria-labelledby="nav-Companymaster-tab">
                        <div class="tabpanel-title">
                            <div class="row">
                                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-12">
                                    <h4>Villgro Relationship Details</h4>
                                </div>
                                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12 text-right">
                                <ul class="milestone-links">
                                    <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                        
                                            <li class="brd-left-onboard">
                                                <a href="javascript:void(0)" id="edit_cmpny"><i class="fas fa-pencil-alt"></i> Edit</a>
                                            </li>
                                            <li class="brd-left-onboard">
                                                <a class="saveContinue" href="javascript:void(0)">Save</a>
                                            </li>
                                        
                                    <?php } ?>
                                    <li>
                                            <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend" style="font-size: 15px !important;text-decoration: underline;"><i class="far fa-question-circle"></i>&nbsp;M&E SOP - Click here</a>
                                        </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <form id="villgroForm" method="POST" action="<?php echo base_url() . 'index.php/portfolio/addVillgro'; ?>" autocomplete="off" enctype="multipart/form-data">
                            <input type='hidden' name='innovation_id' value="<?= $innovation_id; ?>">
                            <input type='hidden' name='relation_id' value="<?= $relation_id; ?>">
                            <div class="pad_20 relation-details">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <ul class="milestone-links">
                                            <li class="valigntop">
                                                <h6>Villgro Portfolio Manager<span class="text-danger">*</span></h6>
                                            </li>
                                            <li>
                                                <div class="form-group">
                                                    <select class="form-control form-control-sm" name="manager_name">
                                                        <option value="">-Select-</option>
                                                        <?php
                                                        foreach ($emp_details as $emps) {
                                                            if ($managerName == $emps['emp_number']) {
                                                                $selected = 'selected';
                                                            } else {
                                                                $selected = '';
                                                            }
                                                            ?>
                                                            <option value="<?php echo $emps['emp_number']; ?>" <?= $selected; ?> ><?php echo $emps['emp_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <ul class="milestone-links"><li class=" valigntop">
                                                <h6>Villgro Lead/Senior<span class="text-danger">*</span></h6></li>
                                            <li>
                                                <div class="form-group">
                                                    <select class="form-control form-control-sm" name="senior_name">
                                                        <option value="">-Select-</option>
                                                        <?php
                                                        foreach ($emp_details as $emps) {
                                                            if ($seniorName == $emps['emp_number']) {
                                                                $selected = 'selected';
                                                            } else {
                                                                $selected = '';
                                                            }
                                                            ?>
                                                            <option value="<?php echo $emps['emp_number']; ?>" <?= $selected; ?> ><?php echo $emps['emp_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </li></ul>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <ul class="milestone-links"><li class="wdt198 valigntop"><h6>Villgro Board Member</h6>
                                                <small><span class="text-danger">*</span> If applicable</small>
                                            </li>
                                            <li class="valigntop"><div class="form-group">
                                                    <select class="form-control form-control-sm " name="member_name">
                                                        <option value="">-Select-</option>
                                                        <?php
                                                        foreach ($emp_details as $emps) {
                                                            if ($memberName == $emps['emp_number']) {
                                                                $selected = 'selected';
                                                            } else {
                                                                $selected = '';
                                                            }
                                                            ?>
                                                            <option value="<?php echo $emps['emp_number']; ?>" <?= $selected; ?> ><?php echo $emps['emp_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div></li></ul>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <ul class="milestone-links"><li class="wdt161 valigntop">
                                                <h6>Board Observer</h6></li>
                                            <li>
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-sm" name="observer_name" placeholder="Observer name" value="<?= $observerName; ?>">
                                                </div>
                                            </li></ul>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="tabpanel-title">
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                                            <h4>Assigned Mentors</h4>
                                        </div>
                                        <div class="col-xl-4 col-md-4 col-lg-4 col-sm-4 col-12 text-right">
                                            <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                <ul class="milestone-links">
                                                    <li class="brd-left-onboard">
                                                        <a href="javascript:void(0)" id="addMore"><i class="fas fa-plus-circle"></i> Add New</a>
                                                    </li>
                                                    <li class="brd-left-onboard">
                                                        <a href="javascript:void(0)" id="edit_mentor"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                    </li>
                                                    <li class="brd-left-onboard" id="disableBtn">
                                                        <a class="deleteControl" id="deleteBtn" href="javascript:void(0)"><i class="fas fa-trash"></i>
                                                            Delete</a>
                                                    </li>
                                                </ul>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="Diagnostic-graph plan-structure-new">
                                    <div id="accordion" class="vil-Deals table-responsive portfolio-table">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th width="2%"></th>
                                                    <th width="18%">Name of the Mentor</th>
                                                    <th width="15%">Start Date</th>
                                                    <th width="15%">End Date</th>
                                                    <th width="20%">Focus Area</th>
                                                    <th width="20%">SoW Document</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $j = 1;
                                            for ($i = 0; $i < $mentorDetails_count; $i++) {
                                                $start_date = (isset($mentorDetails[$i]['start_date']) && $mentorDetails[$i]['start_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($mentorDetails[$i]['start_date'])) : '';
                                                $end_date = (isset($mentorDetails[$i]['end_date']) && $mentorDetails[$i]['end_date'] != '0000-00-00 00:00:00') ? date('d-m-Y', strtotime($mentorDetails[$i]['end_date'])) : '';
                                                ?>
                                                <tbody class="add_more_mentor">
                                                    <tr id="mentor_tr_<?php echo $j; ?>" class="mentor_more">
                                                        <td width="2%">
                                                            <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                                <div class="input-group">
                                                                    <input type="checkbox" class="check_box" name="check_delete" value="<?= $mentorDetails[$i]['id']; ?>" aria-label="Checkbox for following text input">
                                                                </div>
                                                            <?php } ?>
                                                        </td>
                                                        <td width="18%">
                                                            <div class="form-group">
                                                                <select class="form-control form-control-sm mentorDiv" name="mentor_name[]" id="mentorID_<?php echo $i; ?>">
                                                                    <option value="">-Select-</option>
                                                                    <?php
                                                                    foreach ($emp_mentors as $emps) {
                                                                        if ($mentorDetails[$i]['name'] == $emps['emp_number']) {
                                                                            $selected = 'selected';
                                                                        } else {
                                                                            $selected = '';
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $emps['emp_number']; ?>" <?= $selected; ?> ><?php echo $emps['emp_name']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td width="15%">
                                                            <input type="text" name="start_date[]" id="startDate_<?php echo $i; ?>" placeholder="dd-mm-yyyy" value="<?= $start_date; ?>" class="startDat form-control form-control-sm dateCalendar">
                                                        </td>
                                                        <td width="15%">
                                                            <input type="text" name="end_date[]" id="endDate_<?php echo $i; ?>" placeholder="dd-mm-yyyy" value="<?= $end_date; ?>" class="endDat form-control form-control-sm dateCalendar">
                                                        </td>
                                                        <td width="20%">
                                                            <div class="form-group">
                                                                <select class="areaDiv form-control form-control-sm" name="area_name[]">
                                                                    <option value="">-Select-</option>
                                                                    <?php
                                                                    foreach ($focus_area as $area) {
                                                                        if ($mentorDetails[$i]['area'] == $area['id']) {
                                                                            $selected = 'selected';
                                                                        } else {
                                                                            $selected = '';
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $area['id']; ?>" <?= $selected; ?> ><?php echo $area['name']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td width="20%">
                                                            <div class="fileUpload blue-btn btn width100">
                                                                <?php
                                                                if (isset($mentorDetails[$i]['sow_document']) && !empty($mentorDetails[$i]['sow_document'])) {
                                                                    echo strlen($mentorDetails[$i]['sow_document']) > 20 ? "..." . substr($mentorDetails[$i]['sow_document'], -20) : $mentorDetails[$i]['sow_document'];
                                                                    ?>

                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <span><i class="fas fa-upload"></i> Upload</span>
                                                                <?php } ?>
                                                                <input type="file" class="uploadlogo" id="upLogo_<?= $j; ?>" name="sow_doc[]" />
                                                            </div>

                                                            <?php if (isset($mentorDetails[$i]['sow_document']) && !empty($mentorDetails[$i]['sow_document'])) { ?>
                                                                <span class="download-btn"><a class="old_file" data-toggle="tooltip" data-placement="top" title="Download" href="<?php echo base_url() . 'uploads/portfolio/mentor/' . $mentorDetails[$i]['sow_document']; ?>" title="Download Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                                <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                                    <span><a href="javascript:void(0)" class="delete-btnconfig" title="Delete Document" onclick="delMentor('<?= $mentorDetails[$i]['id']; ?>')" id="removeDoc"><i class="fas fa-trash"></i></a></span>
                                                                <?php } ?>
                                                            <?php } ?>
                                                            <input type="hidden" name="old_sow_doc[]" value="<?php echo $mentorDetails[$i]['sow_document']; ?>">
                                                            <input type="hidden" name="mentor_id[]" class="mentor_id" value="<?php echo isset($mentorDetails[$i]['id']) ? $mentorDetails[$i]['id'] : ''; ?>">
                                                            <input type="hidden" name="mentor_relation[]" value="<?= $mentorDetails[$i]['relation_id']; ?>">
                                                            <p class="sow_msg hidden_cls error">Invalid file</p>
                                                        </td>

                                                    </tr>

                                                </tbody>
                                                <?php
                                                $j++;
                                            }
                                            ?>
                                            <tbody id='mentor_add'></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="enableCount" value="<?= count($relationDetails); ?>">
<input type="hidden" id="enableMent" value="<?= count($mentorDetails); ?>">

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
            <div class="modal-footer">
                <input type="hidden" name="dltDoc" id="dltDoc" />
                <button type="button" class="btn btn-default portfolioclose">Cancel</button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        onLoad();
    });

    function onLoad() {
        var editOpt = $('#enableCount').val();
        var editMent = $('#enableMent').val();
        if (editOpt > 0) {
            $('.relation-details input[type="text"],.relation-details select').attr('readonly', 'readonly');
            $(".relation-details select").css("pointer-events", "none");
        }

        if (editMent > 0) {
            $('#accordion input[type="text"], #accordion select, #accordion input[type = "file"]').attr('readonly', 'readonly');
            $('#accordion select,.dateCalendar, #accordion input[type = "file"]').css("pointer-events", "none");
        } else if (editMent == 0) {
            datepickerEachFunction();
        }
        $('#edit_cmpny,#edit_mentor').addClass('opacity5');
        $('#disableBtn').css("cursor", "not-allowed");
        $('#deleteBtn').css("pointer-events", "none");
    }

    $(document).on('click', '.portfolioclose', function () {
        $('#deletemodal').modal('hide');
    });

    $(document).on('keyup', '.scopeDiv', function () {
        if (this.value.match(/[^a-zA-Z0-9]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
        }
    });

    $('#edit_cmpny').on('click', function () {
        $('.relation-details input[type="text"],.relation-details select').attr('readonly', false);
        $(".relation-details select").css("pointer-events", "");
        $('#edit_cmpny').removeClass('opacity5');
    });

    $('#edit_mentor').on('click', function () {
        $('#accordion input[type="text"], #accordion select, #accordion input[type = "file"]').attr('readonly', false);
        $('#accordion select,.dateCalendar, #accordion input[type = "file"]').css("pointer-events", "");
        $('#edit_mentor').removeClass('opacity5');
        datepickerEachFunction();
    });

    function uploadFile() {
        $(".uploadlogo").on('change', function () {
            var filename = readURL(this);
            $(this).parent().children('span').html(filename);
        });
    }

    function delMentor(mtrid) {
        $('#deletemodal').modal('show');
        $('#dltDoc').val(mtrid);
    }

    $(document).on('click', '#addMore', function () {
        var dyn = $(".mentor_more").length;
        var i = parseInt(dyn) + 1;
        var data = '<tr id="mentor_tr_' + i + '" class="mentor_more"><td width="2%"><div class="input-group"><input type="checkbox" class="check_box" name="check_delete" id="check_delete_' + i + '" value=""></div></td>';
        data += '<td width="18%"><div class="form-group"><select class="form-control form-control-sm mentorDiv" name="mentor_name[]" id="mentorID_' + i + '"><option value="">-Select-</option><?php
foreach ($emp_mentors as $emps) {
    ?> <option value="<?php echo $emps['emp_number']; ?>"><?php echo $emps['emp_name']; ?></option> <?php } ?></select></div></td>';
        data += '<td width="15%"><input type="text" name="start_date[]" id="startDate_' + (i - 1) + '" placeholder="dd-mm-yyyy" value="" class="startDat form-control form-control-sm dateCalendar"></td>';
        data += '<td width="15%"><input type="text" name="end_date[]" id="endDate_' + (i - 1) + '" placeholder="dd-mm-yyyy" value="" class="endDat form-control form-control-sm dateCalendar"></td>';
        data += '<td width="20%"><div class="form-group"><select class="form-control form-control-sm areaDiv" name="area_name[]"><option value="">-Select-</option><?php
foreach ($focus_area as $area) {
    ?> <option value="<?php echo $area['id']; ?>"><?php echo $area['name']; ?></option> <?php } ?></select></div></td>';
        data += '<td width="20%"><div class="fileUpload blue-btn btn"><span><i class="fas fa-upload"></i> Upload</span><input type="file" class="uploadlogo" id="upLogo_' + i + '" name="sow_doc[]"></div><p class="sow_msg hidden_cls error">Invalid file</p></td></tr>';

        $(data).insertAfter($('#mentor_tr_' + dyn));
        datepickerEachFunction();
    });

    $('#villgroForm').validate({
        rules: {
            manager_name: "required",
            senior_name: "required"
        },
        messages: {
            manager_name: "Please select manager name",
            senior_name: "Please select senior name"
        }
    });

    function datepickerEachFunction() {
        $('.startDat').each(function (index, value) {
            $("#startDate_" + index).datepicker({
                onSelect: function (selected) {
                    $("#startDate_" + index).datepicker("option", "dateFormat", 'mm/dd/yy');
                    $("#endDate_" + index).val('');
                    var dt = new Date(selected);
                    var dateval = dt.getDate();
                    var monthval = dt.getMonth() + 1;
                    var yearval = dt.getFullYear();
                    if (monthval < 10) {
                        monthval = "0" + monthval;
                    } else {
                        monthval = monthval;
                    }
                    if (dateval < 10) {
                        dateval = "0" + dateval;
                    } else {
                        dateval = dateval;
                    }
                    var fulldatevalue = dateval + '-' + monthval + '-' + yearval;
                    $("#startDate_" + index).val(fulldatevalue);
                    dt.setDate(dt.getDate() + 1);
                    $("#endDate_" + index).datepicker("option", {minDate: dt});
                }
//                                                                                            minDate: 0
            });
        });

        $('.endDat').each(function (index, value) {
            $("#endDate_" + index).datepicker({
                onSelect: function (selected) {
                    var dt = new Date(selected);
                    var dateval = dt.getDate();
                    var monthval = dt.getMonth() + 1;
                    var yearval = dt.getFullYear();
                    if (monthval < 10) {
                        monthval = "0" + monthval;
                    } else {
                        monthval = monthval;
                    }
                    if (dateval < 10) {
                        dateval = "0" + dateval;
                    } else {
                        dateval = dateval;
                    }
                    var fulldatevalue = dateval + '-' + monthval + '-' + yearval;
                    $("#endDate_" + index).val(fulldatevalue);
                    dt.setDate(dt.getDate() - 1);
                }
            });
        });
    }

    $(document).on('click', '.saveContinue', function (e) {
        if ($('#villgroForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#villgroForm').submit();
        }
    });

    $('#deleteBtn').on('click', function () {
        $('#deletemodal').modal('show');
        var sel_item = $("input:checkbox[name=check_delete]:checked").length;
        $('#delCount').html(sel_item);
    });

    $('.check_box').on('click', function () {
        if ($("#villgroForm input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
        }
    });

    function deleteMore() {
        $('.check_box').on('click', function () {
            if ($("#villgroForm input:checkbox:checked").length > 0) {
                $('#disableBtn').css("cursor", "pointer");
                $('#deleteBtn').css("pointer-events", "");
            } else {
                $('#disableBtn').css("cursor", "not-allowed");
                $('#deleteBtn').css("pointer-events", "none");
            }
        });
    }


    $('#deleteRecord').on('click', function () {
        var dltDoc = $('#dltDoc').val();
        if (dltDoc != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deleteMentDoc",
                data: {
                    mentr: dltDoc,
                    column: 'sow_document',
                    table: 'port_villgro_relation_mentor'
                },
                dataType: 'json',
                success: function (msg) {
                    location.reload();
//                                                                                                $('#accordion').load(location.href + ' #accordion');
//                                                                                                $('#deletemodal').modal('hide');
//                                                                                                $('#deleteMsg').show();
//                                                                                                setTimeout(function () {
//                                                                                                    onLoad();
//                                                                                                    uploadFile();
//                                                                                                }, 500);
//                                                                                                setTimeout(function () {
//                                                                                                    $('#deleteMsg').hide();
//                                                                                                }, 3000);
                }
            });
        } else {
            var deleteId = new Array();
            $("input:checkbox[name=check_delete]:checked").each(function () {
                deleteId.push($(this).val());
            });
            if ($("#villgroForm input:checkbox:checked").length > 0) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/portfolio/deleteAssignedMentorDetail",
                    data: {
                        id: deleteId,
                        table: 'port_villgro_relation_mentor'
                    },
                    dataType: 'json',
                    success: function (msg) {
                        location.reload();
//                                                                                                    $('#accordion').load(location.href + ' #accordion');
//                                                                                                    $('#deletemodal').modal('hide');
//                                                                                                    $('#deleteMsg').show();
//                                                                                                    setTimeout(function () {
//                                                                                                        onLoad();
//                                                                                                        deleteMore();
//                                                                                                    }, 500);
//                                                                                                    setTimeout(function () {
//                                                                                                        $('#deleteMsg').hide();
//                                                                                                    }, 3000);
                    }
                });
            }
        }
    });

    $(document).on('change', '.uploadlogo', function () {
        var filename = readURL(this);
        // $(this).parent().children('span').addClass('span_upload').html(filename);
        var reslt = filename.split('|*|');
        $(this).parent().children('span').html(reslt[0]);
        if (reslt[1] != '1') {
            $(this).parent().parent().children('.sow_msg').show();
            $(this).parent().parent().children('.sow_msg').text(reslt[1]);
        } else {
            $(this).parent().parent().children('.sow_msg').text('');
            $(this).parent().parent().children('.sow_msg').hide();
        }
    });

    function readURL(input) {
        var url = input.value;
        var path, filename;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        var bsize = input.files[0].size;
        var fsize = Math.round(bsize / 1024);
        if (fsize <= 10000) {
            if (input.files && input.files[0] && (ext == "pdf" || ext == "doc" || ext == "docx" || ext == "ppt" || ext == "pptx")) {
                path = $(input).val();
                filename = path.replace(/^.*\\/, "");
                return filename + '|*|1';
            } else {

                filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file';
                return filename;
            }
        } else {
            filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file size';
            return filename;
        }
    }
    $('.plan-structure-new').css({'height': (($(window).height()) - 240) + 'px'});
</script>

<style>
    .fileUpload {
        width: 80%;
    }
    .table-responsive{
        overflow-y:hidden !important;
    }
</style>

</body>
</html>
