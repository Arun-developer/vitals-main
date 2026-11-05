<?php
$inv_data = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $inv_data['name_of_enterprise'];

$company_link = base_url() . 'index.php/portfolio/company_data/' . $innovation_id;
$nature_link = base_url() . 'index.php/portfolio/business_nature/' . $innovation_id;
$mgmnt_link = base_url() . 'index.php/portfolio/management/' . $innovation_id;
$vilrel_link = base_url() . 'index.php/portfolio/villgro_relationship/' . $innovation_id;
$increl_link = base_url() . 'index.php/portfolio/incubation_relationship/' . $innovation_id;
$cap_link = base_url() . 'index.php/portfolio/cap_table/' . $innovation_id;
$int_link = base_url() . 'index.php/portfolio/interested_parties/' . $innovation_id;
$dataconfig_link = base_url() . 'index.php/portfolio/product/' . $innovation_id;
$reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];

$gov_data = $governanceDetails[0];
$governanceDetails_count = isset($gov_data) ? count($governanceDetails) : 1;
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
                           aria-controls="nav-business" aria-selected="false">Nature of Business</a>
                        <a class="nav-item nav-link filled-data" id="nav-management-tab"
                           href="<?= $mgmnt_link; ?>"
                           aria-controls="nav-management" aria-selected="false">Management</a>
                        <a class="nav-item nav-link active" id="nav-governance-tab" aria-controls="nav-governance"
                           aria-selected="true">04</a>
                        <a class="nav-item nav-link" id="nav-relationship-tab" aria-controls="nav-relationship"
                           href="<?= $vilrel_link; ?>" aria-selected="false">Villgro Relationship Details</a>
                        <a class="nav-item nav-link" id="nav-incubation-tab" aria-controls="nav-incubation"
                           href="<?= $increl_link; ?>" aria-selected="false">Incubation Relationship</a>
                        <a class="nav-item nav-link" id="nav-cap-tab" aria-controls="nav-cap"
                           href="<?= $cap_link; ?>" aria-selected="false">Cap Table</a>
                        <a class="nav-item nav-link" id="nav-interested-tab" aria-controls="nav-interested"
                           href="<?= $int_link; ?>" aria-selected="false">Other Interested Parties</a>
                        <a class="nav-item nav-link bg-trasnparent brd-none" id="nav-about-tab" href="#nav-about"
                           aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                        <a class="nav-item nav-link dataconfig_btn" id="nav-dataconfig-tab" href="<?= $dataconfig_link; ?>"
                           role="tab" aria-controls="nav-dataconfig" aria-selected="false">Plan Setup</a>
                    </div>
                </nav>
                <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                    <form id="governanceForm" method="POST" action="<?php echo base_url() . 'index.php/portfolio/addGovernance'; ?>" autocomplete="off">
                        <div class="tab-pane fade show active" id="nav-business" role="tabpanel"
                             aria-labelledby="nav-business-tab">
                            <div class="tabpanel-title">
                                <div class="row">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                                        <h4>Governance</h4>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-12 text-right">
                                    <ul class="milestone-links">
                                        <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                            
                                                <li class="brd-left-onboard">
                                                    <a href="javascript:void(0)" id="addMore"><i class="fas fa-plus-circle"></i> Add New</a>
                                                </li>
                                                <li class="brd-left-onboard">
                                                    <a href="javascript:void(0)" id="edit_cmpny"><i class="fas fa-pencil-alt"></i> Edit</a>
                                                </li>
                                                <li class="brd-left-onboard" id="disableBtn">
                                                    <a class="deleteControl" id="deleteBtn" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
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
                            <div>
                                <div class="Diagnostic-graph plan-structure-new" >
                                    <div id="accordion" class="vil-Deals portfolio-table">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th width="2%"></th>
                                                    <th width="23%">Board of Advisors<br>
                                                        <small>Members / Observers Name(s)</small></th>
                                                    <th width="15%">Mobile Number</th>
                                                    <th width="20%">Email ID</th>
                                                    <th width="25%">Representing</th>
                                                    <th width="15%"></th>
                                                </tr>
                                            </thead>

                                            <?php
                                            for ($i = 0; $i < $governanceDetails_count; $i++) {
                                                ?>

                                                <tbody class="add_more_management">
                                                    <tr>
                                                        <td width="2%">
                                                            <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                                <div class="input-group">
                                                                    <input type="checkbox" class="check_box"
                                                                           aria-label="Checkbox for following text input" name="check_delete" value="<?php echo $governanceDetails[$i]['id']; ?>">
                                                                </div>
                                                            <?php } ?>
                                                        </td>
                                                        <td width="23%">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-sm advisor" name="advisor[]" id="advisorID_<?php echo $i; ?>" value="<?php echo $governanceDetails[$i]['name']; ?>">
                                                                <span class="advisor_msg hidden_cls text-danger" id="advisor_msg_<?php echo $i; ?>">Enter name</span>
                                                            </div>
                                                        </td>
                                                        <td width="15%">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-sm mobile" name="mobile[]" maxlength="25" value="<?php echo $governanceDetails[$i]['mobile']; ?>">
                                                            </div>
                                                        </td>
                                                        <td width="20%">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-sm email" name="email[]" value="<?php echo $governanceDetails[$i]['email']; ?>">
                                                                <span class="email_msg hidden_cls text-danger" id="email_msg_<?php echo $i; ?>">Enter valid email</span>
                                                            </div>
                                                        </td>
                                                        <td width="25%">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control form-control-sm representing"
                                                                       placeholder="" name="representing[]" value="<?php echo $governanceDetails[$i]['representing']; ?>">
                                                            </div>
                                                        </td>
                                                        <td width="15%">
                                                            <input type="hidden" class="govid" name="id[]" value="<?php echo $governanceDetails[$i]['id']; ?>" >
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            <?php } ?>
                                            <tbody id='mgmt_add'></tbody>
                                        </table>
                                        <input type="hidden" name="innovation_id" value="<?php echo $innovation_id; ?>" >
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

<input type="hidden" id="enableCount" value="<?= count($governanceDetails); ?>" >

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
                <button type="button" class="btn btn-default portfolioclose">Cancel</button>
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
            $('input[type="text"]').prop('readonly', true);
        }
        $('#edit_cmpny').addClass('opacity5');
        $('#disableBtn').prop('style', "cursor: not-allowed", true);
        $('#deleteBtn').prop('style', "pointer-events: none", true);
    }
    $(document).on('click', '.portfolioclose', function () {
        $('#deletemodal').modal('hide');
    });

    $(document).on('click', '#addMore', function () {
        var i = 0;
        var datas = $('.add_more_management').html();
        $('#mgmt_add').append(datas);
        $('.advisor').each(function (key, value) {
            $('#mgmt_add').find('.advisor:last').val('').attr('readonly', false);
            $('#mgmt_add').find('.mobile:last').val('').attr('readonly', false);
            $('#mgmt_add').find('.representing:last').val('').attr('readonly', false);
            $('#mgmt_add').find('.email:last').val('').attr('readonly', false);
            $('#mgmt_add').find('.check_box:last').val('');
            $('#mgmt_add').find('.govid:last').val('');
            $("#mgmt_add").find(".advisor:last").attr('id', 'advisorID_' + i);
            $("#mgmt_add").find(".advisor_msg:last").attr('id', 'advisor_msg_' + i);
            $("#mgmt_add").find(".email_msg:last").attr('id', 'email_msg_' + i);
            i = i + 1;
        });
        var j = i - 1;
        $("#advisor_msg_" + j).hide();
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
            $('#governanceForm').submit();
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
        if ($("#governanceForm input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
        }
    });

    function deleteMore() {
        $('.check_box').on('click', function () {
            if ($("#governanceForm input:checkbox:checked").length > 0) {
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

        if ($("#governanceForm input:checkbox:checked").length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deletePortfolioDetail",
                data: {
                    id: deleteId,
                    table: 'port_governance'
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
    $('.plan-structure-new').css({'height': (($(window).height()) - 240) + 'px'});
</script>

</body>
</html>