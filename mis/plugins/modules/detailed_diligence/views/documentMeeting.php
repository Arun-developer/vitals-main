<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Villgro</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <!-- Rejection mail triggering on close action -->
    <?php
    $innovationID = $innovation['id'];
    $formAction = site_url('common/mail/form/' . $innovationID);
    ?>

    <div style="display:none;">
        <div align="center" id="mail_trigger" style="width:420px; height:180px;" >

            <h1 class="text-left reduce_space">Mail Confirmation</h1>
            <div>
                <p class="mailTriggerHead">Would you like to send the rejection email to the entrepreneur?</p>
                <p class="mailTrigger">Click OK to be redirected to the mailing section.</p>
                <p class="mailTrigger">Click Cancel to manually perform this operation later.</p>
                <div style="margin-top:20px;">
                    <a onclick="document.getElementById('templateForm').submit();" class="button triggerBtn">Ok</a>
                    <a onclick="$.fancybox.close()" class="button triggerBtn" id="mailTriggerCancel">Cancel</a>
                </div>
            </div>

        </div>
    </div>

    <a id="close_mail" class="fancybox button" href="#mail_trigger" style="display:none;"></a>


    <form name="templateForm" enctype="multipart/form-data" action="<?= $formAction ?>" method="post" id="templateForm" class="uniform" >
        <input type="hidden" name="innovation" value="<?= $innovation['id'] ?>"  />
        <input type="hidden" name="mail_type" value="Rejection"  />
    </form>


    <script>
        $(window).on('load', function () {
            var close_action = "<?php echo $this->session->userdata('close_action'); ?>";
            if (close_action == 'yes') {
                $("#close_mail").trigger('click');
            }
        });
    </script>
    <?php echo $this->session->unset_userdata('close_action'); ?>

    <body>

        <?php
        $suc_msg = $this->session->userdata['document_sucmsg'];
        $err_msg = $this->session->userdata['document_errmsg'];

        $current_tab = $this->session->userdata['document_active'];
        $document_tab = $meeting_tab = '';
        if ($current_tab == 2) {
            $meeting_tab = 'defaultOpen';
        } else {
            $document_tab = 'defaultOpen';
        }
        ?>

        <div id="form_employeelist" style="display:none;">
            <div align="center" id="form_container" style="height:400px;" >

                <form action="<?php echo site_url('scouting/onlyAssignIncharge'); ?>" id="assign" method="post">

                    <select id="associate_employee" data-placeholder="Select Employee" multiple class="" style="width:350px;height:330px;" tabindex="1"  name="associate_employee[]">
                        <?php
                        foreach ($usersList as $row) {
                            ?>
                            <option value="<?= $row['emp_number'] ?>" ><?= $row['emp_name'] ?></option>
                        <?php } ?>
                    </select>
                    <input type="hidden" name="dilegence" id="dilegence" value="1" />
                    <input type="hidden" name="innovations" id="innovations" />
                    <input type="hidden" name="form_name" id="form_name" value="dilegence" />
                    <br/><br/>
                    <div >
                        <input type="submit" name="txtSubmit" class="button" id="txtsub" value="Submit"/>
                    </div>
                </form>
            </div>
        </div>


        <div style="display:none;">
            <div align="center" id="status_log" style="width:800px; height:400px;" >

                <h1 class="text-left reduce_space">Application Status Log - Deals </h1>

                <table style="width:100%" id="table1" class="gtable sortable">
                    <thead style="border-bottom: 2px solid #ccc;">
                        <tr>
                            <th style="padding:5px;text-align: left;">Date</th>
                            <th style="padding:5px;text-align: left;">Time</th>
                            <th style="padding:5px;text-align: left;">Assigned Incharge</th>
                            <th style="padding:5px;text-align: left;">Updated By</th>
                            <th style="padding:5px;text-align: left;">Deal Stage</th>
                            <th style="padding:5px;text-align: left;">Deal Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($log_details as $row) {
                            $date = date('d-m-Y', strtotime($row['modified_date']));
                            $time = date('h:i A', strtotime($row['modified_date']));

                            $stage = $this->Minnovation->getInnvationStage();
                            $status = $this->Minnovation->getInnvationStatus();
                            $status_text = $status[$row['status']];
                            $stage_text = $stage[$row['stage']];
                            ?>


                            <tr>

                                <?php
                                if ($row['reason'] != '') {
                                    ?>
                                    <td colspan="6" style="padding:5px;text-align:center;font-weight:bold;"><?php echo $row['reason']; ?></td>
                                    <?php
                                } else {
                                    ?>

                                    <td style="padding:5px;"><?php echo $date; ?></td>
                                    <td style="padding:5px;"><?php echo $time; ?></td>
                                    <td style="padding:5px;"><?php echo $row['assigned_incharge']; ?></td>
                                    <td style="padding:5px;"><?php
                                        if ($row['modified_by_user'])
                                            echo $row['modified_by_user'];
                                        else
                                            echo 'Admin';
                                        ?></td>
                                    <td style="padding:5px;"><?php echo $stage_text; ?></td>
                                    <td style="padding:5px;"><?php echo $status_text; ?></td>

                                    <?php
                                }
                                ?>

                            </tr>


                            <?php
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="container">
            <?php
            if (isset($suc_msg) && $suc_msg != '') {
                ?>
                <p class="succ-msg"><i class="fa fa-check" aria-hidden="true">  <?= $suc_msg; ?></i></p>
                <?php
            }
            if (isset($err_msg) && $err_msg != '') {
                ?>
                <p class="err-msg"><i class="fa fa-exclamation-triangle" aria-hidden="true">  <?= $err_msg; ?></i></p>
                <?php
            }
            $this->session->unset_userdata('document_sucmsg');
            $this->session->unset_userdata('document_errmsg');
            $this->session->unset_userdata('document_active');
            ?>
            <div style="clear:both"></div>
            <div class="nav-enterpriseDetails">
                <ul class="inv-detail-status">
                    <li title="<?php echo ucfirst($innovation['name_of_enterprise']); ?>"><strong>Incubatee Name</strong>:&nbsp;
                        <?php
                        if (isset($innovation['name_of_enterprise']) && $innovation['name_of_enterprise'] != '') {
                            if (strlen($innovation['name_of_enterprise']) > 30) {
                                echo substr($innovation['name_of_enterprise'], 0, 30) . '...';
                            } else {
                                echo $innovation['name_of_enterprise'];
                            }
                        } else {
                            echo '-';
                        }
                        ?>


                    </li>
                    <li><strong>INV ID</strong>:&nbsp;<?php echo $inv_id_format; ?></li>
                    <li>
                        <strong>Assigned To</strong>:&nbsp;<?php echo isset($assign_to) && $assign_to != '' ? $assign_to : '-N/A-'; ?>
                    </li>
                </ul>
                <ul class="inv-detail-status">
                    <?php
                    $deal_sector = isset($sector[0]['sector']) && $sector[0]['sector'] != '' ? $sector[0]['sector'] : '-N/A-';
                    ?>
                    <li><strong>Sector</strong>:&nbsp;<?php echo $deal_sector; ?></li>
                    <li><strong>Stage</strong>:&nbsp;<?php echo $stage_name; ?></li>
                    <li>
                        <strong>Action</strong>:&nbsp;
                        <select id="action_value">
                            <option value="1">Close</option>
                            <option value="2" <?php
                            if ($innovation['status'] == '17') {
                                echo 'selected';
                            }
                            ?>>EIC Approve</option>
                            <option value="3" <?php
                            if ($innovation['status'] == '18') {
                                echo 'selected';
                            }
                            ?>>EIC Reject</option>
                                    <?php if ($innovation['status'] == '17' || $innovation['status'] == '20') { ?>
                                <option value="4" <?php
                                if ($innovation['status'] == '20') {
                                    echo 'selected';
                                }
                                ?>>Financial Negotiation</option>
                                    <?php } ?>
                        </select>
                        <span><a id="save_action" href="" class="fancybox button">Save</a></span>
                    </li>
                </ul>
                <ul class="inv-detail-status">
                    <li title="<?php echo $subsector; ?>"><strong><?php echo $subsec_title; ?></strong>:&nbsp;
                        <?php
                        if (isset($subsector) && $subsector != '') {
                            if (strlen($subsector) > 30) {
                                echo substr($subsector, 0, 30) . '...';
                            } else {
                                echo $subsector;
                            }
                        } else {
                            echo '-N/A-';
                        }
                        ?>
                    </li>
                    <li><strong>Status</strong>:&nbsp;<?php echo $status_name; ?></li>
                    <li>
                        <a id="logStatusModal" class="fancybox button" href="#status_log" style=" cursor:pointer;">Application Status Log</a>&nbsp;
                        <span><a id="assign_incharge" href="#form_container" class="fancybox button">Assign User</a></span>
                    </li>
                </ul>
            </div>

            <div class="enterpriseDetails-tab">
                <div class="tab">
                    <button class="tablinks" onclick="openCity(event, 'Paris')" id="<?= $document_tab; ?>">Documents</button>
                    <button class="tablinks" onclick="openCity(event, 'Tokyo')" id="<?= $meeting_tab; ?>">Meetings/ Call Notes</button>
                </div>


                <div id="Paris" class="tabcontent">
                    <div class="table-responsive">
                        <div id="my_docdiv">
                            <table class="scroll-code" id="document_table" width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table  width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <th width="25%" align="center">Documents Type<span class="req_field">*</span></th>
                                                    <th width="30%" align="center">Description<span class="req_field">*</span></th>
                                                    <th width="20%">Location/ View Documents<span class="req_field">*</span></th>
                                                    <th width="15%">Added Date</th>
                                                    <th width="10%" align="center"> Action </th>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <form name="ndaForm" id="ndaForm" method="post" action="<?php echo base_url() . 'index.php/detailed_diligence/save_document'; ?>" enctype="multipart/form-data">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="25%" align="left"><b>Signed NDA<span class="req_field">*</span></b></td>
                                                        <input type="hidden" name="id" id="id" value="<?php echo $innovationID; ?>" />
                                                        <input type="text" name='inv_id' id="inv_id" value="<?php echo $innovation['innovation_id']; ?>" />
                                                        <input type="hidden" name='doc_type' id="doc_type" value="1" />
                                                        <td width="30%" align="center">
                                                            <textarea name="txt_desc" id="txt_desc" rows="5" cols="50"><?php echo $nda_list[0]['description']; ?></textarea>
                                                        </td>
                                                        <?php
                                                        if ($nda_list[0]['document'] != '') {
                                                            $getFile = explode('_', $nda_list[0]['document']);
                                                            $get_ext = explode('.', $getFile['2']);
                                                            if (strlen($get_ext['0']) > 15) {
                                                                $nda_file = substr($get_ext['0'], 0, 15) . '...' . $get_ext[1];
                                                            } else {
                                                                $nda_file = $getFile['2'];
                                                            }
                                                        }
                                                        ?>
                                                        <td width="20%" align="center">
                                                            <input type="file" name="file_doc" id="file_doc" class="file-width" />
                                                            <input type="hidden" name="file_doc_old" id="file_doc_old" value="<?php echo isset($nda_list[0]['document']) ? $nda_list[0]['document'] : ''; ?>" />
                                                            <a class="uploadFiles" href="<?php echo base_url() . 'uploads/detailed_diligence/' . $nda_list[0]['document']; ?>" target="_blank"><?php echo $nda_file; ?></a>
                                                        </td>
                                                        <td width="15%" align="center"><p>
                                                                <?php
                                                                if (isset($nda_list[0]['created_at'])) {
                                                                    echo date('d/m/Y', strtotime($nda_list[0]['created_at']));
                                                                } else {
                                                                    echo '-N/A-';
                                                                }
                                                                ?>
                                                            </p></td>
                                                        <td width="10%" align="center">
                                                            <button class="button" type="submit"><i class="fa fa-check"></i></button>
                                                            <?php if ($nda_list[0]['description'] != '') { ?>

                                                                <button type="button" id="delDoc_<?php echo $nda_list[0]['id']; ?>" onclick="delete_document(<?php echo $nda_list[0]['id']; ?>);" class="Delete-btn">x</button>
                                                            <?php } ?>
                                                            <p class="del_msg" id="del_msg_<?php echo $nda_list[0]['id']; ?>"><i class="fa fa-check" aria-hidden="true"> Deleted</i></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <form name="questForm" id="questForm" method="post" action="<?php echo base_url() . 'index.php/detailed_diligence/save_document'; ?>" enctype="multipart/form-data">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="25%" align="left"><b>Questionnaire Responses<span class="req_field">*</span></b></td>
                                                        <input type="hidden" name="id" id="id" value="<?php echo $innovationID; ?>"> /
                                                            <input type="hidden" name='inv_id' id="inv_id" value="<?php echo $innovation['innovation_id']; ?>" />
                                                            <input type="hidden" name='doc_type' id="doc_type" value="2" />
                                                            <td width="30%" align="center">
                                                                <textarea name="txt_desc" id="txt_desc" rows="5" cols="50"><?php echo $quest_list[0]['description']; ?></textarea>
                                                            </td>
                                                            <?php
                                                            if ($quest_list[0]['document'] != '') {
                                                                $getFile = explode('_', $quest_list[0]['document']);
                                                                $get_ext = explode('.', $getFile['2']);
                                                                if (strlen($get_ext['0']) > 15) {
                                                                    $quest_file = substr($get_ext['0'], 0, 15) . '...' . $get_ext[1];
                                                                } else {
                                                                    $quest_file = $getFile['2'];
                                                                }
                                                            }
                                                            ?>
                                                            <td width="20%" align="center">
                                                                <input type="file" name="file_doc" id="file_doc" class="file-width" />
                                                                <input type="hidden" name="file_doc_old" id="file_doc_old" value="<?php echo isset($quest_list[0]['document']) ? $quest_list[0]['document'] : ''; ?>" />
                                                                <a class="uploadFiles" href="<?php echo base_url() . 'uploads/detailed_diligence/' . $quest_list[0]['document']; ?>" target="_blank"><?php echo $quest_file; ?></a>
                                                            </td>
                                                            <td width="15%" align="center"><p>
                                                                    <?php
                                                                    if (isset($quest_list[0]['created_at'])) {
                                                                        echo date('d/m/Y', strtotime($quest_list[0]['created_at']));
                                                                    } else {
                                                                        echo '-N/A-';
                                                                    }
                                                                    ?>
                                                                </p></td>
                                                            <td width="10%" align="center">
                                                                <button class="button" type="submit"><i class="fa fa-check"></i></button>
                                                                <?php if ($quest_list[0]['description'] != '') { ?>

                                                                    <button type="button" id="delDoc_<?php echo $quest_list[0]['id']; ?>" onclick="delete_document(<?php echo $quest_list[0]['id']; ?>);" class="Delete-btn">x</button>
                                                                <?php } ?>
                                                                <p class="del_msg" id="del_msg_<?php echo $quest_list[0]['id']; ?>"><i class="fa fa-check" aria-hidden="true"> Deleted</i></p>
                                                            </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <form name="termForm" id="termForm" method="post" action="<?php echo base_url() . 'index.php/detailed_diligence/save_document'; ?>" enctype="multipart/form-data">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="25%" align="left"><b>Term sheet<span class="req_field">*</span></b></td>
                                                        <input type="hidden" name="id" id="id" value="<?php echo $innovationID; ?>" />
                                                        <input type="hidden" name='inv_id' id="inv_id" value="<?php echo $innovation['innovation_id']; ?>" />
                                                        <input type="hidden" name='doc_type' id="doc_type" value="3" />
                                                        <td width="30%" align="center">
                                                            <textarea name="txt_desc" id="txt_desc" rows="5" cols="50"><?php echo $term_list[0]['description']; ?></textarea>
                                                        </td>
                                                        <?php
                                                        if ($term_list[0]['document'] != '') {
                                                            $getFile = explode('_', $term_list[0]['document']);
                                                            $get_ext = explode('.', $getFile['2']);
                                                            if (strlen($get_ext['0']) > 15) {
                                                                $term_file = substr($get_ext['0'], 0, 15) . '...' . $get_ext[1];
                                                            } else {
                                                                $term_file = $getFile['2'];
                                                            }
                                                        }
                                                        ?>
                                                        <td width="20%" align="center">
                                                            <input type="file" name="file_doc" id="file_doc" class="file-width" />
                                                            <input type="hidden" name="file_doc_old" id="file_doc_old" value="<?php echo isset($term_list[0]['document']) ? $term_list[0]['document'] : ''; ?>" />
                                                            <a class="uploadFiles" href="<?php echo base_url() . 'uploads/detailed_diligence/' . $term_list[0]['document']; ?>" target="_blank"><?php echo $term_file; ?></a>
                                                        </td>
                                                        <td width="15%" align="center"><p>
                                                                <?php
                                                                if (isset($term_list[0]['created_at'])) {
                                                                    echo date('d/m/Y', strtotime($term_list[0]['created_at']));
                                                                } else {
                                                                    echo '-N/A-';
                                                                }
                                                                ?>
                                                            </p></td>
                                                        <td width="10%" align="center">
                                                            <button class="button" type="submit"><i class="fa fa-check"></i></button>
                                                            <?php if ($term_list[0]['description'] != '') { ?>

                                                                <button type="button" id="delDoc_<?php echo $term_list[0]['id']; ?>" onclick="delete_document(<?php echo $term_list[0]['id']; ?>);" class="Delete-btn">x</button>
                                                            <?php } ?>
                                                            <p class="del_msg" id="del_msg_<?php echo $term_list[0]['id']; ?>"><i class="fa fa-check" aria-hidden="true"> Deleted</i></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <form name="serviceForm" id="serviceForm" method="post" action="<?php echo base_url() . 'index.php/detailed_diligence/save_document'; ?>" enctype="multipart/form-data">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="25%" align="left"><b>Service agreement<span class="req_field">*</span></b></td>
                                                        <input type="hidden" name="id" id="id" value="<?php echo $innovationID; ?>" />
                                                        <input type="hidden" name='inv_id' id="inv_id" value="<?php echo $innovation['innovation_id']; ?>" />
                                                        <input type="hidden" name='doc_type' id="doc_type" value="4" />
                                                        <td width="30%" align="center">
                                                            <textarea name="txt_desc" id="txt_desc" rows="5" cols="50"><?php echo $service_list[0]['description']; ?></textarea>
                                                        </td>
                                                        <?php
                                                        if ($service_list[0]['document'] != '') {
                                                            $getFile = explode('_', $service_list[0]['document']);
                                                            $get_ext = explode('.', $getFile['2']);
                                                            if (strlen($get_ext['0']) > 15) {
                                                                $serv_file = substr($get_ext['0'], 0, 15) . '...' . $get_ext[1];
                                                            } else {
                                                                $serv_file = $getFile['2'];
                                                            }
                                                        }
                                                        ?>
                                                        <td width="20%" align="center">
                                                            <input type="file" name="file_doc" id="file_doc" class="file-width" />
                                                            <input type="hidden" name="file_doc_old" id="file_doc_old" value="<?php echo isset($service_list[0]['document']) ? $service_list[0]['document'] : ''; ?>" />
                                                            <a class="uploadFiles" href="<?php echo base_url() . 'uploads/detailed_diligence/' . $service_list[0]['document']; ?>" target="_blank"><?php echo $serv_file; ?></a>
                                                        </td>
                                                        <td width="15%" align="center"><p>
                                                                <?php
                                                                if (isset($service_list[0]['created_at'])) {
                                                                    echo date('d/m/Y', strtotime($service_list[0]['created_at']));
                                                                } else {
                                                                    echo '-N/A-';
                                                                }
                                                                ?>
                                                            </p></td>
                                                        <td width="10%" align="center">
                                                            <button class="button" type="submit"><i class="fa fa-check"></i></button>
                                                            <?php if ($service_list[0]['description'] != '') { ?>

                                                                <button type="button" id="delDoc_<?php echo $service_list[0]['id']; ?>" onclick="delete_document(<?php echo $service_list[0]['id']; ?>);" class="Delete-btn">x</button>
                                                            <?php } ?>
                                                            <p class="del_msg" id="del_msg_<?php echo $service_list[0]['id']; ?>"><i class="fa fa-check" aria-hidden="true"> Deleted</i></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <form name="companyForm" id="companyForm" method="post" action="<?php echo base_url() . 'index.php/detailed_diligence/save_document'; ?>" enctype="multipart/form-data">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="25%" align="left"><b>Company presentation (EIC pitch)<span class="req_field">*</span></b></td>
                                                        <input type="hidden" name="id" id="id" value="<?php echo $innovationID; ?>" />
                                                        <input type="hidden" name='inv_id' id="inv_id" value="<?php echo $innovation['innovation_id']; ?>" />
                                                        <input type="hidden" name='doc_type' id="doc_type" value="5" />
                                                        <td width="30%" align="center">
                                                            <textarea name="txt_desc" id="txt_desc" rows="5" cols="50"><?php echo $compnay_list[0]['description']; ?></textarea>
                                                        </td>
                                                        <?php
                                                        if ($compnay_list[0]['document'] != '') {
                                                            $getFile = explode('_', $compnay_list[0]['document']);
                                                            $get_ext = explode('.', $getFile['2']);
                                                            if (strlen($get_ext['0']) > 15) {
                                                                $comp_file = substr($get_ext['0'], 0, 15) . '...' . $get_ext[1];
                                                            } else {
                                                                $comp_file = $getFile['2'];
                                                            }
                                                        }
                                                        ?>
                                                        <td width="20%" align="center">
                                                            <input type="file" name="file_doc" id="file_doc" class="file-width" />
                                                            <input type="hidden" name="file_doc_old" id="file_doc_old" value="<?php echo isset($compnay_list[0]['document']) ? $compnay_list[0]['document'] : ''; ?>" />
                                                            <a class="uploadFiles" href="<?php echo base_url() . 'uploads/detailed_diligence/' . $compnay_list[0]['document']; ?>" target="_blank"><?php echo $comp_file; ?></a>
                                                        </td>
                                                        <td width="15%" align="center"><p>
                                                                <?php
                                                                if (isset($compnay_list[0]['created_at'])) {
                                                                    echo date('d/m/Y', strtotime($compnay_list[0]['created_at']));
                                                                } else {
                                                                    echo '-N/A-';
                                                                }
                                                                ?>
                                                            </p></td>
                                                        <td width="10%" align="center">
                                                            <button class="button" type="submit"><i class="fa fa-check"></i></button>
                                                            <?php if ($compnay_list[0]['description'] != '') { ?>
                                                                <button type="button" id="delDoc_<?php echo $company_list[0]['id']; ?>" onclick="delete_document(<?php echo $company_list[0]['id']; ?>);" class="Delete-btn">x</button>
                                                            <?php } ?>
                                                            <p class="del_msg" id="del_msg_<?php echo $company_list[0]['id']; ?>"><i class="fa fa-check" aria-hidden="true"> Deleted</i></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <form name="villgroForm" id="villgroForm" method="post" action="<?php echo base_url() . 'index.php/detailed_diligence/save_document'; ?>" enctype="multipart/form-data">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td width="25%" align="left"><b>Villgro's EIC presentation<span class="req_field">*</span></b></td>
                                                        <input type="hidden" name="id" id="id" value="<?php echo $innovationID; ?>" />
                                                        <input type="hidden" name='inv_id' id="inv_id" value="<?php echo $innovation['innovation_id']; ?>" />
                                                        <input type="hidden" name='doc_type' id="doc_type" value="6" />
                                                        <td width="30%" align="center">
                                                            <textarea name="txt_desc" id="txt_desc" rows="5" cols="50"><?php echo $villgro_list[0]['description']; ?></textarea>
                                                        </td>
                                                        <?php
                                                        if ($villgro_list[0]['document'] != '') {
                                                            $getFile = explode('_', $villgro_list[0]['document']);
                                                            $get_ext = explode('.', $getFile['2']);
                                                            if (strlen($get_ext['0']) > 15) {
                                                                $vill_file = substr($get_ext['0'], 0, 15) . '...' . $get_ext[1];
                                                            } else {
                                                                $vill_file = $getFile['2'];
                                                            }
                                                        }
                                                        ?>
                                                        <td width="20%" align="center">
                                                            <input type="file" name="file_doc" id="file_doc" class="file-width" />
                                                            <input type="hidden" name="file_doc_old" id="file_doc_old" value="<?php echo isset($villgro_list[0]['document']) ? $villgro_list[0]['document'] : ''; ?>" />
                                                            <a class="uploadFiles" href="<?php echo base_url() . 'uploads/detailed_diligence/' . $villgro_list[0]['document']; ?>" target="_blank"><?php echo $vill_file; ?></a>
                                                        </td>
                                                        <td width="15%" align="center"><p>
                                                                <?php
                                                                if (isset($villgro_list[0]['created_at'])) {
                                                                    echo date('d/m/Y', strtotime($villgro_list[0]['created_at']));
                                                                } else {
                                                                    echo '-N/A-';
                                                                }
                                                                ?>
                                                            </p></td>
                                                        <td width="10%" align="center">
                                                            <button class="button" type="submit"><i class="fa fa-check"></i></button>
                                                            <?php if ($villgro_list[0]['description'] != '') { ?>
                                                                <button type="button" id="delDoc_<?php echo $villgro_list[0]['id']; ?>" onclick="delete_document(<?php echo $villgro_list[0]['id']; ?>);" class="Delete-btn">x</button>
                                                            <?php } ?>
                                                            <p class="del_msg" id="del_msg_<?php echo $villgro_list[0]['id']; ?>"><i class="fa fa-check" aria-hidden="true"> Deleted</i></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>

                                    <?php
                                    if (count($type_list) > 0) {
                                        for ($i = 0; $i < count($type_list); $i++) {
                                            ?>

                                            <tr>
                                                <td class="append_document">
                                                    <input type="hidden" id="doc_listcount" value="<?php echo count($type_list); ?>" />
                                                    <form name="typeForm" id="typeForm_<?= $i; ?>" class="addForm" method="post" action="<?php echo base_url() . 'index.php/detailed_diligence/save_document'; ?>" enctype="multipart/form-data">
                                                        <table width="100%" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <input type="hidden" name="id" id="id" value="<?php echo $innovationID; ?>" />
                                                                <input type="hidden" name='inv_id' id="inv_id" value="<?php echo $innovation['innovation_id']; ?>" />
                                                                <td width="25%" align="left" class="doc-errmsg">
                                                                    <select width="25%" style="width:160px;" name="doc_type" id="doc_type" class="doc_type">
                                                                        <option value="">--Select--</option>
                                                                        <?php foreach ($doc_type as $t) { ?>
                                                                            <option value="<?php echo $t['id']; ?>" <?php
                                                                            if ($t['id'] == $type_list[$i]['doc_type']) {
                                                                                echo "selected";
                                                                            }
                                                                            ?>><?php echo $t['name']; ?></option>
                                                                                <?php } ?>
                                                                    </select>
                                                                </td>
                                                                <td width="30%" align="center" class="doc-errmsg">
                                                                    <textarea name="txt_desc" id="txt_desc" rows="5" cols="50"><?php echo $type_list[$i]['description']; ?></textarea>
                                                                </td>
                                                                <?php
                                                                if ($type_list[$i]['document'] != '') {
                                                                    $getFile = explode('_', $type_list[$i]['document']);
                                                                    $get_ext = explode('.', $getFile['2']);
                                                                    if (strlen($get_ext['0']) > 15) {
                                                                        $type_file = substr($get_ext['0'], 0, 15) . '...' . $get_ext[1];
                                                                    } else {
                                                                        $type_file = $getFile['2'];
                                                                    }
                                                                }
                                                                ?>
                                                                <td width="20%" align="center" class="doc-errmsg">
                                                                    <input type="file" name="file_doc" id="file_doc" class="file-width" />
                                                                    <input type="hidden" name="file_doc_old" id="file_doc_old" value="<?php echo isset($type_list[$i]['document']) ? $type_list[$i]['document'] : ''; ?>" />
                                                                    <a class="uploadFiles" href="<?php echo base_url() . 'uploads/detailed_diligence/' . $type_list[$i]['document']; ?>" target="_blank"><?php echo $type_file; ?></a>
                                                                </td>
                                                                <td width="15%" align="center"><p id="show_date">
                                                                        <?php
                                                                        if (isset($type_list[$i]['created_at'])) {
                                                                            echo date('d/m/Y', strtotime($type_list[$i]['created_at']));
                                                                        } else {
                                                                            echo '-N/A-';
                                                                        }
                                                                        ?>
                                                                    </p></td>
                                                                <td width="10%" align="center">
                                                                    <button class="button doc_Add" id='doc_Add' type="submit"><i class="fa fa-check"></i></button>
                                                                    <?php if ($type_list[$i]['description'] != '') { ?>

                                                                        <button type="button" id="delDoc_<?php echo $type_list[$i]['detail_id']; ?>" onclick="delete_document(<?php echo $type_list[$i]['detail_id']; ?>);" class="Delete-btn">x</button>
                                                                    <?php } ?>
                                                                    <p class="del_msg" id="del_msg_<?php echo $type_list[$i]['detail_id']; ?>"><i class="fa fa-check" aria-hidden="true"> Deleted</i></p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </form>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                        <tr>
                                            <td id="doc_option"></td>
                                        </tr>

                                    <?php } else { ?>
                                        <tr>
                                            <td class="append_document">
                                                <form name="typeForm" id="typeForm_0" class="addForm" method="post" action="<?php echo base_url() . 'index.php/detailed_diligence/save_document'; ?>" enctype="multipart/form-data">
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <input type="hidden" name="id" id="id" value="<?php echo $innovationID; ?>" />
                                                            <input type="hidden" name='inv_id' id="inv_id" value="<?php echo $innovation['innovation_id']; ?>" />
                                                            <td width="25%" align="left" class="doc-errmsg">
                                                                <select width="25%" style="width:160px;" name="doc_type" id="doc_type" class="doc_type">
                                                                    <option value="">--Select--</option>
                                                                    <?php foreach ($doc_type as $t) { ?>
                                                                        <option value="<?php echo $t['id']; ?>"><?php echo $t['name']; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td width="30%" align="center" class="doc-errmsg">
                                                                <textarea name="txt_desc" id="txt_desc" rows="5" cols="50"></textarea>
                                                            </td>
                                                            <td width="20%" align="center" class="doc-errmsg">
                                                                <input type="file" name="file_doc" id="file_doc" class="file-width" />
                                                                <input type="hidden" name="file_doc_old" id="file_doc_old" value="" />
                                                            </td>
                                                            <td width="15%" align="center"><p id="show_date"><?php echo '-N/A-'; ?></p></td>
                                                            <td width="10%" align="center">
                                                                <button class="button doc_Add" id='doc_Add' type="submit"><i class="fa fa-check"></i></button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td id="doc_option"></td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                        <div>
                            <div class="width50 text-left">
                                <p class="mandatory"><span class="req_field">*</span> - Mandatory Documents</p>
                            </div>
                            <div class="width50 text-right">
                                <div id="docs_list">
                                    <a href="<?php echo base_url(); ?>index.php/screening/assign_checklist/<?php echo $innovationID; ?>" class="fancybox" id="master_docs">Refer Master List of Docs</a>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="addmore-btn">
                        <span><a href="javascript:" id="add_doc" class="button">+ Add More</a></span>
                    </div>
                </div>

                <div id="Tokyo" class="tabcontent">
                    <div class="table-responsive">

                        <table id="meeting_table" width="100%" cellpadding="0" cellspacing="0" >
                            <tbody>
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <th width="20%" align="center">Date<span class="req_field">*</span></th>
                                                <th width="20%" align="center">Meeting Type<span class="req_field">*</span></th>
                                                <th width="30%" align="center">Comments<span class="req_field">*</span></th>
                                                <th width="20%" align="center">Minutes Doc<span class="req_field">*</span></th>
                                                <th width="10%" align="center">Action</th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <?php
                                if (count($meeting_list) > 0) {
                                    for ($i = 0; $i < count($meeting_list); $i++) {
                                        ?>

                                        <tr>
                                            <td class="append_meeting">
                                                <form name="meetingForm" id="meetingForm_<?= $i; ?>" class="addmeetForm" method="post" action="<?php echo base_url() . 'index.php/detailed_diligence/save_meeting'; ?>" enctype="multipart/form-data">
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <input type="hidden" name="id" id="id" value="<?php echo $innovationID; ?>" />
                                                            <input type="hidden" name='inv_id' id="inv_id" value="<?php echo $innovation['innovation_id']; ?>" />
                                                            <input type="hidden" name='meeting_id' id="meeting_id" value="<?php echo $meeting_list[$i]['meeting_id']; ?>" />
                                                            <td width="20%">
                                                                <input type="text" name="meet_date" class="meet_date" value="<?php echo date('d-m-Y', strtotime($meeting_list[$i]['meeting_date'])); ?>"/>
                                                            </td>
                                                            <td width="20%" align="left">
                                                                <select name="meet_type" id="meet_type" class="meet_type" style="width:160px;">
                                                                    <option value="">--Select--</option>
                                                                    <?php foreach ($meeting_type as $m) { ?>
                                                                        <option value="<?php echo $m['id']; ?>" <?php
                                                                        if ($m['id'] == $meeting_list[$i]['meeting_type']) {
                                                                            echo "selected";
                                                                        }
                                                                        ?>><?php echo $m['name']; ?></option>
                                                                            <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td width="30%">
                                                                <textarea name="meet_desc" id="meet_desc" rows="5" cols="50"><?php echo $meeting_list[$i]['comments']; ?></textarea>
                                                            </td>
                                                            <?php
                                                            if ($meeting_list[$i]['meeting_doc'] != '') {
                                                                $getFile = explode('_', $meeting_list[$i]['meeting_doc']);
                                                                $get_ext = explode('.', $getFile['2']);
                                                                if (strlen($get_ext['0']) > 15) {
                                                                    $type_file = substr($get_ext['0'], 0, 15) . '...' . $get_ext[1];
                                                                } else {
                                                                    $type_file = $getFile['2'];
                                                                }
                                                            }
                                                            ?>
                                                            <td width="20%" align="center">
                                                                <input type="file" name="meet_doc" id="meet_doc" class="file-width" />
                                                                <input type="hidden" name="meet_doc_old" id="meet_doc_old" value="<?php echo isset($meeting_list[$i]['meeting_doc']) ? $meeting_list[$i]['meeting_doc'] : ''; ?>" />
                                                                <a class="uploadFiles" href="<?php echo base_url() . 'uploads/detailed_diligence/' . $meeting_list[$i]['meeting_doc']; ?>" target="_blank"><?php echo $type_file; ?></a>
                                                            </td>
                                                            <td width="10%" align="center">
                                                                <button class="button meet_Add" id="meet_Add" type="submit"><i class="fa fa-check"></i></button>
                                                                <?php if ($meeting_list[$i]['comments'] != '') { ?>
                                                                    <button type="button" id="delMeet_<?php echo $meeting_list[$i]['meeting_id']; ?>" onclick="delete_meeting(<?php echo $meeting_list[$i]['meeting_id']; ?>);" class="Delete-btn">x</button>
                                                                <?php } ?>
                                                                <p class="del_msg" id="del_meet_<?php echo $meeting_list[$i]['meeting_id']; ?>"><i class="fa fa-check" aria-hidden="true"> Deleted</i></p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </td>
                                        </tr>

                                    <?php } ?>

                                <?php } else { ?>

                                    <tr>
                                        <td class="append_meeting">
                                            <form name="meetingForm" id="meetingForm_0" class="addmeetForm" method="post" action="<?php echo base_url() . 'index.php/detailed_diligence/save_meeting'; ?>" enctype="multipart/form-data">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <input type="hidden" name="id" id="id" value="<?php echo $innovationID; ?>" />
                                                        <input type="hidden" name='inv_id' id="inv_id" value="<?php echo $innovation['innovation_id']; ?>" />
                                                        <td width="20%">
                                                            <input type="text" name="meet_date" class="meet_date"/>
                                                        </td>
                                                        <td width="20%" align="left">
                                                            <select name="meet_type" id="meet_type" class="meet_type" style="width:160px;">
                                                                <option value="">--Select--</option>
                                                                <?php foreach ($meeting_type as $m) { ?>
                                                                    <option value="<?php echo $m['id']; ?>"><?php echo $m['name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td width="30%"><textarea name="meet_desc" id="meet_desc" rows="5" cols="50"></textarea></td>
                                                        <td width="20%" align="center">
                                                            <input type="file" name="meet_doc" id="meet_doc" class="file-width" />
                                                            <input type="hidden" name="meet_doc_old" id="meet_doc_old" value="" />
                                                        </td>
                                                        <td width="10%" align="center">
                                                            <button class="button meet_Add" id="meet_Add" type="submit"><i class="fa fa-check"></i></button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>

                                <?php } ?>

                                <tr>
                                    <td id="meet_option"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="addmore-btn">
                        <span><a href="javascript:" id="add_meet" class="button">+ Add More</a></span>
                    </div>
                </div>
                <div style="clear:both"></div>
            </div>
            <div style="clear:both"></div>
        </div>

        <div style="display:none;">
            <div id="dateModal" class="global_search" align="center" style="width:500px;">
                <h1 class="text-left reduce_space">Select start date of <span id='eic_title'></span></h1>
                <div class="modal-body">
                    <br/>
                    <label>Choose date : </label>
                    <input type="text" name="status_change_date" id="status_change_date" style="padding: 5px;" value="<?= $eic_date; ?>" />
                </div>
                <br/>
                <input type="button" value="Submit" id='dateSubmit' class="button" />
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                var kk = $('#doc_listcount').val();
                if (kk == 8)
                    $('#add_doc').hide();
            });

            $(document).on("focus", ".meet_date", function () {
                if ($(this).hasClass('hasDatepicker') === false) {
                    $(this).datepicker({dateFormat: 'dd-mm-yy'});
                }
            });

            $(document).on('click', '#add_doc', function () {

                var selectvalues = '<select width="25%" style="width:160px;" name="doc_type" id="doc_type" class="doc_type">';
                var i = 0;
                var datas = $('.append_document').html();
                var select_values = $('.doc_type').html();

                $("#doc_option").append(datas);
                var formLength = $('#doc_option').find('.addForm').length;
                $('#doc_option').find('.addForm:last').attr("id", "typeForm_" + formLength);

                $('#doc_option').find('.addForm:last label.error').hide();
                $('#doc_option').find('.addForm:last .error').removeClass("error");

                $('.doc_type').each(function (key, value) {
                    var doc_value = $(this).val();
                    $("#doc_option").find(".addForm:last").attr('id', 'typeForm_' + i);
                    if (doc_value != '') {
                        $("#doc_option").find(".doc_type:last option[value='" + doc_value + "']").remove();
                    }
                    $("#doc_option").find("#txt_desc:last").val('');
                    $("#doc_option").find("#file_doc_old:last").val('');
                    $("#doc_option").find(".uploadFiles:last").text('');
                    $("#doc_option").find("#show_date:last").text('-N/A-');
                    $("#doc_option").find(".Delete-btn:last").remove();
                    i = i + 1;
                });

                var count = $("#doc_option").find(".doc_type:last option").length;
                if (count == 2) {
                    $('#add_doc').hide();
                }
            });

            function delete_document(id) {
                var app = confirm("Are you sure to delete this?");
                if (app == true) {
                    var current_url = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/detailed_diligence/delete_action",
                        data: {table: 'diligence_document', id: id},
                        success: function (msg) {
                            $('#delDoc_' + id).hide();
                            $('#del_msg_' + id).show();
                            setTimeout(function () {
                                $('#del_msg_' + id).hide();
                                $("#document_table").load(current_url + " #document_table");
                            }, 3000);
                            setTimeout(function () {
                                var kk = $('#doc_listcount').val();
                                if (kk != 8)
                                    $('#add_doc').show();
                            }, 5000);
                        },
                    });
                }
            }

            $(document).on('click', '#add_meet', function () {
                var selectvalues = '<select width="25%" style="width:160px;" name="meet_type" id="meet_type" class="meet_type">';
                var i = 0;
                var datas = $('.append_meeting').html();
                $("#meet_option").append(datas);

                var today = new Date();
                var dd = ("0" + (today.getDate())).slice(-2);
                var mm = ("0" + (today.getMonth() + 　1)).slice(-2);
                var yyyy = today.getFullYear();
                today = dd + '-' + mm + '-' + yyyy;

                var formLength = $('#meet_option').find('.addmeetForm').length;
                $('#meet_option').find('.addmeetForm:last').attr("id", "meetingForm_" + formLength);

                $('#meet_option').find('.addmeetForm:last label.error').hide();
                $('#meet_option').find('.addmeetForm:last .error').removeClass("error");

                $('.meet_type').each(function (key, value) {
                    $("#meet_option").find("#meeting_id:last").val('');
                    $("#meet_option").find(".addmeetForm:last").attr('id', 'meetingForm_' + i);
                    $("#meet_option").find("#meet_desc:last").val('');
                    $("#meet_option").find("#meet_type:last option:selected").removeAttr('selected');
                    $("#meet_option").find("#meet_doc_old:last").val('');
                    $("#meet_option").find(".uploadFiles:last").text('');
                    $("#meet_option").find(".meet_date:last").removeAttr('id').removeClass('hasDatepicker').val(today);
                    $("#meet_option").find(".Delete-btn:last").remove();
                    i = i + 1;
                });

            });

            function delete_meeting(id) {
                var app = confirm("Are you sure to delete this?");
                if (app == true) {
                    var current_url = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/detailed_diligence/delete_action",
                        data: {table: 'diligence_meeting', id: id},
                        success: function (msg) {
                            $('#delMeet_' + id).hide();
                            $('#del_meet_' + id).show();
                            setTimeout(function () {
                                $('#del_meet_' + id).hide();
                                $("#meeting_table").load(current_url + " #meeting_table");
                            }, 3000);
                        },
                    });
                }
            }

        </script>

        <style>
            .triggerBtn{
                font-size:14px;
            }
            .mailTrigger {
                font-size: 14px;
                text-align:left;
                margin-bottom:0px;
            }
            .mailTriggerHead{
                font-size: 14px;
                text-align:left;
                margin-bottom:10px;
                font-weight:600;
            }
            td > form {
                margin:0px !important;
            }
            .succ-msg{
                font-size: 14px;
                color: green;
                text-align: center;
                font-weight: 600;
                background-color: #E9F1D1;
                padding: 5px 0px;
                border-radius: 7px;
                margin-top: 20px;
            }
            .err-msg {
                font-size: 14px;
                color: red;
                text-align: center;
                font-weight: 600;
                background-color: rgba(255, 0, 0, 0.2);
                padding: 5px 0px;
                border-radius: 7px;
                margin-top: 20px;
            }
            .width50{
                width: 50%;
                float: left;
            }
            #docs_list{
                margin: 10px 5px;

            }
            #docs_list a {
                text-decoration: underline;
                font-weight: 600;
                font-size: 12px;
            }
            .text-right{
                text-align: right;
            }
            .del_msg {
                display: none;
                font-size: 14px;
                color: red;
                text-align: center;
                font-weight: 600;
            }
            #docs_list #fancybox-content {
                border-width: 10px;
                width: 605px !important;
                height: auto;
            }
            .divExport{display: block;margin: 30px 0 10px;text-align: center;}
            .dtHorizontalExampleWrapper {
                max-width: 600px;
                margin: 0 auto;
            }
            #dtHorizontalExample th, td {
                white-space: nowrap;
            }
            textarea{
                overflow:hidden;
                width:250px !important;
                resize: none;
            }
            .file-width {width: 150px;}
            td, th {
                vertical-align: middle;
            }
            .nav-enterpriseDetails{
                background-color: #ffffff;
                padding: 15px 15px 10px 15px;
                display: flex;
                width: 97%;
                margin: 10px 0;
                box-shadow: 0px 1px 20px rgba(0,0,0,0.09);
                border-radius: 4px;
                margin-top:30px;
            }
            .uploadFiles{
                display: block;
            }
            ul.inv-detail-status {
                width: 33.333%;
                float: left;
                display: block;
            }
            ul.inv-detail-status li{
                padding: 8px 0px;
                border-bottom: 1px solid #ccc;
            }
            ul.inv-detail-status li:last-child{
                border-bottom: none;
                display:flex;
                align-items: center;
                height:35px;
            }
            ul.inv-detail-status li strong {
                width: 32%;
                display: inline-block;
            }
            ul.inv-detail-status li form {
                width: 100%;
            }
            .enterpriseDetails-tab{
                padding:20px 0px;
            }
            .enterpriseDetails-tab table tr th{
                background-color: #d1deab;
                color: #000;
                text-align: center;
                padding: 10px 5px;
                border-right: 1px solid #5d7d00;
                border-bottom: 2px solid #5f8d4a;
                vertical-align: middle;
            }

            .enterpriseDetails-tab table tr th:last-child{
                border-right: 1px solid #b4cc71;
            }
            .enterpriseDetails-tab table tr td table tr td{
                padding: 10px 5px;
                border: 1px solid #ccc;
            }
            .enterpriseDetails-tab table tr td table tr td .error{
                display: block;
                font-weight: 600;
                text-align: left;
                padding-top: 5px;
            }
            .enterpriseDetails-button ul li{
                display: inline-block;
            }
            .enterpriseDetails-button{
                padding:10px 0px 20px;
            }
            .enterpriseDetails-button ul li a {
                background-color: #5f8d4a;
                color: #fff;
                padding: 7px 12px;
                font-weight: 600;
                border-radius: 2px;
                margin-right: 10px;
            }
            /* Style the tab */
            .tab {
                float: left;
                background-color: #8eb37d;
                width: 100%;
                position:relative;
            }
            /* Style the buttons inside the tab */
            .tab button {
                display: block;
                background-color: #8eb17f;
                color: #fdfdfd;
                padding: 15px 16px;
                width: 50%;
                float: left;
                border: none;
                outline: none;
                text-align: center;
                cursor: pointer;
                transition: 0.3s;
                font-size: 14px;
                border-bottom: 2px solid #5e864c;
                border-right: 2px solid #5e864c;
            }
            .mandatory {
                font-size: 12px;
                color: #ff0000;
                font-weight: 600;
                padding: 10px 5px;
            }

            /* Change background color of buttons on hover */
            .tab button:hover {
                background-color: #5e864c;
            }

            /* Create an active/current "tab button" class */
            .tab button.active {
                background-color: #5e864c;
                position: relative;
            }


            /* Style the tab content */
            .tabcontent {
                float: left;
                padding: 15px 10px   ;
                width: 98%;
                border-left: none;
                background: #ffffff;
                min-height:300px;
                border: 1px solid #5e864c;
                position:relative;
            }
            .addmore-btn{
                display: block !important;
                padding: 20px 0px;
                text-align:right;
            }

            .refer_text{
                border: 0 !important;
                outline: 0;
                background: transparent !important;
                border-bottom: 1px solid #333 !important;
            }
            textarea {resize: none;width: 65%;}
            .check {
                margin: 8px !important;
            }
            form input[type="radio"]{
                margin-top: 3px;
            }
            .business-details dt{
            }
            .description-table1 tr{
                display:flex;
                align-items: center;
            }
            .description-table1 tr th{
                border-bottom:none;
            }

            .gridShow-details{
                padding:0px;
            }
            .gridShow-details .column{
                border: 1px solid #eee;
                padding:0px;
            }
            .gridShow-details .column label {
                font-weight: 600;
                color: #000;
                font-size: 13px;
                padding: 10px 1px 6px 10px;
                display: block;
            }
            .gridShow-details .column p {
                padding: 0px 10px 10px 10px;
                color: #666;
                line-height: 22px;
                text-align: left;
                letter-spacing: 0.2px;
                font-size: 13px;
            }
            .wdt-50{
                float:left;
                width:49%;
            }
            .wdt-98{
                width: 98%;
                padding:1px !important;
                display: block;
            }
            .heading-address{
                padding: 10px 0;
                text-align: center;
                display: block;
                color:#60615f;
            }
            .bg-gray{
                background-color: #eee;

            }
            .questionnaire{
                width: 100%;
                margin: 30px 0px 10px;
                display: flex;
                height: 40px;
                align-items: center;
            }
            .half-wdt{
                width:50%;
                float: left;
            }
            .half-wdt label{
                font-size: 13px;
                font-weight: 600;
                color: #333;
                float: right;
                padding-right: 20px;
            }
            .save-btn {
                background: #5e864c  !important;
                padding: 7px 10px;
                font-size: 12px;
                color: #fff;
                border-radius: 1px;
                box-shadow: 0px 5px 20px rgba(0,0,0,0.12);
            }

            .AddMore-btn {
                background: #ee992b !important;
                padding: 7px 10px;
                font-size: 12px;
                color: #fff;
                border-radius: 1px;
                box-shadow: 0px 5px 20px rgba(0,0,0,0.12);
            }
            .Edit-btn {
                background: #8eb37d  !important;
                padding: 7px 10px;
                font-size: 12px;
                color: #fff;
                border-radius: 1px;
                box-shadow: 0px 5px 20px rgba(0,0,0,0.12);
                display:none;
            }
            a:hover{
                color: #333 !important;
            }
            form textarea{
                background: #fff !important;
                border-bottom: 1px solid #8eb37d !important;
                border-left: none !important;
                border-right: none !important;
                border-top: none !important;
                border-radius: 0 !important;
            }

            .Darkedit-btn {
                cursor: pointer;
                background: #36c6ad;
                padding: 6px 26px;
                font-size: 14px;
                color: #fff;
                border-radius: 30px;
                border: none;
                box-shadow: 0px 5px 20px rgba(0,0,0,0.12);
                text-align: center;
            }
            .Delete-btn {
                cursor: pointer;
                background: rgba(255, 0, 0, 1);
                padding: 6px 12px;
                font-size: 14px;
                color: #fff;
                border-radius: 4px;
                margin-top: 15px;
                border: none;
                box-shadow: 0px 5px 20px rgba(0,0,0,0.12);
                text-align: center;
            }

            .position_Abs{
                position: absolute;
                bottom:30px;
                left:50%;
            }
            .table-responsive {
                width: 100%;
                overflow: auto;
                display: block !important;
            }
            form input[type="text"] {
                background: #fff !important;
                border-bottom: 1px solid #8eb37d !important;
                border-left: none !important;
                border-right: none !important;
                border-top: none !important;
                border-radius: 0 !important;
            }
            form input[type="date"] {
                background: #fff !important;
                border-bottom: 1px solid #8eb37d !important;
                border-left: none !important;
                border-right: none !important;
                border-top: none !important;
                border-radius: 0 !important;
            }
            select{
                background: #fff;
                padding: 5px 2px;
                border-radius: 4px;
                border: 1px solid #ccc;
                margin-right: 7px;
            }


            #fancybox-content > div {
                overflow-x: hidden !important;
            }
        </style>

    </body>

    <script type="text/javascript">

        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        document.getElementById("defaultOpen").click();

        $(document).ready(function () {
            var today = new Date();
            var dd = ("0" + (today.getDate())).slice(-2);
            var mm = ("0" + (today.getMonth() + 　1)).slice(-2);
            var yyyy = today.getFullYear();
            today = dd + '-' + mm + '-' + yyyy;

            var curDate = $('.meet_date').val();
            if (curDate == '') {
                $('.meet_date').val(today);
            }

            $('.del_msg').hide();
            setTimeout(function () {
                $('.succ-msg').hide();
                $('.err-msg').hide();
            }, 5000);

            $('#dtHorizontalExample').DataTable({
                "scrollX": true
            });
            $('.dataTables_length').addClass('bs-select');
        });

        $('textarea').keyup(function () {
            $(this).scrollTop(9999);
        });

        $(document).on('keyup', 'textarea', function () {
            if (this.value.match(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g)) {
                this.value = this.value.replace(/[^a-zA-Z0-9\n.,"():&'\-/ ]/g, '');
            }
        });

        $.validator.addMethod("extension", function (value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, '|') : "doc|docx|xls|xlsx|ppt|pptx|pdf";
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        }, "Not a valid file format.");

        $.validator.addMethod("maxfilesize", function (value, element) {
            return this.optional(element) || (element.files && element.files[0] && element.files[0].size <= 10008250);
        }, $.format('The file size cannot exceed 10MB.'));

        $('#ndaForm').validate({
            rules: {
                txt_desc: {required: true},
                file_doc: {required: '#file_doc_old:blank', extension: true, maxfilesize: true}
            },
            messages: {
                txt_desc: {required: "Enter description"},
                file_doc: {required: "Choose file"},
            }
        });

        $('#questForm').validate({
            rules: {
                txt_desc: {required: true},
                file_doc: {required: '#file_doc_old:blank', extension: true, maxfilesize: true}
            },
            messages: {
                txt_desc: {required: "Enter description"},
                file_doc: {required: "Choose file"},
            }
        });

        $('#termForm').validate({
            rules: {
                txt_desc: {required: true},
                file_doc: {required: '#file_doc_old:blank', extension: true, maxfilesize: true}
            },
            messages: {
                txt_desc: {required: "Enter description"},
                file_doc: {required: "Choose file"},
            }
        });

        $('#serviceForm').validate({
            rules: {
                txt_desc: {required: true},
                file_doc: {required: '#file_doc_old:blank', extension: true, maxfilesize: true}
            },
            messages: {
                txt_desc: {required: "Enter description"},
                file_doc: {required: "Choose file"},
            }
        });

        $('#companyForm').validate({
            rules: {
                txt_desc: {required: true},
                file_doc: {required: '#file_doc_old:blank', extension: true, maxfilesize: true}
            },
            messages: {
                txt_desc: {required: "Enter description"},
                file_doc: {required: "Choose file"},
            }
        });

        $('#villgroForm').validate({
            rules: {
                txt_desc: {required: true},
                file_doc: {required: '#file_doc_old:blank', extension: true, maxfilesize: true}
            },
            messages: {
                txt_desc: {required: "Enter description"},
                file_doc: {required: "Choose file"},
            }
        });

        $(document).on("click", ".doc_Add", function () {
            var form_id = $(this).closest(".addForm").attr("id");
            $('#' + form_id).validate({
                rules: {
                    doc_type: {required: true},
                    txt_desc: {required: true},
                    file_doc: {required: '#file_doc_old:blank', extension: true, maxfilesize: true}
                },
                messages: {
                    doc_type: {required: 'Choose document type'},
                    txt_desc: {required: "Enter description"},
                    file_doc: {required: "Choose file"},
                }
            });
        });

        $(document).on("click", ".meet_Add", function () {
            var form_id = $(this).closest(".addmeetForm").attr("id");
            $('#' + form_id).validate({
                rules: {
                    meet_date: {required: true},
                    meet_type: {required: true},
                    meet_desc: {required: true},
                    meet_doc: {required: '#meet_doc_old:blank', extension: true, maxfilesize: true}
                },
                messages: {
                    meet_date: {required: 'Choose date'},
                    meet_type: {required: 'Choose document type'},
                    meet_desc: {required: "Enter description"},
                    meet_doc: {required: "Choose file"},
                }
            });
        });

        $(document).ready(function () {
            var isAdmin = "<?php echo $this->session->userdata('isAdmin'); ?>";
            var isPartner = "<?php echo $this->session->userdata('partner_id'); ?>";
            var isAssociate = "<?php echo $innovation['isAssociate']; ?>";
            if ((isAssociate != '1' && isAdmin != 'Yes') || isPartner == '') {
                $(".container :input:not(.tablinks)").attr("disabled", true);
                $('.container a:not(:.uploadFiles, #logStatusModal, #master_docs)').css('pointer-events', 'none');
            }

            var action_val = $('#action_value').val();
            changeAction(action_val);

            $("#status_change_date").datepicker({dateFormat: 'dd-mm-yy'});
            var date = $('#status_change_date').val();
            if (date == '01-01-1970' || date == '') {
                $("#status_change_date").datepicker("setDate", new Date());
            }
        });

        $(document).on('click', '#assign_incharge', function () {
            Populate();
        });

        function Populate() {
            var invID = "<?php echo $id; ?>";
            $('#innovations').val(invID);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/scouting/getassemployee",
                data: {id: invID},
                dataType: 'json',
                success: function (msg) {
                    var arr = msg;
                    for (var prop in arr)
                    {
                        $('#associate_employee option').map(function () {
                            if (arr[prop]['associate_employee'] == $(this).val()) {
                                $(this).attr("selected", 'selected');
                            }
                        });
                    }
                },
            });
        }

        $(document).on('change', '#action_value', function () {
            var txt = $(this).val();
            changeAction(txt);
        });

        function changeAction(txt) {
            if (txt == 2) {
                $('#eic_title').html('EIC accept');
            } else if (txt == 3) {
                $('#eic_title').html('EIC reject');
            }
            if (txt == 4) {
                $('#eic_title').html('financial negotiations');
            }

            if (txt == 2 || txt == 3 || txt == 4) {
                $("#save_action").attr("href", "#dateModal");
            } else {
                $("#save_action").attr("href", "<?= site_url('scouting/action/close/' . $innovationID); ?>");
            }
        }

        $(document).on('click', '#dateSubmit', function () {
            var action_value = $('#action_value').val();
            var new_date = $('#status_change_date').val();
            var invID = "<?php echo $innovation['id']; ?>";
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/scouting/eir_action",
                data: {id: invID, action: action_value, action_date: new_date},
                dataType: 'json',
                success: function (msg) {
                    location.reload(true);
                },
            });
            $.fancybox.cancel();
        });

    </script>

</html>
