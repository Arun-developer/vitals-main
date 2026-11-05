<?php
$inv_data = $get_innovation[0];
$master_data = $company_data[0];
$company_name = isset($master_data) ? $master_data['name'] : $inv_data['name_of_enterprise'];
$incubation = $villgro_incubation[0];

$company_link = base_url() . 'index.php/portfolio/company_data/' . $innovation_id;
$nature_link = base_url() . 'index.php/portfolio/business_nature/' . $innovation_id;
$mgmnt_link = base_url() . 'index.php/portfolio/management/' . $innovation_id;
$govern_link = base_url() . 'index.php/portfolio/governance/' . $innovation_id;
$vilrel_link = base_url() . 'index.php/portfolio/villgro_relationship/' . $innovation_id;
$cap_link = base_url() . 'index.php/portfolio/cap_table/' . $innovation_id;
$int_link = base_url() . 'index.php/portfolio/interested_parties/' . $innovation_id;
$dataconfig_link = base_url() . 'index.php/portfolio/product/' . $innovation_id;

$initial = isset($incubation) ? $incubation['initial_agreement'] : '';
$tap = isset($incubation) ? $incubation['tap_agreement'] : '';
$mentor = isset($incubation) ? $incubation['mentor_agreement'] : '';
$exit = isset($incubation) ? $incubation['exit_letter'] : '';
$comment = isset($incubation) ? $incubation['description_one'] : '';
$other = isset($incubation) ? $incubation['description_two'] : '';

$iniAgree = json_decode($initial);
$tapAgree = json_decode($tap);
$menAgree = json_decode($mentor);
$exitAgree = json_decode($exit);
$cmtAgree = json_decode($comment);
$othAgree = json_decode($other);
$reg_city = isset($master_data) ? $master_data['reg_city'] : $innovation['city'];
$this->load->view('vitals_header.php', array('main_menu' => 'portfolio', 'page_title' => $company_name . ' - Info', 'company_name' => $company_name, 'port_action' => 'plan', 'reg_city' => $reg_city, 'sector_name' => $sector_name, 'inv_id' => $innovation_id, 'add_class' => 'mar-tp140'));
?>

<!-- Inner Dashboard-->
<div class="vi-dashboard onboardtabmenu mar-tp10">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link filled-data" id="nav-Companymaster-tab"
                           href="<?= $company_link; ?>" aria-selected="false" role="tab">Company Master Data</a>
                        <a class="nav-item nav-link filled-data" id="nav-business-tab" href="<?= $nature_link; ?>"
                           aria-controls="nav-business-tab" aria-selected="false" role="tab">Nature of Business</a>
                        <a class="nav-item nav-link filled-data" id="nav-management-tab" href="<?= $mgmnt_link; ?>"
                           aria-controls="nav-management-tab" aria-selected="false" role="tab">Management</a>
                        <a class="nav-item nav-link filled-data" id="nav-governance-tab" href="<?= $govern_link; ?>"
                           aria-controls="nav-governance-tab" aria-selected="false" role="tab">Governance</a>
                        <a class="nav-item nav-link filled-data" id="nav-relationship-tab"
                           href="<?= $vilrel_link; ?>" aria-controls="nav-relationship-tab"
                           aria-selected="true" role="tab">Villgro Relationship Details</a>
                        <a class="nav-item nav-link active" id="nav-incubation-tab" aria-controls="nav-incubation-tab" href="javascript:void(0)" role="tab"
                           aria-selected="true">06</a>
                        <a class="nav-item nav-link" id="nav-cap-tab" href="<?= $cap_link; ?>"
                           aria-controls="nav-cap-tab" aria-selected="false" role="tab">Cap Table</a>
                        <a class="nav-item nav-link" id="nav-interested-tab" href="<?= $int_link; ?>"
                           aria-controls="nav-interested-tab" aria-selected="false" role="tab">Other Interested Parties</a>
                        <a class="nav-item nav-link brd-none bg-trasnparent" id="nav-about-tab" href="#nav-about"
                           aria-controls="nav-about-tab" aria-selected="false" role="tab">&nbsp;</a>
                        <a class="nav-item nav-link dataconfig_btn" id="nav-dataconfig-tab"
                           href="<?= $dataconfig_link; ?>" role="tab" aria-controls="nav-dataconfig-tab"
                           aria-selected="false">Plan Setup</a>
                    </div>
                </nav>
                <div class="tab-content  px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-Companymaster" role="tabpanel"
                         aria-labelledby="nav-Companymaster-tab">
                        <div class="tabpanel-title">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <h4>Incubation Relationship</h4>
                                </div>
                                <div class="col-xl-6 col-lg-4 col-md-6 col-sm-6 col-12 text-right">
                                <ul class="milestone-links">
                                    <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                        
                                            <li class="brd-left-onboard"><a href="javascript:void(0)" id="addIncubation"><i class="fas fa-plus-circle"></i> Add New</a></li>
                                            <li class="brd-left-onboard"><a href="javascript:void(0)" id="edit_cmpny"><i class="fas fa-pencil-alt"></i>
                                                    Edit</a></li>
                                            <li class="brd-left-onboard" id="disableBtn">
                                                <a class="deleteControl" href="javascript:void(0)"
                                                   id="deleteBtn"><i class="fas fa-trash"></i>
                                                    Delete</a>
                                            <li class="brd-left-onboard"><a class="saveContinue" href="javascript:void(0)">Save</a></li>
                                        
                                    <?php } ?>
                                    <li><a href="<?php echo base_url() . 'uploads/portfolio/data_legend_key.pdf'; ?>" target="_blank" class="legendKey" title="Data Legend" style="font-size: 15px !important;text-decoration: underline;"><i class="far fa-question-circle"></i>&nbsp;M&E SOP - Click here</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="Diagnostic-graph plan-structure-new">
                            <div id="accordion" class="vil-Deals table-responsive portfolio-table">
                                <form id="incubationForm" method="POST"
                                      action="<?php echo base_url() . 'index.php/portfolio/addIncubation'; ?>"
                                      autocomplete="off" enctype=multipart/form-data>
                                    <input type='hidden' name='innovation_id' value="<?= $innovation_id; ?>" >
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width:3%;"></th>
                                                <th style="width:22%;">Type</th>
                                                <th style="width:30%;">Brief Purpose<br>
                                                <th style="width:15%;">Signed on</th>
                                                <th style="width:30%;">Document <small>(Max 10MB size of ppt, pdf, doc files)</small></th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white" id="incub_add">
                                            <tr style="vertical-align:center;">
                                                <td style="width:3%;"></td>
                                                <td style="width:22%;">
                                                    <h6>Initial Incubation Agreement<span class="text-danger">*</span>
                                                    </h6>
                                                </td>
                                                <td style="width:30%;">
                                                    <div class="form-group">
                                                        <textarea class="form-control" name='initial_desc'
                                                                  placeholder="Agreement Purpose" maxlength="150"
                                                                  rows="2"><?= $iniAgree->purpose; ?></textarea>
                                                    </div>
                                                </td>
                                                <td style="width:15%;">
                                                    <div class="form-group">
                                                        <input type="text" name="initial_sign" id="start_date"
                                                               placeholder="dd-mm-yyyy" value="<?= $iniAgree->sign; ?>"
                                                               class="form-control form-control-sm dateCalendar">
                                                    </div>
                                                </td>
                                                <td style="width:30%;">
                                                    <div class="fileUpload blue-btn btn wdt80">
                                                        <?php
                                                        if (isset($iniAgree->link) && !empty($iniAgree->link)) {
                                                            echo strlen($iniAgree->link) > 20 ? "..." . substr($iniAgree->link, -20) : $iniAgree->link;
                                                        } else {
                                                            ?>
                                                            <span><i class="fas fa-upload"></i> Upload</span>
                                                            <input type="file" class="uploadlogo" name="initial_file" id="initial_file" />
                                                        <?php } ?>
                                                    </div>
                                                    <label for="initial_file" class="error"></label>
                                                    <label class="sow_msg error" id="initial_file_error"></label>
                                                    <?php if (isset($iniAgree->link) && !empty($iniAgree->link)) { ?>
                                                        <span class="download-btn"><a href="<?php echo base_url() . 'uploads/portfolio/incubation_relation/' . $iniAgree->link; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                        <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                            <span><a href="javascript:void(0)"  title="Delete Document" class="removeDoc initial_doc_delete delete-btnconfig" data-dyn="initial_agreement"><i class="fas fa-trash"></i></a></span>
                                                        <?php } ?>
                                                        <input type="hidden" name="old_initial_doc" id="old_initial_doc" value="<?php echo $iniAgree->link; ?>">
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:3%;"></td>
                                                <td style="width:22%;">
                                                    <h6>TAP Agreement</h6>
                                                </td>
                                                <td style="width:30%;">
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="tap_desc" id="tap_desc"
                                                                  placeholder="Agreement Purpose" maxlength="150"
                                                                  rows="2"><?= $tapAgree->purpose; ?></textarea>
                                                    </div>
                                                </td>
                                                <td style="width:15%;">
                                                    <div class="form-group">
                                                        <input type="text" name="tap_sign" id="tap_sign" placeholder="dd-mm-yyyy"
                                                               value="<?= $tapAgree->sign; ?>"
                                                               class="form-control form-control-sm dateCalendar">
                                                    </div>
                                                </td>
                                                <td style="width:30%;">
                                                    <div class="fileUpload blue-btn btn wdt80">
                                                        <?php
                                                        if (isset($tapAgree->link) && !empty($tapAgree->link)) {
                                                            echo strlen($tapAgree->link) > 20 ? "..." . substr($tapAgree->link, -20) : $tapAgree->link;
                                                        } else {
                                                            ?>
                                                            <span><i class="fas fa-upload"></i> Upload</span>
                                                            <input type="file" class="uploadlogo" name="tap_file" id="tap_file" />
                                                        <?php } ?>
                                                    </div>
                                                    <p class="sow_msg error" id="tap_file_error"></p>
                                                    <?php if (isset($tapAgree->link) && !empty($tapAgree->link)) { ?>
                                                        <span class="download-btn"><a href="<?php echo base_url() . 'uploads/portfolio/incubation_relation/' . $tapAgree->link; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                        <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                            <span><a href="javascript:void(0)" title="Delete Document" class="removeDoc tap_doc_delete delete-btnconfig" data-dyn="tap_agreement"><i class="fas fa-trash"></i></a></span>
                                                        <?php } ?>
                                                        <input type="hidden" name="old_tap_doc" value="<?php echo $tapAgree->link; ?>">
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:3%;"></td>
                                                <td style="width:22%;">
                                                    <h6>Mentoring Agreement</h6>
                                                </td>
                                                <td style="width:30%;">
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="ment_desc" id="ment_desc"
                                                                  placeholder="Agreement Purpose" maxlength="150"
                                                                  rows="2"><?= $menAgree->purpose; ?></textarea>
                                                    </div>
                                                </td>
                                                <td style="width:15%;">
                                                    <div class="form-group">
                                                        <input type="text" name="ment_sign" id="ment_sign" placeholder="dd-mm-yyyy"
                                                               value="<?= $menAgree->sign; ?>"
                                                               class="form-control form-control-sm dateCalendar">
                                                    </div>
                                                </td>
                                                <td style="width:30%;">
                                                    <div class="fileUpload blue-btn btn wdt80">
                                                        <?php
                                                        if (isset($menAgree->link) && !empty($menAgree->link)) {
                                                            echo strlen($menAgree->link) > 20 ? "..." . substr($menAgree->link, -20) : $menAgree->link;
                                                        } else {
                                                            ?>
                                                            <span><i class="fas fa-upload"></i> Upload</span>
                                                            <input type="file" class="uploadlogo" name="ment_file" id="ment_file" />
                                                        <?php } ?>
                                                    </div>
                                                    <p class="sow_msg error" id="ment_file_error"></p>
                                                    <?php if (isset($menAgree->link) && !empty($menAgree->link)) { ?>
                                                        <span class="download-btn"><a href="<?php echo base_url() . 'uploads/portfolio/incubation_relation/' . $menAgree->link; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                        <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                            <span><a href="javascript:void(0)" title="Delete Document" class="removeDoc ment_doc_delete delete-btnconfig" data-dyn="mentor_agreement"><i class="fas fa-trash"></i></a></span>
                                                        <?php } ?>
                                                        <input type="hidden" name="old_ment_doc" value="<?php echo $menAgree->link; ?>">
                                                    <?php } ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:3%;"></td>
                                                <td style="width:22%;">
                                                    <h6>Exit Letter</h6>
                                                </td>
                                                <td style="width:30%;">
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="exit_desc" id="exit_desc"
                                                                  placeholder="Description" maxlength="150"
                                                                  rows="2"><?= $exitAgree->purpose; ?></textarea>
                                                    </div>
                                                </td>
                                                <td style="width:15%;">
                                                    <div class="form-group">
                                                        <input type="text" name="exit_sign" id="exit_sign" placeholder="dd-mm-yyyy"
                                                               value="<?= $exitAgree->sign; ?>"
                                                               class="form-control form-control-sm dateCalendar">
                                                    </div>
                                                </td>
                                                <td style="width:30%;">
                                                    <div class="fileUpload blue-btn btn wdt80">
                                                        <?php
                                                        if (isset($exitAgree->link) && !empty($exitAgree->link)) {
                                                            echo strlen($exitAgree->link) > 20 ? "..." . substr($exitAgree->link, -20) : $exitAgree->link;
                                                        } else {
                                                            ?>
                                                            <span><i class="fas fa-upload"></i> Upload</span>
                                                            <input type="file" class="uploadlogo" name="exit_file" id="exit_file" />
                                                        <?php } ?>
                                                    </div>
                                                    <p class="sow_msg error" id="exit_file_error"></p>
                                                    <?php if (isset($exitAgree->link) && !empty($exitAgree->link)) { ?>
                                                        <span class="download-btn"><a href="<?php echo base_url() . 'uploads/portfolio/incubation_relation/' . $exitAgree->link; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                        <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                            <span><a href="javascript:void(0)" title="Delete Document" class="removeDoc exit_doc_delete delete-btnconfig" data-dyn="exit_agreement"><i class="fas fa-trash"></i></a></span>
                                                        <?php } ?>
                                                        <input type="hidden" name="old_exit_doc" value="<?php echo $exitAgree->link; ?>">
                                                    <?php } ?>

                                                </td>
                                            </tr>

                                            <?php
                                            $s = 1;
                                            $snum = 2;
                                            foreach ($incub_more as $incub) {
                                                $reldata = isset($incub) ? $incub['data'] : '';
                                                $reljson = json_decode($reldata);
                                                ?>
                                                <tr id="incub_tr_<?= $s; ?>" class="incub_more">
                                                    <td style="width:3%;">
                                                        <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                            <input type="checkbox" class="check_box" aria-label="Checkbox for following text input" name="check_delete" id="check_delete_<?= $s; ?>" value="<?= $incub['id']; ?>">
                                                        <?php } ?>
                                                    </td>
                                                    <td style="width:22%;">
                                                        <!-- <h6><?= $reljson->type; ?></h6> -->
                                                        <h6>Addendum # <?= $s; ?></h6>
                                                        <input type="hidden" name="typelabel[]" id="cmnt_type<?= $s; ?>" value="Addendum # <?= $s; ?>" />
                                                    </td>
                                                    <td style="width:30%;">
                                                        <div class="form-group">
                                                            <textarea class="form-control" name="cmnt_desc1[]" id="cmnt_desc<?= $s; ?>" placeholder="Other comments" maxlength="150" rows="2"><?= $reljson->purpose; ?></textarea>
                                                        </div>
                                                    </td>
                                                    <td style="width:15%;">
                                                        <div class="form-group">
                                                            <input type="text" name="cmnt_sign1[]" id="cmnt_sign<?= $s; ?>" placeholder="dd-mm-yyyy" value="<?= $reljson->sign; ?>" class="form-control form-control-sm dateCalendar">
                                                        </div>
                                                    </td>
                                                    <td style="width:30%;">
                                                        <div class="fileUpload blue-btn btn wdt80">
                                                            <?php
                                                            if (isset($reljson->link) && !empty($reljson->link)) {
                                                                echo strlen($reljson->link) > 20 ? "..." . substr($reljson->link, -20) : $reljson->link;
                                                            } else {
                                                                ?>
                                                                <span><i class="fas fa-upload"></i>Upload</span>

                                                            <?php } ?>
                                                            <input type="file" class="uploadlogo" data-dyn="<?= $s; ?>" name="cmnt_file1[]" id="cmnt_file<?= $s; ?>" />
                                                        </div>
                                                        <p class="sow_msg error" id="cmnt_file<?= $s; ?>_error"></p>

                                                        <?php if (isset($reljson->link) && !empty($reljson->link)) { ?>
                                                            <span class="download-btn"><a href="<?php echo base_url() . 'uploads/portfolio/incubation_relation/' . $reljson->link; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                            <?php if ($isAssociate == '1' || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin' || $this->session->userdata['sector_lead'] == '1') { ?>
                                                                <span><a href="javascript:void(0)" title="Delete Document" class="removeDoc desc_one_delete delete-btnconfig" data-dyn="<?= $s; ?>"><i class="fas fa-trash"></i></a></span>
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <input type="hidden" name="old_cmnt_doc1[]" id="old_cmnt_doc<?= $s; ?>" class="uploadlogo" data-dyn="<?= $s; ?>" value="<?php echo $reljson->link; ?>">
                                                        <p class="sow_msg hidden_cls error">Invalid file</p>
                                                        <input type="hidden" name="inrelation_id[]" id="inrelation_id_<?= $s; ?>" value="<?= $incub['id']; ?>" >
                                                    </td>
                                                </tr>
                                                <?php
                                                $s++;
                                                $snum++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <input type="hidden" name="incub_id" id="incub_id" value="<?= $incubation['id']; ?>" >
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="enableCount" value="<?= php72_count($villgro_incubation); ?>">
<input type="hidden" name="innovationId" id="innovationId" value="<?php echo $innovation_id; ?>">
<input type="hidden" id="delete_type">
<input type="hidden" id="delete_date">
<input type="hidden" id="delete_purpose">
<input type="hidden" id="update_column">
<input type="hidden" id="delete_table">
<input type="hidden" id="relation_id">

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
                            <p>you are about delete <span id="delCount"></span> selected information fields, you
                                can't undo this</p>
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
        onLoad();
    });

    function onLoad() {

        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('input[type="text"], textarea').attr('readonly', 'readonly');
            $('input[type="file"]').css("pointer-events", "none");
        } else {
            $(".dateCalendar").datepicker({
                dateFormat: "dd-mm-yy"
            });
        }
        $('#edit_cmpny').addClass('opacity5');
        $('#disableBtn').css("cursor", "not-allowed");
        $('#deleteBtn').css("pointer-events", "none");
    }

    $('#deleteRecord').on('click', function () {
        var delcnt = $('#delCount').html();
        var invId = $('#innovationId').val();
        var cubid = $('#incub_id').val();
        var date = $('#delete_date').val();
        var purpose = $('#delete_purpose').val();
        var update_column = $('#update_column').val();
        var ctype = $('#delete_type').val();
        var dtable = $('#delete_table').val();
        var relid = $('#relation_id').val();
        if (delcnt == '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deleteUploadFiles",
                data: {
                    date: date,
                    purpose: purpose,
                    update_column: update_column,
                    ctype: ctype,
                    invId: invId,
                    cubid: cubid,
                    relid: relid,
                    table: dtable
                },
                dataType: 'json',
                async: true,
                cache: false,
                success: function (msg) {
                    location.reload();
//                            $('#accordion').load("<?php echo $_SERVER['HTTP_REFERER']; ?> #accordion");
//                            $('#deletemodal').modal('hide');
//                            $('#deleteMsg').show();
//                            setTimeout(function () {
//                                uploadFile();
//                                onLoad();
//                                deleteMore();
//                            }, 500);
//                            setTimeout(function () {
//                                $('#deleteMsg').hide();
//                            }, 3000);
                }
            });
        } else {
            var deleteId = new Array();
            $("input:checkbox[name=check_delete]:checked").each(function () {
                deleteId.push($(this).val());
            });
            if ($("#incubationForm input:checkbox:checked").length > 0) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/portfolio/deletePortfolioDetail",
                    data: {
                        id: deleteId,
                        table: dtable
                    },
                    dataType: 'json',
                    async: true,
                    cache: false,
                    success: function (msg) {
                        location.reload();
//                                $('#accordion').load("<?php echo $_SERVER['HTTP_REFERER']; ?> #accordion");
//                                $('#deletemodal').modal('hide');
//                                $('#deleteMsg').show();
//                                setTimeout(function () {
//                                    onLoad();
//                                    deleteMore();
//                                }, 500);
//                                setTimeout(function () {
//                                    $('#deleteMsg').hide();
//                                }, 3000);
                    }
                });
            }
        }
    });

    $(document).on('keyup', 'textarea', function () {
        if (this.value.match(/[^a-zA-Z0-9\n.,"():&'\-/=? ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9\n.,"():&'\-/=? ]/g, '');
        }
    });

    $('#edit_cmpny').on('click', function () {
        $('input[type="text"], textarea').attr('readonly', false);
        $('input[type="file"]').css("pointer-events", "");
        $(".dateCalendar").datepicker({
            dateFormat: "dd-mm-yy"
        });
        $('#edit_cmpny').removeClass('opacity5');
    });

    $.validator.addMethod("maxfilesize", function (value, element) {
        return this.optional(element) || (element.files && element.files[0] && element.files[0].size <= 10008250);
    }, $.format('Invalid file size'));

    $.validator.addMethod("extension", function (value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    }, "Not a valid file format");

    $('#incubationForm').validate({
        rules: {
            initial_desc: "required",
            initial_sign: "required",
            initial_file: "required"
        },
        messages: {
            initial_desc: "Please enter description",
            initial_sign: "Select date",
            initial_file: "Please upload the document"
        }
    });

    $(document).on('change', '.uploadlogo', function () {
        $('#incubationForm').valid();
        var filename = readURL(this);
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

    function uploadFile() {
        $(".uploadlogo").on('change', function () {
            var filename = readURL(this);
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
    }

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

    $(document).on('click', '#addIncubation', function () {
        if ($('.incub_more').length) {
            var dyn = $('.uploadlogo:last').attr('data-dyn');
            var increa = parseInt(dyn) + 1;
            var inc = parseInt(dyn) + 2;

            var datas = '<tr id="incub_tr_' + increa + '" class="incub_more"><td width="3%"></td><td width="22%"><h6>Addendum # ' + increa + '</h6><input type="hidden" name="typelabel[]" id="cmnt_type' + increa + '" value="Addendum # ' + increa + '" ></td><td width="30%"><div class="form-group"><textarea class="form-control" name="cmnt_desc1[]" id="cmnt_desc' + increa + '" placeholder="Other comments" maxlength="150" rows="2"></textarea></div></td><td width="15%"><div class="form-group"><input type="text" name="cmnt_sign1[]" id="cmnt_sign' + increa + '" placeholder="dd-mm-yyyy" value="" class="form-control form-control-sm dateCalendar"></div></td><td width="30%"><div class="fileUpload blue-btn btn width100"><span><i class="fas fa-upload"></i>Upload</span><input type="file" class="uploadlogo" data-dyn="' + increa + '" name="cmnt_file1[]" id="cmnt_file' + increa + '"/></div><p for="cmnt_file' + increa + '" class="error" id="cmnt_file' + increa + '_error"></p><input type="hidden" name="old_cmnt_doc' + increa + '[]" id="old_cmnt_doc' + increa + '" class="uploadlogo" data-dyn="' + increa + '" value=""><p class="sow_msg hidden_cls error" >Invalid file</p></td></tr>';
            $(datas).insertAfter($('#incub_tr_' + dyn));
        } else {
            var datas = '<tr id="incub_tr_1" class="incub_more"><td width="3%"></td><td width="22%"><h6>Addendum # 1</h6><input type="hidden" name="typelabel[]" id="cmnt_type1" value="Addendum # 1" ></td><td width="30%"><div class="form-group"><textarea class="form-control" name="cmnt_desc1[]" id="cmnt_desc1" placeholder="Other comments" maxlength="150" rows="2"></textarea></div></td><td width="15%"><div class="form-group"><input type="text" name="cmnt_sign1[]" id="cmnt_sign1" placeholder="dd-mm-yyyy" value="" class="form-control form-control-sm dateCalendar"></div></td><td width="30%"><div class="fileUpload blue-btn btn width100"><span><i class="fas fa-upload"></i>Upload</span><input type="file" class="uploadlogo" data-dyn="1" name="cmnt_file1[]" id="cmnt_file1"/></div><p for="cmnt_file1" class="error" id="cmnt_file1_error"></p><input type="hidden" name="old_cmnt_doc1[]" id="old_cmnt_doc1" class="uploadlogo" data-dyn="1" value=""><p class="sow_msg hidden_cls error" >Invalid file</p></td></tr>';
            $('#incub_add').append(datas);
        }
        $(".dateCalendar").datepicker({
            dateFormat: "dd-mm-yy"
        });
    });


    $('#deleteBtn').on('click', function () {
        $('#deletemodal').modal('show');
        $('#dltDoc').val('');
        var sel_item = $("input:checkbox[name=check_delete]:checked").length;
        $('#delCount').html(sel_item);
        $('#delete_table').val('port_incubation_relation_addmore');
    });

    $('.check_box').on('click', function () {
        if ($("#incubationForm input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
        }
    });

    function deleteMore() {
        $('.check_box').on('click', function () {
            if ($("#incubationForm input:checkbox:checked").length > 0) {
                $('#disableBtn').css("cursor", "pointer");
                $('#deleteBtn').css("pointer-events", "");
            } else {
                $('#disableBtn').css("cursor", "not-allowed");
                $('#deleteBtn').css("pointer-events", "none");
            }
        });
    }

    $(document).on('click', '.removeDoc', function () {
// $('#removeDoc').on('click', function() {
// }
//                var class_name = $(this).attr('class');
        $('#delCount').html('');
        var column_name = $(this).attr('data-dyn');

        var date, purpose;
        var type = '';
        var ir_id = '';
        if (column_name == 'initial_agreement') {
            date = $("[name='initial_sign']").val();
            purpose = $("[name='initial_desc']").val();
        } else if (column_name == 'tap_agreement') {
            date = $("[name='tap_sign']").val();
            purpose = $("[name='tap_desc']").val();
        } else if (column_name == 'mentor_agreement') {
            date = $("[name='ment_sign']").val();
            purpose = $("[name='ment_desc']").val();
        } else if (column_name == 'exit_agreement') {
            date = $("[name='exit_sign']").val();
            purpose = $("[name='exit_desc']").val();
        } else if (column_name == 'description_one') {
            date = $("[name='cmnt_sign']").val();
            purpose = $("[name='cmnt_desc']").val();
        } else {
            type = $("#cmnt_type" + column_name).val();
            date = $("#cmnt_sign" + column_name).val();
            purpose = $("#cmnt_desc" + column_name).val();
            relation_id = $('#inrelation_id_' + column_name).val();

        }
        $('#delete_type').val(type);
        $('#delete_date').val(date);
        $('#delete_purpose').val(purpose);
        $('#update_column').val(column_name);
        if (type != '') {
            $('#delete_table').val('port_incubation_relation_addmore');
            $('#relation_id').val(relation_id);
        } else {
            $('#delete_table').val('port_incubation_relation');
            $('#relation_id').val('');
        }

        $('#deletemodal').modal('show');
    });



    $(".saveContinue").on('click', function (e) {
        ImgValidate();
        $('#incubationForm').submit();
        e.preventDefault();
    });

    $(document).on('submit', '#incubationForm', function (e) {
        $('#incubationForm').valid();
        var result = ImgValidate();
        if (result == 1) {
            return false;
        } else {
            $('.saveContinue').css('pointer-events', 'none');
            return true;
        }
    });

    function ImgValidate()
    {
        var err = 0;
        var arr = ['tap_file', 'ment_file', 'exit_file'];
        var cmnt_arr = [];
        var cmnt_dyn = document.getElementsByName("cmnt_file1[]").length;
        for (var r = 0; r < cmnt_dyn; r++) {
            var dyn_id = document.getElementsByName("cmnt_file1[]")[r].id;
            cmnt_arr.push(dyn_id);
        }
        var ini_desc = $('#initial_desc').val();
        var ini_sign = $('#initial_sign').val();
        var tap_desc = $('#tap_desc').val();
        var tap_sign = $('#tap_sign').val();
        var ment_desc = $('#ment_desc').val();
        var ment_sign = $('#ment_sign').val();
        var exit_desc = $('#exit_desc').val();
        var exit_sign = $('#exit_sign').val();
        var s = 1;

        for (var j = 0; j < arr.length; j++) {
            var image = $('#' + arr[j]).val();

            if (arr[j] == 'initial_file') {
                if (ini_desc != '' && ini_sign != '' && image == '') {
                    $('#' + arr[j] + '_error').text('Upload document');
                    err = 1;
                } else {
                    $('#' + arr[j] + '_error').text('');
                }
            } else if (arr[j] == 'tap_file') {
                if (tap_desc != '' && tap_sign != '' && image == '') {
                    $('#' + arr[j] + '_error').text('Upload document');
                    err = 1;
                } else {
                    $('#' + arr[j] + '_error').text('');
                }
            } else if (arr[j] == 'ment_file') {
                if (ment_desc != '' && ment_sign != '' && image == '') {
                    $('#' + arr[j] + '_error').text('Upload document');
                    err = 1;
                } else {
                    $('#' + arr[j] + '_error').text('');
                }
            } else if (arr[j] == 'exit_file') {
                if (exit_desc != '' && exit_sign != '' && image == '') {
                    $('#' + arr[j] + '_error').text('Upload document');
                    err = 1;
                } else {
                    $('#' + arr[j] + '_error').text('');
                }
            }
        }

        for (var q = 0; q < cmnt_arr.length; q++) {
            var cmnt_desc = $('#cmnt_desc' + s).val();
            var cmnt_sign = $('#cmnt_sign' + s).val();
            var oldcmnt = $('#old_cmnt_doc' + s).val();
            var image = $('#' + cmnt_arr[q]).val();

            if (cmnt_desc != '' && cmnt_sign != '' && image == '' && oldcmnt == '') {

                $('#' + cmnt_arr[q] + '_error').text('Upload document');
                err = 1;
            } else {
                $('#' + cmnt_arr[q] + '_error').text('');
            }

            s++;
        }
        return err;
    }

    $('.plan-structure-new').css({'height': (($(window).height()) - 245) + 'px'});
</script>

<style type="text/css">
    .fileUpload {
        width: 80%;
    }
</style>

</body>
</html>
