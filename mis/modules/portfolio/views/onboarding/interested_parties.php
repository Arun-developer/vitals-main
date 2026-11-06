<?php
$inv_data = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $inv_data['name_of_enterprise'];

$company_link = base_url() . 'index.php/portfolio/company_data/' . $innovation_id;
$nature_link = base_url() . 'index.php/portfolio/business_nature/' . $innovation_id;
$mgmnt_link = base_url() . 'index.php/portfolio/management/' . $innovation_id;
$govern_link = base_url() . 'index.php/portfolio/governance/' . $innovation_id;
$vilrel_link = base_url() . 'index.php/portfolio/villgro_relationship/' . $innovation_id;
$increl_link = base_url() . 'index.php/portfolio/incubation_relationship/' . $innovation_id;
$cap_link = base_url() . 'index.php/portfolio/cap_table/' . $innovation_id;
$dataconfig_link = base_url() . 'index.php/portfolio/product/' . $innovation_id;
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
                        <a class="nav-item nav-link filled-data" id="nav-Companymaster-tab"
                           href="<?= $company_link; ?>"
                           aria-selected="false">Company Master Data</a>
                        <a class="nav-item nav-link filled-data" id="nav-business-tab"
                           href="<?= $nature_link; ?>"
                           aria-controls="nav-business" aria-selected="false">Nature of Business</a>
                        <a class="nav-item nav-link filled-data" id="nav-management-tab"
                           href="<?= $mgmnt_link; ?>"
                           aria-controls="nav-management" aria-selected="false">Management</a>
                        <a class="nav-item nav-link filled-data" id="nav-governance-tab"
                           href="<?= $govern_link; ?>"
                           aria-controls="nav-governance" aria-selected="false">Governance</a>
                        <a class="nav-item nav-link filled-data" id="nav-relationship-tab"
                           href="<?= $vilrel_link; ?>"
                           aria-controls="nav-relationship" aria-selected="false">Villgro Relationship Details</a>
                        <a class="nav-item nav-link filled-data" id="nav-incubation-tab"
                           href="<?= $increl_link; ?>"
                           aria-controls="nav-incubation" aria-selected="false">Incubation Relationship</a>
                        <a class="nav-item nav-link filled-data" id="nav-cap-tab"
                           href="<?= $cap_link; ?>"
                           aria-controls="nav-cap" aria-selected="false">Cap Table</a>
                        <a class="nav-item nav-link active" id="nav-interested-tab" aria-controls="nav-interested"
                           aria-selected="true">08</a>
                        <a class="nav-item nav-link bg-trasnparent brd-none" id="nav-about-tab" href="#nav-about"
                           aria-controls="nav-about" aria-selected="false">&nbsp;</a>
                        <a class="nav-item nav-link dataconfig_btn" id="nav-dataconfig-tab"
                           href="<?= $dataconfig_link; ?>"
                           role="tab" aria-controls="nav-dataconfig" aria-selected="false">Plan Setup</a>
                    </div>
                </nav>
                <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                    <form id="otherInterestsForm" method="POST"
                          action="<?php echo base_url() . 'index.php/portfolio/addInterestedParties'; ?>"
                          autocomplete="off">
                        <div class="tab-pane fade show active" id="nav-business" role="tabpanel"
                             aria-labelledby="nav-business-tab">
                            <div class="tabpanel-title">
                                <div class="row">
                                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-7">
                                        <h4>Other Interested Parties</h4>
                                    </div>
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12 text-right">
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
                                                    <a class="saveContinue" href="javascript:void(0)">Save</a>
                                                </li>
                                            
                                        <?php } ?>
                                        <li><a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend" style="font-size: 15px !important;text-decoration: underline;"><i class="far fa-question-circle"></i>&nbsp;M&E SOP - Click here</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="Diagnostic-graph plan-structure-new">
                                <div id="accordion" class="vil-Deals table-responsive portfolio-table">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="2%"></th>
                                                <th class="text-center" width="4%">S.No</th>
                                                <th width="20%">Name</th>
                                                <th width="20%">Nature of Relationship</th>
                                                <th width="24%">Comments</th>
                                                <th width="30%"></th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $recordCount = isset($otherInterests[0]) ? php72_count($otherInterests) : 1;
                                        for ($i = 0; $i < $recordCount; $i++) {
                                            ?>
                                            <tbody class="add_more_interests">
                                                <tr>
                                                    <td width="2%">
                                                        <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                            <div class="input-group">
                                                                <input type="checkbox" class="check_box" name="check_delete"
                                                                       value="<?php echo $otherInterests[$i]['id']; ?>"
                                                                       aria-label="Checkbox for following text input">
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="serial_index text-center"><?php echo $i + 1; ?></td>
                                                    <td width=" 20%">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control form-control-sm name"
                                                                   name="name[]" id="nameID_<?php echo $i; ?>" maxlength="50"
                                                                   value="<?php echo $otherInterests[$i]['name']; ?>">
                                                            <span class="name_msg hidden_cls text-danger" id="name_msg_<?php echo $i; ?>">Enter name</span>
                                                        </div>
                                                    </td>
                                                    <td width="15%">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control form-control-sm relation"
                                                                   name="relation[]" id="relationID_<?php echo $i; ?>" maxlength="50"
                                                                   value="<?php echo $otherInterests[$i]['relation']; ?>">
                                                            <span class="relation_msg hidden_cls text-danger" id="relation_msg_<?php echo $i; ?>">Enter relation</span>
                                                        </div>
                                                    </td>
                                                    <td width="20%">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control form-control-sm comments"
                                                                   placeholder="Add Comments" name="comments[]"  maxlength="100"
                                                                   value="<?php echo $otherInterests[$i]['comments']; ?>">
                                                        </div>
                                                    </td>
                                                    <td width="35%">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <input type="hidden" name="id[]"
                                                   value="<?php echo $otherInterests[$i]['id']; ?>" />
                                                   <?php
                                               }
                                               ?>
                                        <tbody id='other_interests_add'></tbody>
                                        <input type="hidden" name="innovation_id"
                                               value="<?php echo $innovation_id; ?>" />
                                    </table>
                                    <input type="hidden" id="enableCount" value="<?= php72_count($otherInterests); ?>">
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (php72_cmp($this->session->userdata('interest')) == 1 && php72_cmp($app_plan[0]['innovation']) == 0) { ?>
    <div class="modal" id="exampleModal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content data_congifpopup">
                <div class="modal-header text-center">
                    <h5 class="modal-title text-center" id="exampleModalLabel"><span class="text-success"><i
                                class="fas fa-check-circle"></i></span> Portfolio Onboarded Successfully</h5>
                </div>
                <div class="modal-body onboarding-permission text-center">
                    <ul>
                        <li>You have successfully onboarded "<strong><span>
                                    <?php
                                    echo ucfirst($company_name) . ', ';
                                    if ($reg_city != '') {
                                        echo ucfirst($reg_city) . ', ';
                                    }
                                    if ($sector_name != '') {
                                        echo ucfirst($sector_name);
                                    }
                                    ?>
                                </span></strong>"</li>
                    </ul>
                    <div class="popup-content-final popup-content">
                        <a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Later</a>
                        <a class="btn btn-configure " href="<?= base_url() . 'index.php/portfolio/product/' . $innovation_id; ?>" >Set-up plan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $this->session->unset_userdata('interest');
}
?>

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
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_load' => 'portfolio')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#exampleModal').modal('show');
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
        var datas = $('.add_more_interests').html();
        $('#other_interests_add').append(datas);
        var i = 0;
        $('.name').each(function (key, value) {
            $('#other_interests_add').find('.name:last').val('').attr('readonly', false);
            $('#other_interests_add').find('.relation:last').val('').attr('readonly', false);
            $('#other_interests_add').find('.comments:last').val('').attr('readonly', false);
            $('#other_interests_add').find('.check_box:last').val('');
            $("#other_interests_add").find(".name:last").attr('id', 'founderID_' + i);
            $("#other_interests_add").find(".name_msg:last").attr('id', 'name_msg_' + i);
            $("#other_interests_add").find(".relation:last").attr('id', 'relationID_' + i);
            $("#other_interests_add").find(".relation_msg:last").attr('id', 'relation_msg_' + i);
            $('#other_interests_add').find('.serial_index:last').html(i + 1);
            i = i + 1;
        });
        var j = i - 1;
        $("#name_msg_" + j).hide();
        $("#relation_msg_" + j).hide();
    });

    $(document).on('click', '.saveContinue', function (e) {
        if ($('#otherInterestsForm').valid()) {
            $('.saveContinue').css('pointer-events', 'none');
            $('#otherInterestsForm').submit();
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
        if ($("#otherInterestsForm input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
        }
    });

    function deleteMore() {
        $('.check_box').on('click', function () {
            if ($("#otherInterestsForm input:checkbox:checked").length > 0) {
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

        if ($("#otherInterestsForm input:checkbox:checked").length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deletePortfolioDetail",
                data: {
                    id: deleteId,
                    table: 'port_other_interest'
                },
                dataType: 'json',
                success: function (msg) {
                    $('#accordion').load(location.href + ' #accordion');
                    $('#deletemodal').modal('hide');
                    $('#exampleModal').modal('hide');
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