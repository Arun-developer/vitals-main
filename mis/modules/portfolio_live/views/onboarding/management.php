<?php
$inv_data = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $inv_data['name_of_enterprise'];

$company_link = base_url() . 'index.php/portfolio/company_data/' . $innovation_id;
$nature_link = base_url() . 'index.php/portfolio/business_nature/' . $innovation_id;
$govern_link = base_url() . 'index.php/portfolio/governance/' . $innovation_id;
$vilrel_link = base_url() . 'index.php/portfolio/villgro_relationship/' . $innovation_id;
$increl_link = base_url() . 'index.php/portfolio/incubation_relationship/' . $innovation_id;
$cap_link = base_url() . 'index.php/portfolio/cap_table/' . $innovation_id;
$int_link = base_url() . 'index.php/portfolio/interested_parties/' . $innovation_id;
$dataconfig_link = base_url() . 'index.php/portfolio/product/' . $innovation_id;
$reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];

$mgmt_data = $managementDetails[0];
$mgmtdd_data = $get_mgdd[0];

$managementDetails_count = isset($mgmt_data) ? count($managementDetails) : 1;
$mgdd_count = isset($mgmtdd_data) ? count($get_mgdd) : 1;
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
                        <a class="nav-item nav-link filled-data" id="nav-Companymaster-tab"
                           href="<?= $company_link; ?>"
                           aria-selected="false">Company Master Data</a>
                        <a class="nav-item nav-link filled-data" id="nav-business-tab"
                           href="<?= $nature_link; ?>"
                           aria-controls="nav-business" aria-selected="false">Nature
                            of Business</a>
                        <a class="nav-item nav-link active" id="nav-management-tab" aria-controls="nav-management"
                           aria-selected="true">03</a>
                        <a class="nav-item nav-link" id="nav-governance-tab" href="<?= $govern_link; ?>" aria-controls="nav-governance"
                           aria-selected="false">Governance</a>
                        <a class="nav-item nav-link" id="nav-relationship-tab" href="<?= $vilrel_link; ?>" aria-controls="nav-relationship"
                           aria-selected="false">Villgro Relationship Details</a>
                        <a class="nav-item nav-link" id="nav-incubation-tab" href="<?= $increl_link; ?>" aria-controls="nav-incubation"
                           aria-selected="false">Incubation Relationship</a>
                        <a class="nav-item nav-link" id="nav-cap-tab" aria-controls="nav-cap" href="<?= $cap_link; ?>"
                           aria-selected="false">Cap Table</a>
                        <a class="nav-item nav-link" id="nav-interested-tab" aria-controls="nav-interested" href="<?= $int_link; ?>"
                           aria-selected="false">Other Interested Parties</a>
                        <a class="nav-item nav-link bg-trasnparent brd-none" id="nav-about-tab" href="#nav-about"
                           aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                        <a class="nav-item nav-link dataconfig_btn" id="nav-dataconfig-tab" href="<?= $dataconfig_link; ?>"
                           role="tab" aria-controls="nav-dataconfig" aria-selected="false">Plan Setup</a>
                    </div>
                </nav>
                <div class="tab-content px-3 px-sm-0" id="nav-tabContent">
                    <form id="managementForm" method="POST" action="<?php echo base_url() . 'index.php/portfolio/addManagement'; ?>" autocomplete="off">
                        <div class="tab-pane fade show active" id="nav-business" role="tabpanel"
                             aria-labelledby="nav-business-tab">
                            <div class="tabpanel-title">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                                        <h4>Management</h4>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-12 text-right">
                                    <ul class="milestone-links">
                                        <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                            
                                                <li class="brd-left-onboard">
                                                    <a href="javascript:void(0)" id="addMore"><i class="fas fa-plus-circle"></i> Add
                                                        New</a>
                                                </li>
                                                <li class="brd-left-onboard">
                                                    <a href="javascript:void(0)" id="edit_cmpny"><i
                                                            class="fas fa-pencil-alt"></i> Edit</a>
                                                </li>
                                                <li class="brd-left-onboard" id="disableBtn">
                                                    <a class="deleteControl" id="deleteBtn" href="javascript:void(0)"><i class="fas fa-trash"></i>
                                                        Delete</a>
                                                </li>
                                                <li class="brd-left-onboard">
                                                    <a href='javascript:void(0)' class="saveContinue" >Save</a>
                                                </li>
                                            
                                        <?php } ?>
                                        <li>
                                            <a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend" style="font-size: 15px !important;text-decoration: underline;"><i class="far fa-question-circle"></i>&nbsp;M&E SOP - Click here</a>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="Diagnostic-graph plan-structure-new">
                                    <div id="accordion">
                                        <div class="vil-Deals table-responsive portfolio-table ">
                                            <table class="table table-fixed">
                                                <thead>
                                                    <tr>
                                                        <th width="3%"></th>
                                                        <th width="22%">Founders / Management Names</th>
                                                        <th width="15%">Mobile Number</th>
                                                        <th width="20%">Email</th>
                                                        <th width="15%">Location</th>
                                                        <th width="25%">Designation / Responsibility</th>
                                                    </tr>
                                                </thead>
                                                <div>
                                                    <tbody id='mgmt_add' class="plan-structure-new">
                                                        <?php
                                                        if (count($managementDetails) != 0) {
                                                            $j = 1;
                                                            for ($i = 0; $i < $managementDetails_count; $i++) {
                                                                ?>

                                                                <tr id="management_tr_<?php echo $j; ?>" class="add_more_management">
                                                                    <td width="3%">
                                                                        <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                                            <div class="input-group">
                                                                                <input type="checkbox" class="check_box"
                                                                                       aria-label="Checkbox for following text input"
                                                                                       name="check_delete" id="check_delete_<?php echo $j; ?>"
                                                                                       value="<?php echo $managementDetails[$i]['id']; ?>">
                                                                            </div>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td width="22%">
                                                                        <div class="form-group">
                                                                            <input type="text"
                                                                                   class="founder form-control form-control-sm"
                                                                                   name="founder[]" id="founderID_<?php echo $j; ?>"
                                                                                   value="<?php echo $managementDetails[$i]['name']; ?>">
                                                                            <span class="founder_msg hidden_cls text-danger" id="founder_msg_<?php echo $j; ?>">Enter name</span>
                                                                        </div>
                                                                    </td>
                                                                    <td width="15%">
                                                                        <div class="form-group">
                                                                            <input type="text" id="mobile"
                                                                                   class="mobile form-control form-control-sm" id="mobile_<?php echo $j; ?>"
                                                                                   name="mobile[]" maxlength="25"
                                                                                   value="<?php echo $managementDetails[$i]['mobile']; ?>">
                                                                        </div>
                                                                    </td>
                                                                    <td width="20%">
                                                                        <div class="form-group">
                                                                            <input type="text"
                                                                                   class="email form-control form-control-sm"
                                                                                   name="email[]" id="email_<?php echo $j; ?>" value="<?php echo $managementDetails[$i]['email']; ?>">
                                                                            <span class="email_msg hidden_cls text-danger" id="email_msg_<?php echo $j; ?>">Enter valid email</span>
                                                                        </div>
                                                                    </td>
                                                                    <td width="15%">
                                                                        <div class="form-group">
                                                                            <input type="text"
                                                                                   class="location form-control form-control-sm"
                                                                                   name="location[]" id="location_<?php echo $j; ?>"
                                                                                   value="<?php echo $managementDetails[$i]['location']; ?>">
                                                                        </div>
                                                                    </td>
                                                                    <td width="25%">
                                                                        <div class="form-group">
                                                                            <input type="text"
                                                                                   class="designation form-control form-control-sm"
                                                                                   name="designation[]" id="designation_<?php echo $j; ?>"
                                                                                   value="<?php echo $managementDetails[$i]['designation']; ?>">
                                                                        </div>
                                                                    </td>
                                                            <input type="hidden" name="id[]" value="<?php echo $managementDetails[$i]['id']; ?>" />
                                                            </tr>

                                                            <?php
                                                            $j++;
                                                        }
                                                    } else {
                                                        $j = 1;
                                                        for ($i = 0; $i < $mgdd_count; $i++) {
                                                            ?>
                                                            <tr id="management_tr_<?php echo $j; ?>" class="add_more_management">
                                                                <td width="3%">
                                                                    <div class="input-group">
                                                                        <input type="checkbox" class="check_box"
                                                                               aria-label="Checkbox for following text input"
                                                                               name="check_delete" id="check_delete_<?php echo $j; ?>"
                                                                               value="<?php echo $get_mgdd[$i]['id']; ?>">
                                                                    </div>
                                                                </td>
                                                                <td width="22%">
                                                                    <div class="form-group">
                                                                        <input type="text"
                                                                               class="founder form-control form-control-sm"
                                                                               name="founder[]" id="founderID_<?php echo $j; ?>"
                                                                               value="<?php echo $get_mgdd[$i]['name']; ?>">
                                                                        <span class="founder_msg hidden_cls text-danger" id="founder_msg_<?php echo $j; ?>">Enter name</span>
                                                                    </div>
                                                                </td>
                                                                <td width="15%">
                                                                    <div class="form-group">
                                                                        <input type="text" id="mobile"
                                                                               class="mobile form-control form-control-sm"
                                                                               name="mobile[]" id="mobile_<?php echo $j; ?>" maxlength="25"
                                                                               value="<?php echo $get_mgdd[$i]['mobile']; ?>">
                                                                    </div>
                                                                </td>
                                                                <td width="20%">
                                                                    <div class="form-group">
                                                                        <input type="text"
                                                                               class="email form-control form-control-sm"
                                                                               name="email[]" id="email_<?php echo $j; ?>" value="<?php echo $get_mgdd[$i]['email']; ?>">
                                                                        <span class="email_msg hidden_cls text-danger" id="email_msg_<?php echo $j; ?>">Enter valid email</span>
                                                                    </div>
                                                                </td>
                                                                <td width="15%">
                                                                    <div class="form-group">
                                                                        <input type="text"
                                                                               class="location form-control form-control-sm"
                                                                               name="location[]" id="location_<?php echo $j; ?>"
                                                                               value="<?php echo $get_mgdd[$i]['location']; ?>">
                                                                    </div>
                                                                </td>
                                                                <td width="25%">
                                                                    <div class="form-group">
                                                                        <input type="text"
                                                                               class="designation form-control form-control-sm"
                                                                               name="designation[]" id="designation_<?php echo $j; ?>"
                                                                               value="<?php echo $get_mgdd[$i]['design']; ?>">
                                                                    </div>
                                                                </td>
                                                            <input type="hidden" name="id[]" value="" />
                                                            </tr>

                                                            <?php
                                                            $j++;
                                                        }
                                                    }
                                                    ?>
                                                    </tbody>
                                            </table>
                                            <input type="hidden" name="innovation_id" value="<?php echo $innovation_id; ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="enableCount" value="<?= count($managementDetails); ?>">

<!-- Model (Delete and select) -->
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
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio')); ?>

<script type="text/javascript">
    function isEmail(email) {
        var regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return regex.test(email);
    }

    $(document).on('keyup', '.mobile', function () {
        if (this.value.match(/[^0-9()+\- ]/g)) {
            this.value = this.value.replace(/[^0-9()+\- ]/g, '');
        }
    });

    $(document).ready(function () {
        onLoad();
    });

    function onLoad() {
        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('input[type="text"]').attr('readonly', 'readonly');
        }
        $('#edit_cmpny').addClass('opacity5');
        $('#disableBtn').css("cursor", "not-allowed");
        $('#deleteBtn').css("pointer-events", "none");
    }

    $(document).on('click', '#addMore', function () {
        var dyn = $(".add_more_management").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="management_tr_' + i + '" class="add_more_management"><td width="3%"><div class="input-group"><input type="checkbox" class="check_box" aria-label="Checkbox for following text input" name="check_delete" id="check_delete_' + i + '" value=""></div></td><td width="22%">';
        datas += '<div class="form-group"><input type="text" class="founder form-control form-control-sm" name="founder[]" id="founderID_' + i + '" value=""><span class="founder_msg hidden_cls text-danger" id="founder_msg_' + i + '">Enter name</span></div>';
        datas += '</td><td width="15%"><div class="form-group"><input type="text" id="mobile_' + i + '" class="mobile form-control form-control-sm" name="mobile[]" maxlength="25" value=""></div></td><td width="20%"><div class="form-group"><input type="text" class="email form-control form-control-sm" name="email[]" id="email_' + i + '" value=""><span class="email_msg hidden_cls text-danger" id="email_msg_' + i + '">Enter valid email</span></div></td>';
        datas += '<td width="15%"><div class="form-group"><input type="text" class="location form-control form-control-sm" name="location[]" id="location_' + i + '" value=""></div></td><td width="25%"><div class="form-group"><input type="text" class="designation form-control form-control-sm" name="designation[]" id="designation_' + i + '" value=""></div></td><input type="hidden" name="id[]" value=""></tr>';
        $(datas).insertAfter($('#management_tr_' + dyn));
    });

    $(document).on('click', '.saveContinue', function (e) {
        var err = 0;
        var html;
        $('.email').each(function () {
            var email = this.value;
            if (!isEmail(email)) {
                html = $(this).next('.email_msg').show();
                err = 1;
                return false;
            } else {
                html = $(this).next('.email_msg').hide();
            }
        });
        if (err == 0) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#managementForm').submit();
        }
    });

    $('#edit_cmpny').on('click', function () {
        $('input[type="text"]').attr('readonly', false);
        $('#edit_cmpny').removeClass('opacity5');
    });

    $('#deleteBtn').on('click', function () {
        $('#deletemodal').modal('show');
        var sel_item = $("input:checkbox[name=check_delete]:checked").length;
        $('#delCount').html(sel_item);
    });

    $('.check_box').on('click', function () {
        if ($("#managementForm input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
        }
    });

    function deleteMore() {
        $('.check_box').on('click', function () {
            if ($("#managementForm input:checkbox:checked").length > 0) {
                $('#disableBtn').css("cursor", "pointer");
                $('#deleteBtn').css("pointer-events", "");
            } else {
                $('#disableBtn').css("cursor", "not-allowed");
                $('#deleteBtn').css("pointer-events", "none");
            }
        });
    }

    $('#deleteRecord').on('click', function () {
        var deleteId = new Array();
        $("input:checkbox[name=check_delete]:checked").each(function () {
            deleteId.push($(this).val());
        });

        if ($("#managementForm input:checkbox:checked").length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deletePortfolioDetail",
                data: {
                    id: deleteId,
                    table: 'port_management'
                },
                dataType: 'json',
                success: function (msg) {
                    $('#accordion').load(location.href + ' #accordion');
                    $('#deletemodal').modal('hide');
                    $('#deleteMsg').show();
                    setTimeout(function () {
                        onLoad();
                        deleteMore();
                    }, 500);
                    setTimeout(function () {
                        $('#deleteMsg').hide();
                    }, 3000);
                }
            });
        }
    });
//            $('.plan-structure-new').css({'height': (($(window).height()) - 240) + 'px'});
</script>

</body>
</html>
