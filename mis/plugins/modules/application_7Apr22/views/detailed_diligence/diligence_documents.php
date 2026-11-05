<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => 'Detailed Assessment - ' . $innovation['name_of_enterprise'])); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'diligence_document', 'inv_stage' => $innovation['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content vital_windowScroll">
                <?php $this->load->view('detailed_diligence/diligence_options.php', array('application_id' => $application_id, 'title' => 'Documents', 'inv_id' => $inv_id_format, 'stage' => $stage_name, 'status' => $status_name, 'incharge' => $assign_incharge, 'enterprise_name' => $innovation['name_of_enterprise'], 'sector' => $sector[0]['sector'], 'sub_sector' => $subsector, 'assign_to' => $assign_to, 'eic_date' => $eic_date)); ?>

                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="<?php echo base_url() . 'index.php/application/diligence_documents/' . $application_id; ?>">Documents</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/diligence_meetings/' . $application_id; ?>">Meetings/Call Notes</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container ">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="table_configcontentnew pad-bt0">
                                <div class="tabpanel-title">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9"></div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                            <ul class="milestone-links">
                                                <?php if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || in_array($this->session->userdata('emp_number'), $assign_incharge_id)) { ?>
                                                    <li class="brd-left-onboard" id="disableSave"><a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a></li>
                                                    <li class="brd-left-onboard" id="disableBtn"><a href="javascript:void(0)" class="deleteControl" id="deleteBtn"><i class="fas fa-trash-alt"></i> Delete</a></li>
                                                    <li class="brd-left-onboard"><a href="javascript:void(0)" class="saveContinue" id="saveForm">Save</a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form method="post" id="diligenceDocuments" action="<?php echo base_url() . 'index.php/application/save_diligence_document'; ?>" class="form" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" name='inv_id' value="<?= $application_id; ?>" />
                                <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                    <table class="table table-hover dt-responsive" id="master_table">
                                        <thead>
                                            <tr>
                                                <th width="5%"></th>
                                                <th width="25%">Documents Type<span class="text-danger">*</span></th>
                                                <th width="25%">Description<span class="text-danger">*</span></th>
                                                <th width="20%">Location/ View Documents<span class="text-danger">*</span></th>
                                                <th width="15%">Added Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="addRows">
                                        <input type="hidden" name='doc_type[]' value="1" />
                                        <td></td>
                                        <td>Signed NDA</td>
                                        <td>
                                            <div class="form-group">
                                                <textarea class="form-control" name="signed_desc" id="signed_desc" cols="30" rows="3"><?= $nda_list[0]['description']; ?></textarea>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fileUpload blue-btn btn width100">
                                                <?php
                                                if (isset($nda_list[0]['document']) && !empty($nda_list[0]['document'])) {
                                                    $signed_truncate = strlen($nda_list[0]['document']) > 20 ? "..." . substr($nda_list[0]['document'], -20) : $nda_list[0]['document'];
                                                    ?>
                                                    <span><?= $signed_truncate; ?></span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span><i class="fas fa-upload"></i> Upload</span>
                                                <?php } ?>
                                                <input type="file" class="uploadlogo" name="signed_file" id="signed_file" />
                                                <input type="hidden" name="old_signed_file" id="old_signed_file" value="<?php echo isset($nda_list[0]['document']) ? $nda_list[0]['document'] : ''; ?>" />
                                            </div>
                                            <?php if (isset($nda_list[0]['document']) && !empty($nda_list[0]['document'])) { ?>
                                                <span class="download-btn"><a href="<?php echo base_url() . 'uploads/detailed_diligence/' . $nda_list[0]['document']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                            <?php } ?>
                                            <label class="sow_msg error" id="signed_file_error"></label>
                                        </td>
                                        <td>
                                            <p>
                                                <?php
                                                if (isset($nda_list[0]['created_at'])) {
                                                    echo date('d/m/Y', strtotime($nda_list[0]['created_at']));
                                                } else {
                                                    echo '-N/A-';
                                                }
                                                ?>
                                            </p>
                                        </td>
                                        </tr>
                                        <tr>
                                        <input type="hidden" name='doc_type[]' value="2" />
                                        <td></td>
                                        <td>Questionnaire Responses</td>
                                        <td>
                                            <div class="form-group">
                                                <textarea class="form-control" name="quest_desc" id="quest_desc" cols="30" rows="3"><?= $quest_list[0]['description']; ?></textarea>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fileUpload blue-btn btn width100">
                                                <?php
                                                if (isset($quest_list[0]['document']) && !empty($quest_list[0]['document'])) {
                                                    $quest_truncate = strlen($quest_list[0]['document']) > 20 ? "..." . substr($quest_list[0]['document'], -20) : $quest_list[0]['document'];
                                                    ?>
                                                    <span><?= $quest_truncate; ?></span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span><i class="fas fa-upload"></i> Upload</span>
                                                <?php } ?>
                                                <input type="file" class="uploadlogo" name="quest_file" id="quest_file" />
                                                <input type="hidden" name="old_quest_file" id="old_quest_file" value="<?php echo isset($quest_list[0]['document']) ? $quest_list[0]['document'] : ''; ?>" />
                                            </div>
                                            <?php if (isset($quest_list[0]['document']) && !empty($quest_list[0]['document'])) { ?>
                                                <span class="download-btn"><a href="<?php echo base_url() . 'uploads/detailed_diligence/' . $quest_list[0]['document']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                            <?php } ?>
                                            <label class="sow_msg error" id="quest_file_error"></label>
                                        </td>
                                        <td>
                                            <p>
                                                <?php
                                                if (isset($quest_list[0]['created_at'])) {
                                                    echo date('d/m/Y', strtotime($quest_list[0]['created_at']));
                                                } else {
                                                    echo '-N/A-';
                                                }
                                                ?>
                                            </p>
                                        </td>
                                        </tr>
                                        <tr>
                                        <input type="hidden" name='doc_type[]' value="3" />
                                        <td></td>
                                        <td>Term sheet</td>
                                        <td>
                                            <div class="form-group">
                                                <textarea class="form-control" name="term_desc" id="term_desc" cols="30" rows="3"><?= $term_list[0]['description']; ?></textarea>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fileUpload blue-btn btn width100">
                                                <?php
                                                if (isset($term_list[0]['document']) && !empty($term_list[0]['document'])) {
                                                    $term_truncate = strlen($term_list[0]['document']) > 20 ? "..." . substr($term_list[0]['document'], -20) : $term_list[0]['document'];
                                                    ?>
                                                    <span><?= $term_truncate; ?></span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span><i class="fas fa-upload"></i> Upload</span>
                                                <?php } ?>
                                                <input type="file" class="uploadlogo" name="term_file" id="term_file" />
                                                <input type="hidden" name="old_term_file" id="old_term_file" value="<?php echo isset($term_list[0]['document']) ? $term_list[0]['document'] : ''; ?>" />
                                            </div>
                                            <?php if (isset($term_list[0]['document']) && !empty($term_list[0]['document'])) { ?>
                                                <span class="download-btn"><a href="<?php echo base_url() . 'uploads/detailed_diligence/' . $term_list[0]['document']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                            <?php } ?>
                                            <label class="sow_msg error" id="term_file_error"></label>
                                        </td>
                                        <td>
                                            <p>
                                                <?php
                                                if (isset($term_list[0]['created_at'])) {
                                                    echo date('d/m/Y', strtotime($term_list[0]['created_at']));
                                                } else {
                                                    echo '-N/A-';
                                                }
                                                ?>
                                            </p>
                                        </td>
                                        </tr>
                                        <tr>
                                        <input type="hidden" name='doc_type[]' value="4" />
                                        <td></td>
                                        <td>Service agreement</td>
                                        <td>
                                            <div class="form-group">
                                                <textarea class="form-control" name="service_desc" id="service_desc" cols="30" rows="3"><?= $service_list[0]['description']; ?></textarea>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fileUpload blue-btn btn width100">
                                                <?php
                                                if (isset($service_list[0]['document']) && !empty($service_list[0]['document'])) {
                                                    $service_truncate = strlen($service_list[0]['document']) > 20 ? "..." . substr($service_list[0]['document'], -20) : $service_list[0]['document'];
                                                    ?>
                                                    <span><?= $service_truncate; ?></span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span><i class="fas fa-upload"></i> Upload</span>
                                                <?php } ?>
                                                <input type="file" class="uploadlogo" name="service_file" id="service_file" />
                                                <input type="hidden" name="old_service_file" id="old_service_file" value="<?php echo isset($service_list[0]['document']) ? $service_list[0]['document'] : ''; ?>" />
                                            </div>
                                            <?php if (isset($service_list[0]['document']) && !empty($service_list[0]['document'])) { ?>
                                                <span class="download-btn"><a href="<?php echo base_url() . 'uploads/detailed_diligence/' . $service_list[0]['document']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                            <?php } ?>
                                            <label class="sow_msg error" id="service_file_error"></label>
                                        </td>
                                        <td>
                                            <p>
                                                <?php
                                                if (isset($service_list[0]['created_at'])) {
                                                    echo date('d/m/Y', strtotime($service_list[0]['created_at']));
                                                } else {
                                                    echo '-N/A-';
                                                }
                                                ?>
                                            </p>
                                        </td>
                                        </tr>
                                        <tr>
                                        <input type="hidden" name='doc_type[]' value="5" />
                                        <td></td>
                                        <td>Company presentation (EIC pitch)</td>
                                        <td>
                                            <div class="form-group">
                                                <textarea class="form-control" name="comp_desc" id="comp_desc" cols="30" rows="3"><?= $compnay_list[0]['description']; ?></textarea>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fileUpload blue-btn btn width100">
                                                <?php
                                                if (isset($compnay_list[0]['document']) && !empty($compnay_list[0]['document'])) {
                                                    $comp_truncate = strlen($compnay_list[0]['document']) > 20 ? "..." . substr($compnay_list[0]['document'], -20) : $compnay_list[0]['document'];
                                                    ?>
                                                    <span><?= $comp_truncate; ?></span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span><i class="fas fa-upload"></i> Upload</span>
                                                <?php } ?>
                                                <input type="file" class="uploadlogo" name="comp_file" id="comp_file" />
                                                <input type="hidden" name="old_comp_file" id="old_comp_file" value="<?php echo isset($compnay_list[0]['document']) ? $compnay_list[0]['document'] : ''; ?>" />
                                            </div>
                                            <?php if (isset($compnay_list[0]['document']) && !empty($compnay_list[0]['document'])) { ?>
                                                <span class="download-btn"><a href="<?php echo base_url() . 'uploads/detailed_diligence/' . $compnay_list[0]['document']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                            <?php } ?>
                                            <label class="sow_msg error" id="comp_file_error"></label>
                                        </td>
                                        <td>
                                            <p>
                                                <?php
                                                if (isset($compnay_list[0]['created_at'])) {
                                                    echo date('d/m/Y', strtotime($compnay_list[0]['created_at']));
                                                } else {
                                                    echo '-N/A-';
                                                }
                                                ?>
                                            </p>
                                        </td>
                                        </tr>
                                        <tr>
                                        <input type="hidden" name='doc_type[]' value="6" />
                                        <td></td>
                                        <td>Villgro's EIC presentation</td>
                                        <td>
                                            <div class="form-group">
                                                <textarea class="form-control" name="villgro_desc" id="villgro_desc" cols="30" rows="3"><?= $villgro_list[0]['description']; ?></textarea>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fileUpload blue-btn btn width100">
                                                <?php
                                                if (isset($villgro_list[0]['document']) && !empty($villgro_list[0]['document'])) {
                                                    $villgro_truncate = strlen($villgro_list[0]['document']) > 20 ? "..." . substr($villgro_list[0]['document'], -20) : $villgro_list[0]['document'];
                                                    ?>
                                                    <span><?= $villgro_truncate; ?></span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span><i class="fas fa-upload"></i> Upload</span>
                                                <?php } ?>
                                                <input type="file" class="uploadlogo" name="villgro_file" id="villgro_file" />
                                                <input type="hidden" name="old_villgro_file" id="old_villgro_file" value="<?php echo isset($villgro_list[0]['document']) ? $villgro_list[0]['document'] : ''; ?>" />
                                            </div>
                                            <?php if (isset($villgro_list[0]['document']) && !empty($villgro_list[0]['document'])) { ?>
                                                <span class="download-btn"><a href="<?php echo base_url() . 'uploads/detailed_diligence/' . $villgro_list[0]['document']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                            <?php } ?>
                                            <label class="sow_msg error" id="villgro_file_error"></label>
                                        </td>
                                        <td>
                                            <p>
                                                <?php
                                                if (isset($villgro_list[0]['created_at'])) {
                                                    echo date('d/m/Y', strtotime($villgro_list[0]['created_at']));
                                                } else {
                                                    echo '-N/A-';
                                                }
                                                ?>
                                            </p>
                                        </td>
                                        </tr>

                                        <?php
                                        $j = 1;
                                        if (count($type_list) > 0) {
                                            for ($i = 0; $i < count($type_list); $i++) {
                                                ?>

                                                <tr id="document_tr_<?php echo $j; ?>" class="document_more">
                                                    <td class="align-middle">
                                                        <?php if ($isAssociate == 1 || $this->session->userdata['user_type'] == 'admin' || $this->session->userdata['user_type'] == 'superadmin') { ?>
                                                            <div class="input-group">
                                                                <input type="checkbox" class="check_box" aria-label="Checkbox for following text input"
                                                                       name="check_delete" id="check_delete_<?php echo $j; ?>" value="<?php echo $type_list[$i]['detail_id']; ?>">
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <select class="form-control form-control-sm" name="add_doc_type[]" id="add_doc_type_<?= $j; ?>" class="doc_type">
                                                                <option value="">--Select--</option>
                                                                <?php foreach ($doc_type as $t) { ?>
                                                                    <option value="<?php echo $t['id']; ?>" <?php
                                                                    if ($t['id'] == $type_list[$i]['doc_type']) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>><?php echo $t['name']; ?></option>
                                                                        <?php } ?>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <textarea class="form-control" name="additional_desc[]" id="additional_desc_<?= $j; ?>" cols="30" rows="3"><?= $type_list[$i]['description']; ?></textarea>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="fileUpload blue-btn btn width100">
                                                            <?php
                                                            if (isset($type_list[$i]['document']) && !empty($type_list[$i]['document'])) {
                                                                $type_truncate = strlen($type_list[$i]['document']) > 20 ? "..." . substr($type_list[$i]['document'], -20) : $type_list[$i]['document'];
                                                                ?>
                                                                <span><?= $type_truncate; ?></span>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <span><i class="fas fa-upload"></i> Upload</span>
                                                            <?php } ?>
                                                            <input type="file" class="uploadlogo" name="additional_file[]" id="additional_file_<?= $j; ?>" />
                                                            <input type="hidden" name="old_additional_file[]" id="old_additional_file_<?= $j; ?>" value="<?php echo isset($type_list[$i]['document']) ? $type_list[$i]['document'] : ''; ?>" />
                                                        </div>
                                                        <?php if (isset($type_list[$i]['document']) && !empty($type_list[$i]['document'])) { ?>
                                                            <span class="download-btn"><a href="<?php echo base_url() . 'uploads/detailed_diligence/' . $type_list[$i]['document']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                        <?php } ?>
                                                        <label class="sow_msg error" id="additional_file_<?= $j; ?>_error"></label>
                                                    </td>
                                                    <td>
                                                        <p>
                                                            <?php
                                                            if (isset($type_list[$i]['created_at'])) {
                                                                echo date('d/m/Y', strtotime($type_list[$i]['created_at']));
                                                            } else {
                                                                echo '-N/A-';
                                                            }
                                                            ?>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <?php
                                                $j++;
                                            }
                                        } else {
                                            ?>
                                            <tr id="document_tr_1" class="document_more">
                                                <td></td>
                                                <td>
                                                    <div class="form-group">
                                                        <select class="form-control form-control-sm" name="add_doc_type[]" id="add_doc_type_1" class="doc_type">
                                                            <option value="">--Select--</option>
                                                            <?php foreach ($doc_type as $t) { ?>
                                                                <option value="<?php echo $t['id']; ?>"><?php echo $t['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="additional_desc[]" id="additional_desc_1" cols="30" rows="3"></textarea>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fileUpload blue-btn btn width100">
                                                        <span><i class="fas fa-upload"></i> Upload</span>
                                                        <input type="file" class="uploadlogo" name="additional_file[]" id="additional_file_1" />
                                                        <input type="hidden" name="old_additional_file[]" id="old_additional_file_1" value="" />
                                                    </div>
                                                    <label class="sow_msg error" id="additional_file_1_error"></label>
                                                </td>
                                                <td>
                                                    <p>
                                                        <?php echo '-N/A-'; ?>
                                                    </p>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </main>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="enableCount" value="<?= count($type_list); ?>">

<script type="text/javascript">
    $(document).ready(function () {
        var editOpt = $('#enableCount').val();
        if (editOpt > 0) {
            $('.document_more select, .document_more textarea').attr('readonly', 'readonly');
            $('.document_more input[type="file"], .document_more select, .document_more textarea').css("pointer-events", "none");
        }
        $('#deleteBtn').addClass('opacity5');
        $('#disableSave, #disableBtn').css("cursor", "not-allowed");
        $('#deleteBtn').css("pointer-events", "none");
    });

    $(document).on('click', '#saveVersion', function () {
        $('#save_type').val('save_version')
    });

    $(document).on('click', '#saveForm', function () {
        $('#save_type').val('save_exist')
    });

    $(document).on("click", ".saveContinue", function (e) {
        $('#diligenceDocuments').submit();
        e.preventDefault();
    });

    $(document).on('submit', '#diligenceDocuments', function (e) {
        $('#diligenceDocuments').valid();
        var result = validateForm();
        if (result == 1) {
            return false;
        } else {
            $('.saveContinue').css('pointer-events', 'none');
            return true;
        }
    });

    function validateForm() {
        var err = 0;
        var arr = ['signed_file', 'quest_file', 'term_file', 'service_file', 'comp_file', 'villgro_file'];
        var cmnt_arr = [];
        var cmnt_dyn = document.getElementsByName("additional_file[]").length;
        for (var r = 0; r < cmnt_dyn; r++) {
            var dyn_id = document.getElementsByName("additional_file[]")[r].id;
            cmnt_arr.push(dyn_id);
        }

        var signed_desc = $('#signed_desc').val();
        var quest_desc = $('#quest_desc').val();
        var term_desc = $('#term_desc').val();
        var service_desc = $('#service_desc').val();
        var comp_desc = $('#comp_desc').val();
        var villgro_desc = $('#villgro_desc').val();
        for (var j = 0; j < arr.length; j++) {
            var doc_file = $('#' + arr[j]).val();
            var old_doc_file = $('#old_' + arr[j]).val();
            if (arr[j] == 'signed_file') {
                if (signed_desc != '' && doc_file == '' && old_doc_file == '') {
                    $('#' + arr[j] + '_error').text('Upload document');
                    err = 1;
                } else {
                    $('#' + arr[j] + '_error').text('');
                }
            } else if (arr[j] == 'quest_file') {
                if (quest_desc != '' && doc_file == '' && old_doc_file == '') {
                    $('#' + arr[j] + '_error').text('Upload document');
                    err = 1;
                } else {
                    $('#' + arr[j] + '_error').text('');
                }
            } else if (arr[j] == 'term_file') {
                if (term_desc != '' && doc_file == '' && old_doc_file == '') {
                    $('#' + arr[j] + '_error').text('Upload document');
                    err = 1;
                } else {
                    $('#' + arr[j] + '_error').text('');
                }
            } else if (arr[j] == 'service_file') {
                if (service_desc != '' && doc_file == '' && old_doc_file == '') {
                    $('#' + arr[j] + '_error').text('Upload document');
                    err = 1;
                } else {
                    $('#' + arr[j] + '_error').text('');
                }
            } else if (arr[j] == 'comp_file') {
                if (comp_desc != '' && doc_file == '' && old_doc_file == '') {
                    $('#' + arr[j] + '_error').text('Upload document');
                    err = 1;
                } else {
                    $('#' + arr[j] + '_error').text('');
                }
            } else if (arr[j] == 'villgro_file') {
                if (villgro_desc != '' && doc_file == '' && old_doc_file == '') {
                    $('#' + arr[j] + '_error').text('Upload document');
                    err = 1;
                } else {
                    $('#' + arr[j] + '_error').text('');
                }
            }
        }

        var s = cmnt_arr.length;
        for (var q = 0; q < cmnt_arr.length; q++) {
            var addt_desc = $('#additional_desc_' + s).val();
            var addt_oldfile = $('#old_additional_file_' + s).val();
            var additional_doc = $('#' + cmnt_arr[q]).val();
            if (addt_desc != '' && additional_doc == '' && addt_oldfile == '') {
                $('#' + cmnt_arr[q] + '_error').text('Upload document');
                err = 1;
            } else {
                $('#' + cmnt_arr[q] + '_error').text('');
            }
            s--;
        }

        $(".uploadlogo").each(function () {
            var filename = readURL(this);
            if (filename) {
                var result = filename.split('|*|');
                $(this).parent().children('span').html(result[0]);
                if (result[1] != '1') {
                    $(this).parent().parent().children('.sow_msg').show();
                    $(this).parent().parent().children('.sow_msg').text(result[1]);
                    err = 1;
                } else {
                    $(this).parent().parent().children('.sow_msg').text('');
                    $(this).parent().parent().children('.sow_msg').hide();
                }
            }
        });
        return err;
    }

    $(document).on('change', '.uploadlogo', function () {
        var filename = readURL(this);
        var result = filename.split('|*|');
        $(this).parent().children('span').html(result[0]);
        if (result[1] != '1') {
            $(this).parent().parent().children('.sow_msg').show();
            $(this).parent().parent().children('.sow_msg').text(result[1]);
        } else {
            $(this).parent().parent().children('.sow_msg').text('');
            $(this).parent().parent().children('.sow_msg').hide();
        }
    });

    function readURL(input) {
        var url = input.value;
        var path, filename;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        var bsize = (input.files.length && input.files[0].size) || '';
        if (bsize != '') {
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
    }

    $(document).on('click', '#addMore', function () {
        var dyn = $(".document_more").length;
        var i = parseInt(dyn) + 1;
        var data = '<tr id="document_tr_' + i + '" class="document_more"><td></td>';
        data += '<td><div class="form-group"><select class="form-control form-control-sm" name="add_doc_type[]" id="add_doc_type_' + i + '" class="doc_type"><option value="">-Select-</option><?php
                                        foreach ($doc_type as $t) {
                                            ?> <option value="<?php echo $t['id']; ?>"><?php echo $t['name']; ?></option> <?php } ?></select></div></td>';
        data += '<td><textarea class="form-control" name="additional_desc[]" id="additional_desc_' + i + '" cols="30" rows="3"></textarea></td>';
        data += '<td><div class="fileUpload blue-btn btn width100"><span><i class="fas fa-upload"></i> Upload</span><input type="file" class="uploadlogo" name="additional_file[]" id="additional_file_' + i + '" /><input type="hidden" name="old_additional_file[]" id="old_additional_file_' + i + '" value="" /></div><label class="sow_msg error" id="additional_file_' + i + '_error"></label></td>';
        data += '<td>-N/A-</td></tr>';
        $(data).insertBefore($('#addRows'));
        $('#saveForm').removeClass('opacity5');
        $('#saveForm').css("pointer-events", "");
    });

    $('#deleteBtn').on('click', function () {
        $('#deletemodal').modal('show');
        var sel_item = $("input:checkbox[name=check_delete]:checked").length;
        $('#delCount').html(sel_item);
    });

    $('.check_box').on('click', function () {
        if ($("#diligenceDocuments input:checkbox:checked").length > 0) {
            $('#disableBtn').css("cursor", "pointer");
            $('#deleteBtn').css("pointer-events", "");
            $('#deleteBtn').removeClass('opacity5');
        } else {
            $('#disableBtn').css("cursor", "not-allowed");
            $('#deleteBtn').css("pointer-events", "none");
            $('#deleteBtn').addClass('opacity5');
        }
    });

    $('#deleteRecord').on('click', function () {
        var deleteId = new Array();
        $("input:checkbox[name=check_delete]:checked").each(function () {
            deleteId.push($(this).val());
        });

        if ($("#diligenceDocuments input:checkbox:checked").length > 0) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/portfolio/deletePortfolioDetail",
                data: {
                    id: deleteId,
                    table: 'diligence_document'
                },
                dataType: 'json',
                success: function (msg) {
                    location.reload();
                }
            });
        }
    });

</script>

<style type="text/css">
    label.error {
        display: block !important;
        text-align: left;
    }
</style>

</body>
</html>