
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
    <input type="hidden" id="load_subsec" value="<?php echo $sector[0]['id']; ?>" />
    <input type="hidden" id="select_subsec" value="<?php echo $subSectorName[0]['id']; ?>" />

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
        <div id="form_employeelist" style="display:none;">
            <div align="center" id="form_container" style="height:400px;" >

                <form action="<?php echo site_url('scouting/onlyAssignIncharge'); ?>" id="assign" method="post">
                    <select id="associate_employee" data-placeholder="Select Employee" multiple class="" style="width:350px;height:330px;" tabindex="1"  name="associate_employee[]">
                        <?php
                        foreach ($usersList as $row) {
                            ?>
                            <option value="<?= $row['emp_number'] ?>" ><?= $row['emp_name'] ?></option>
                        <?php }
                        ?>
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

        <?php
        $tab = $this->session->userdata('company_tab');
        if (php72_cmp($tab) == 2) {
            $management = 'defaultOpen';
        } elseif (php72_cmp($tab) == 3) {
            $cap = 'defaultOpen';
        } else {
            $master = 'defaultOpen';
        }
        $this->session->unset_userdata('company_tab');
        ?>


        <div class="container">
            <?php
            $teamcount = php72_count($teamData);
            $sharecount = php72_count($shareData);
            $suc_msg = $this->session->userdata['company_sucmsg'];

            $date_value = $masterData[0]['incorporation_date'];
            $format_date = date('d-m-Y', strtotime($date_value));


            if (isset($suc_msg) && $suc_msg != '') {
                ?>
                <p class="succ-msg"><i class="fa fa-check" aria-hidden="true">  <?= $suc_msg; ?></i></p>
                <?php
            }
            $this->session->unset_userdata('company_sucmsg');
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
                        <form>
                            <strong>Assigned To</strong>:&nbsp;<?php echo isset($assign_to) && $assign_to != '' ? $assign_to : '-N/A-'; ?>
                        </form>
                    </li>
                </ul>
                <ul class="inv-detail-status">
                    <?php
                    $deal_sector = isset($sector[0]['sector']) && $sector[0]['sector'] != '' ? $sector[0]['sector'] : '-N/A-';
                    ?>
                    <li><strong>Sector</strong>:&nbsp;<?php echo $deal_sector; ?></li>
                    <li><strong>Stage</strong>:&nbsp;<?php echo $stage_name; ?></li>
                    <li>
                        <form>
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
                        </form>
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
                    <div class="left-sticky">
                        <button class="tablinks" onclick="openBlock(event, 'Master')" id="<?php echo $master; ?>" >Company Master Data</button>
                        <button class="tablinks" onclick="openBlock(event, 'Management')" id="<?php echo $management; ?>">Management Team</button>
                        <button class="tablinks" onclick="openBlock(event, 'Table')" id="<?php echo $cap; ?>">Cap Table</button>
                    </div>
                </div>

                <div id="Master" class="tabcontent">
                    <form name="master_data" action="<?php echo site_url('detailed_diligence/master_data'); ?>" method="post" id="master_data" class="uniform">
                        <div class="gridShow-details">
                            <div class="column wdt-98">
                                <label>Brief description of business </label>
                                <textarea name="description" id="description" maxlength="1000" rows="3" cols="30"><?php echo ((isset($masterData[0]['business_description']) && $masterData[0]['business_description']) ? $masterData[0]['business_description'] : $main_data[0]['summary_of_business']); ?></textarea>
                            </div>
                            <div class="column wdt-50">
                                <label>CIK #</label>
                                <input type="text" name="cik" id="cik" value="<?php echo ((isset($masterData[0]['cik'])) ? $masterData[0]['cik'] : ""); ?>" />
                            </div>
                            <div class="column wdt-50">
                                <label>Stage of incubatee </label>
                                <input type="text" name="stage" id="stage" readonly="" value="<?php echo isset($innovation['enterprise_stage']) && $innovation['enterprise_stage'] != '' ? $innovation['enterprise_stage'] : $stage_name; ?>" />
                            </div>
                            <div style="clear:both"></div>
                            <div class="column wdt-50">
                                <label>Sector</label>
                                <select id="sector" name="sector" onchange="subsector(this.value)" style="width:200px;">
                                    <option value="">-Select</option>
                                    <?php
                                    foreach ($sectors_values as $row) {
                                        ?>
                                        <option value="<?php echo $row['id']; ?>" <?php
                                        if ($masterData[0]['sector'] == $row['id']) {
                                            echo 'selected';
                                        } else if ($main_data[0]['sector'] == $row['id']) {
                                            echo 'selected';
                                        }
                                        ?> ><?php echo $row['sector']; ?></option>
                                                <?php
                                            }
                                            ?>
                                </select>
                            </div>
                            <?php if (php72_cmp($innv_pool[0]['partner_id']) != 10) { ?>
                                <div class="column wdt-50">
                                    <label>Sub Sector</label>
                                    <select id="sub_sector" name="sub_sector" style="width:200px;">
                                        <option value="">-Select</option>
                                        <?php if ($subSectorName[0]['sector'] != '') { ?>
                                            <option value="<?php echo $subSectorName[0]['id']; ?>" selected><?php echo $subSectorName[0]['sector']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <div style="clear:both"></div>
                            <div class="column wdt-50">
                                <label>Date of incorporation</label>
                                <input type="text" name="incorporation_date" id="incorporation_date" value="<?php echo isset($format_date) ? $format_date : ''; ?>" />
                            </div>
                            <div class="column wdt-50">
                                <label>Invention</label>
                                <select name="invention" id="invention" style="width:200px;">
                                    <option value="1" <?php if ($masterData[0]['invention'] == '1') { ?> selected <?php } ?> >Yes</option>
                                    <option value="2" <?php if ($masterData[0]['invention'] == '2') { ?> selected <?php } ?> >No</option>
                                </select>
                            </div>
                            <div style="clear:both"></div>
                            <div class="column wdt-98 bg-gray">
                                <b class="heading-address">Registered Office address</b >
                            </div>
                            <div style="clear:both"></div>
                            <div class="column wdt-98">
                                <label>Address</label>
                                <textarea name="reg_address" rows="3" cols="30"><?php echo ((isset($masterData[0]['reg_office_address']) && $masterData[0]['reg_office_address'] != '') ? $masterData[0]['reg_office_address'] : (isset($main_data[0]['address1']) ? $main_data[0]['address1'] : '')); ?></textarea>
                            </div>
                            <div class="column wdt-50">
                                <label>City</label>
                                <input type="text" name="reg_city" value="<?php echo isset($masterData[0]['reg_city']) && $masterData[0]['reg_city'] != '' ? $masterData[0]['reg_city'] : $main_data[0]['city']; ?>" />
                            </div>
                            <div class="column wdt-50">
                                <label>Pin</label>
                                <input type="text" name="reg_pin" value="<?php echo isset($masterData[0]['reg_pincode']) ? $masterData[0]['reg_pincode'] : ''; ?>" />
                            </div>
                            <div style="clear:both"></div>
                            <div class="column wdt-98 bg-gray">
                                <b class="heading-address">Other office address1</b >
                            </div>
                            <div class="column wdt-98">
                                <label>Address</label>
                                <textarea name="other_addr_1" rows="3" cols="30"><?php echo ((isset($masterData[0]['other_address_1'])) ? $masterData[0]['other_address_1'] : ""); ?></textarea>
                            </div>
                            <div class="column wdt-50">
                                <label>City</label>
                                <input type="text" name="other_city_1" value="<?php echo isset($masterData[0]['other_city_1']) ? $masterData[0]['other_city_1'] : ''; ?>" />
                            </div>
                            <div class="column wdt-50">
                                <label>Pin</label>
                                <input type="text" name="other_pin_1" value="<?php echo isset($masterData[0]['other_pincode_1']) ? $masterData[0]['other_pincode_1'] : ''; ?>" />
                            </div>
                            <div style="clear:both"></div>
                            <div class="column wdt-98 bg-gray">
                                <b class="heading-address">Other office address2</b>
                            </div>
                            <div class="column wdt-98">
                                <label>Address</label>
                                <textarea name="other_addr_2" rows="3" cols="30"><?php echo ((isset($masterData[0]['other_address_2'])) ? $masterData[0]['other_address_2'] : ""); ?></textarea>
                            </div>
                            <div class="column wdt-50">
                                <label>City</label>
                                <input type="text" name="other_city_2" value="<?php echo isset($masterData[0]['other_city_2']) ? $masterData[0]['other_city_2'] : ''; ?>" />
                            </div>
                            <div class="column wdt-50">
                                <label>Pin</label>
                                <input type="text" name="other_pin_2" value="<?php echo isset($masterData[0]['other_pincode_2']) ? $masterData[0]['other_pincode_2'] : ''; ?>" />
                            </div>
                            <div style="clear:both"></div>
                        </div>
                        <div style="clear:both"></div>
                        <br/>
                        <br/>
                        <div class="addmore-btn">
                            <input type="hidden" name="program" value="<?php echo $innovation['program']; ?>" />
                            <input type="hidden" name="innovation" value="<?php echo $innovation['id']; ?>" />
                            <input type="hidden" name="innovation_id" value="<?php echo $innovation['innovation_id']; ?>" />
                            <input type="submit" name="masterSubmit" class="save-btn position_Abs" value="Save"/>
                        </div>
                    </form>
                </div>


                <div id="Management" class="tabcontent">
                    <form name="team_data" action="<?php echo site_url('detailed_diligence/team_data'); ?>" enctype="multipart/form-data" method="post" id="team_data">
                        <input type="hidden" name="program" value="<?php echo $innovation['program']; ?>" />
                        <input type="hidden" name="innovation" value="<?php echo $innovation['id']; ?>" />
                        <input type="hidden" name="innovation_id" value="<?php echo $innovation['innovation_id']; ?>" />
                        <div class="table-responsive">
                            <table id="management_table" width="100%" cellpadding="0" cellspacing="0" class="tableindex" style="table-layout:fixed;">
                                <tbody class="optionBox">
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <th style="width:15%;">Founder(s) / Mgmt Names<span style="color:red;">*</span></th>
                                                    <th style="width:15%;">Mobile</th>
                                                    <th style="width:15%;">Email ID</th>
                                                    <th style="width:15%;">Location</th>
                                                    <th style="width:15%;">Desig., resp.</th>
                                                    <th style="width:20%;">Profile/ resume</th>
                                                    <th style="width:5%;">Action</th>
                                                </tr>
                                            </table>

                                        </td>
                                    </tr>
                                    <?php
                                    if ($teamcount == 0) {
                                        if (php72_count($mem_data) > 0) {
                                            foreach ($mem_data as $k => $v) {

                                                if (isset($v['resume']) && $v['resume'] != '') {
                                                    $getFile = explode('_', $v['resume']);
                                                    $get_ext = explode('.', $getFile['1']);
                                                    if (strlen($get_ext['0']) > 15) {
                                                        $file_name[$i] = substr($get_ext['0'], 0, 15) . '...' . $get_ext[1];
                                                    } else {
                                                        $file_name[$i] = $getFile['1'];
                                                    }
                                                }
                                                ?>

                                                <tr>
                                                    <td class="add_more_team">
                                                        <table width="100%" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td style="width:15%;">
                                                                    <input type="hidden" name="memberId[]" id="memberId" class="memberId<?php echo$k ?>" value="<?php echo $v['id']; ?>"/>
                                                                    <input class="input_text team_name mgmt_name" type="text" name="name[]" id="name" value="<?php echo isset($v['name']) ? $v['name'] : ''; ?>"/>
                                                                </td>
                                                                <td style="width:15%;">
                                                                    <input class="input_text team_mobile" type="text" name="mobile[]" id="mobile" value="<?php echo isset($v['mobile']) ? $v['mobile'] : ''; ?>"/>
                                                                </td>
                                                                <td style="width:15%;">
                                                                    <input class="input_text emailval team_email team_email<?php echo$k ?>" type="text" name="email[]" id="team_email_<?php echo $k; ?>" value="<?php echo isset($v['email']) ? $v['email'] : ''; ?>"/>
                                                                    <span class="span_email" id="span_email_<?php echo $k; ?>" style="display:none; color:red;">Enter valid email</span>
                                                                </td>
                                                                <td style="width:15%;">
                                                                    <input class="input_text team_location" type="text" name="location[]" id="location" value=""/>
                                                                </td>
                                                                <td style="width:15%;">
                                                                    <input class="input_text team_design" type="text" name="design[]" id="design" value="<?php echo isset($v['desg']) ? $v['desg'] : ''; ?>"/>
                                                                </td>
                                                                <td style="width:20%;" align="center">
                                                                    <input type="file" name="resume[]" data-index="<?php echo $k; ?>" id="team_resume_<?php echo $k; ?>" class="resumeval team_resume team_resume<?php echo $k; ?> resume"/>
                                                                    <span class="span_resume" id="span_resume_<?php echo $k; ?>" style="display:none; color:red;">Upload only doc, docx, xls, xlsx, ppt, pptx, pdf file formats</span>
                                                                    <span class="span_sizeresume" id="span_sizeresume_<?php echo $k; ?>" style="display:none; color:red;">File size exceeds 10 mb</span>
                                                                    <?php if (isset($v['resume']) && $v['resume'] != '') { ?>
                                                                        <input type="hidden" name="resume_old[]" id="resume_old" value="<?php echo isset($v['resume']) ? $v['resume'] : ''; ?>" />
                                                                        <a class="uploadFiles resume_exist<?php echo $k; ?>" href="<?php echo base_url() . 'uploads/detailed_diligence/' . $v['resume']; ?>" target="_blank"><?php echo $file_name[$i]; ?></a>
                                                                    <?php } ?>
                                                                </td>
                                                                <td style="width:5%;" align="center"><span><a id="close_action" href="javascript:" class="Edit-btn"> X </a></span></td>
                                                            </tr> </table> </td>
                                                </tr>

                                                <?php
                                                $i++;
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td class="add_more_team">
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td style="width:15%;">
                                                                <input type="hidden" name="memberId[]" id="memberId" value=""/>
                                                                <input class="input_text mgmt_name" type="text" name="name[]" id="name" value=""/>
                                                            </td>
                                                            <td style="width:15%;">
                                                                <input class="input_text team_mobile" type="text" name="mobile[]" id="mobile" value=""/>
                                                            </td>
                                                            <td style="width:15%;">
                                                                <input class="input_text emailval team_email" type="text" name="email[]" id="team_email_0" value=""/>
                                                                <span class="span_email" id="span_email_0" style="display:none; color:red;">Enter valid email</span>
                                                            </td>
                                                            <td style="width:15%;">
                                                                <input class="input_text team_location" type="text" name="location[]" id="location" value=""/>
                                                            </td>
                                                            <td style="width: 15%;">
                                                                <input class="input_text team_design" type="text" name="design[]" id="design" value=""/>
                                                            </td>
                                                            <td style="width:20%;" align="center">
                                                                <input type="file" name="resume[]" id="team_resume_0" class="resumeval team_resume resume" />
                                                                <span class="span_resume" id="span_resume_0" style="display:none; color:red;">Upload only doc, docx, xls, xlsx, ppt, pptx, pdf file formats</span>
                                                                <span class="span_sizeresume" id="span_sizeresume_0" style="display:none; color:red;">File size exceeds 10 mb</span>
                                                            </td>
                                                            <td style="width:5%;" align="center"><span><a id="close_action" href="javascript:" class="Edit-btn hideaction"> X </a></span></td>
                                                        </tr> </table> </td>
                                            </tr>

                                            <?php
                                        }
                                        $i = 0;
                                    } else {
                                        foreach ($teamData as $k => $v) {

                                            if ($v['resume'] != '') {
                                                $getFile = explode('_', $v['resume']);
                                                $get_ext = explode('.', $getFile['2']);
                                                if (strlen($get_ext['0']) > 15) {
                                                    $file_name[$i] = substr($get_ext['0'], 0, 15) . '...' . $get_ext[1];
                                                } else {
                                                    $file_name[$i] = $getFile['2'];
                                                }
                                            }
                                            ?>

                                            <tr>
                                                <td class="add_more_team">
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td style="width:15%;">
                                                                <input type="hidden" name="memberId[]" id="memberId" class="memberId<?php echo$k ?>" value="<?php echo $v['id']; ?>"/>
                                                                <input class="input_text team_name mgmt_name" type="text" name="name[]" id="name" value="<?php echo $v['name']; ?>"/>
                                                            </td>
                                                            <td style="width:15%;">
                                                                <input class="input_text team_mobile" type="text" name="mobile[]" id="mobile" value="<?php echo $v['mobile']; ?>"/>
                                                            </td>
                                                            <td style="width:15%;">
                                                                <input class="input_text emailval team_email team_email<?php echo$k ?>" type="text" name="email[]" id="team_email_<?php echo $k; ?>" value="<?php echo $v['email']; ?>"/>
                                                                <span class="span_email" id="span_email_<?php echo $k; ?>" style="display:none; color:red;">Enter valid email</span>
                                                            </td>
                                                            <td style="width:15%;">
                                                                <input class="input_text team_location" type="text" name="location[]" id="location" value="<?php echo $v['location']; ?>"/>
                                                            </td>
                                                            <td style="width:15%;">
                                                                <input class="input_text team_design" type="text" name="design[]" id="design" value="<?php echo $v['design']; ?>"/>
                                                            </td>
                                                            <td style="width:20%;" align="center">
                                                                <input type="file" name="resume[]" data-index="<?php echo $k; ?>" id="team_resume_<?php echo $k; ?>" class="resumeval team_resume team_resume<?php echo $k; ?> resume"/>
                                                                <span class="span_resume" id="span_resume_<?php echo $k; ?>" style="display:none; color:red;">Upload only doc, docx, xls, xlsx, ppt, pptx, pdf file formats</span>
                                                                <span class="span_sizeresume" id="span_sizeresume_<?php echo $k; ?>" style="display:none; color:red;">File size exceeds 10 mb</span>
                                                                <input type="hidden" name="resume_old[]" id="resume_old" value="<?php echo $v['resume']; ?>" />
                                                                <a class="uploadFiles resume_exist<?php echo $k; ?>" href="<?php echo base_url() . 'uploads/detailed_diligence/' . $v['resume']; ?>" target="_blank"><?php echo $file_name[$i]; ?></a>
                                                            </td>
                                                            <td style="width:5%;" align="center"><span><a id="close_action" href="javascript:" class="Edit-btn"> X </a></span></td>
                                                        </tr> </table> </td>
                                            </tr>

                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td id='mgmt_add'></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <br />
                        <div class="addmore-btn">
                            <span><a href="javascript:" id="addMore" class="button">+ Add More</a></span>
                            <span><input type="submit" name="teamSubmit" id="teamSubmit" class="save-btn position_Abs" value="Save"/></span>
                        </div>
                        <div class="addmore-btn">
                            <input type="hidden" name="program" value="<?php echo $innovation['program']; ?>" />
                            <input type="hidden" name="innovation" value="<?php echo $innovation['id']; ?>" />
                            <input type="hidden" name="innovation_id" value="<?php echo $innovation['innovation_id']; ?>" />
                        </div>

                    </form>

                    <div style="clear:both"></div>
                </div>

                <div id="Table" class="tabcontent">
                    <form name="share_data" action="<?php echo site_url('detailed_diligence/share_data'); ?>" method="post" id="share_data">
                        <table id="share_table" width="100%" cellpadding="0" cellspacing="0">
                            <tbody  class="totalBox">
                                <tr>
                                    <th style="width:33.333%;">Shareholder</th>
                                    <th style="width:33.333%;">% Shares</th>
                                    <th style="width:33.333%;">Type of shares</th>
                                    <th style="width:25%;">Action</th>
                                </tr>
                                <?php if ($sharecount == 0) { ?>
                                    <tr id="add_more_share">
                                        <td style="width:33.333%;" align="center">
                                            <input type="hidden" name="shareId[]" id="shareId" value=""/>
                                            <input type="text" name="holder[]" id="holder" value=""/>
                                        </td>
                                        <td style="width:33.333%;" align="center">
                                            <input type="text" name="share[]" id="share" onkeydown="return (event.ctrlKey || event.altKey
                                                            | | (47 < event.keyCode && event.keyCode < 58 && event.shiftKey == false)
                                                            || (95 < event.keyCode && event.keyCode < 106)
                                                            || (event.keyCode == 8) || (event.keyCode == 9)
                                                            || (event.keyCode > 34 && event.keyCode < 40)
                                                            || (event.keyCode == 46))" value=""/>
                                        </td>
                                        <td style="width:33.333%;" align="center">
                                            <input type="text" name="type[]" id="type" value=""/>
                                        </td>
                                        <td style="width:25%;" align="center"><span><a id="close_share" href="javascript:" class="Edit-btn hideaction"> X </a></span></td>
                                    </tr>
                                    <?php
                                } else {
                                    foreach ($shareData as $k => $v) {
                                        ?>
                                        <tr id="add_more_share">
                                            <td style="width:33.333%;" align="center">
                                                <input type="hidden" name="shareId[]" id="shareId" value="<?php echo $v['id']; ?>"/>
                                                <input type="text" name="holder[]" id="holder" value="<?php echo $v['holder']; ?>"/>
                                            </td>
                                            <td style="width:33.333%;" align="center">
                                                <input type="text" name="share[]" id="share" onkeydown="return (event.ctrlKey || event.altKey
                                                                || (47 < event.keyCode && event.keyCode < 58 && event.shiftKey == false)
                                                                || (95 < event.keyCode && event.keyCode < 106)
                                                                || (event.keyCode == 8) || (event.keyCode == 9)
                                                                || (event.keyCode > 34 && event.keyCode < 40)
                                                                || (event.keyCode == 46))" value="<?php echo $v['share']; ?>"/>
                                            </td>
                                            <td style="width:33.333%;" align="center">
                                                <input type="text" name="type[]" id="type" value="<?php echo $v['type']; ?>"/>
                                            </td>
                                            <td style="width:25%;" align="center"><span><a id="close_share" href="javascript:" class="Edit-btn"> X </a></span></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <br />
                        <div class="addmore-btn">
                            <span><a  href="javascript:" id="moreShare" class="button">+ Add More</a></span>
                            <span><input type="submit" name="shareSubmit" class="save-btn position_Abs" value="Save"/></span>
                        </div>
                        <div style="clear:both"></div>
                        <div class="addmore-btn">
                            <input type="hidden" name="innovation" value="<?php echo $innovation['id']; ?>" />
                            <input type="hidden" name="innovation_id" value="<?php echo $innovation['innovation_id']; ?>" />

                        </div>
                    </form>
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
            $(document).on('click', '#addMore', function () {
                var i = 0;
                var datas = $('.add_more_team').html();
                $('#mgmt_add').append(datas);
                $('.mgmt_name').each(function (key, value) {
                    $("#mgmt_add").find("#memberId:last").val('');
                    $("#mgmt_add").find("#name:last").val('');
                    $("#mgmt_add").find("#mobile:last").val('');
                    $("#mgmt_add").find(".emailval':last").val('');
                    $("#mgmt_add").find("#location:last").val('');
                    $("#mgmt_add").find("#design:last").val('');
                    $("#mgmt_add").find(".resumeval':last").val('');
                    $("#mgmt_add").find("#resume_old:last").val('');
                    $("#mgmt_add").find(".uploadFiles:last").text('');
                    $("#mgmt_add").find(".team_email:last").attr('id', 'team_email_' + i);
                    $("#mgmt_add").find(".span_email:last").attr('id', 'span_email_' + i);
                    $("#mgmt_add").find(".team_resume:last").attr('id', 'team_resume_' + i);
                    $("#mgmt_add").find(".span_resume:last").attr('id', 'span_resume_' + i);
                    $("#mgmt_add").find(".span_sizeresume:last").attr('id', 'span_sizeresume_' + i);
                    $("#mgmt_add").find("#close_action:last").removeClass('hideaction');
                    i = i + 1;
                });
                var j = i - 1;
                $("#span_email_" + j).hide();
                $("#span_resume_" + j).hide();
                $("#span_sizeresume_" + j).hide();
            });
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
            .input_text{
                width:125px;
            }
            .uploadFiles:hover{
                color: #000 !important;
            }
            .add_more_team input{
                padding: 4px;
            }
            .hideaction {display: none;}
            select {
                padding: 3px;
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
            .enterpriseDetails-tab table tr td{
                padding: 10px 5px;
                border: 1px solid #ccc;
                vertical-align: bottom;
            }
            .enterpriseDetails-tab #Management table tr td table tr td{
                padding: 10px 5px;
                border: 1px solid #ccc;
                vertical-align: bottom;
            }
            .enterpriseDetails-tab #Management table tr td{
                padding: 0px 5px;
                border: none;
                vertical-align: bottom;
            }
            .resume{
                width: 150px;
            }
            a:hover{
                color: #fff !important;
            }
            .save-btn {
                font: 11px Tahoma, sans-serif;
                font-weight: bold;
                color: #fff;
                padding: 6px 8px;
                border: 1px solid #418830;
                border-radius: 3px;
                background: #418830 !important;
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
                width: 33.33333333333333%;
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
            div.uploader {
                width: 127px;
                cursor: pointer;
            }
            div.uploader span.filename {
                color: #777;
                width: 32px;
                border-right: solid 1px #bbb;
                font-size: 11px;
            }
            div.uploader span.action {
                width: 72px;
                text-align: center;
                text-shadow: #fff 0px 1px 0px;
                background-color: #fff;
                font-size: 11px;
                font-weight: bold;
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
            input[type="radio"]{
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
                padding:0px;
            }
            .gridShow-details .column label {
                font-weight: 600;
                color: #000;
                font-size: 13px;
                padding: 10px 1px 6px 5px;
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
                padding: 8px 0 8px 10px;
                text-align: left;
                display: block;
                color: #333;
                font-size: 13px;
                background-color: #e2ecdd;
                margin: 26px 0px 0px;
            }

            .gridShow-details .column input{
                margin: 0px 0px 10px 0px;
                color: #666;
                line-height: 20px;
                text-align: left;
                letter-spacing: 0.2px;
                font-size: 13px;
                background: #fff;
                border-left: none;
                border-top: none;
                border-right: none;
                border-radius: 0px;
                border-bottom: 1px solid #8eb37d;
                width: 97%;
            }
            .gridShow-details .column textarea{
                margin: 0px 0px 0px 0px;
                color: #666;
                line-height: 20px;
                text-align: left;
                letter-spacing: 0.2px;
                font-size: 13px;
                background: #fff;
                border-bottom: 1px solid #8eb37d;
                width: 100%;
                border-left: none;
                border-top: none;
                border-right: none;
                border-radius: 0px;
            }
            .table-responsive {
                width: 100%;
                overflow: auto;
            }
            .tabcontent input[type="text"] {
                background: #fff !important;
                border-bottom: 1px solid #8eb37d !important;
                border-left: none !important;
                border-right: none !important;
                border-top: none !important;
                border-radius: 0 !important;
            }

            .AddMore-btn {
                background: #ee992b !important;
                padding: 7px 10px;
                font-size: 12px;
                color: #fff;
                border-radius: 1px;
                border: none;
                box-shadow: 0px 5px 20px rgba(0,0,0,0.12);
            }
            .Edit-btn {
                background: #ff0000  !important;
                padding: 7px 10px;
                font-size: 12px;
                color: #fff;
                border-radius: 4px;
                box-shadow: 0px 5px 20px rgba(0,0,0,0.12);
                border: none;
            }

            .position_Abs{
                cursor: pointer;
            }
        </style>

        <script type="text/javascript">
            function openBlock(evt, tabName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(tabName).style.display = "block";
                evt.currentTarget.className += " active";
            }

            document.getElementById("defaultOpen").click();

            $(document).ready(function () {
                $("#incorporation_date").datepicker({dateFormat: 'dd-mm-yy'});
                var date = $('#incorporation_date').val();
                if (date == '01-01-1970') {
                    $("#incorporation_date").datepicker("setDate", new Date());
                }

                var sub_sec = $('#load_subsec').val();
                subsector(sub_sec);

                setTimeout(function () {
                    $('.succ-msg').hide();
                }, 5000);

                var isAdmin = "<?php echo $this->session->userdata('isAdmin'); ?>";
                var isPartner = "<?php echo $this->session->userdata('partner_id'); ?>";
                var isAssociate = "<?php echo $innovation['isAssociate']; ?>";
                if ((isAssociate != '1' && isAdmin != 'Yes') || isPartner == '') {
                    $(".container :input:not(:button)").attr("disabled", true);
                    $('.container a:not(:#logStatusModal, .uploadFiles)').css('pointer-events', 'none');
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
                        for (var prop in arr) {
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

            $(document).on("submit", '#team_data', function (e) {

                var valid = "";
                $('.emailval').each(function (key, value) {
                    var email = $('#team_email_' + key).val();
                    if (email != '') {
                        var ids = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                        if (ids.test(email)) {
                            $('#span_email_' + key).hide();
                        } else {
                            $('#span_email_' + key).show();
                            valid = "2";
                        }
                    }
                });
                if (valid == "2") {
                    valid = "1";
                    e.preventDefault();
                }


                $('.resumeval').each(function (key, value) {
                    var allowedFiles = [".ppt", ".pptx", ".pdf", ".doc", ".docx", ".xlsx", ".xls"];
                    var fileexist = $('#team_resume_' + key).get(0).files.length;
                    var fileUpload = document.getElementById("team_resume_" + key);

                    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
                    if (!regex.test(fileUpload.value.toLowerCase())) {
                        if (fileexist != 0) {
                            $('#span_sizeresume_' + key).hide();
                            $('#span_resume_' + key).show();
                            e.preventDefault();
                        } else {

                        }

                    } else {
                        var FileSize = $('#team_resume_' + key)[0].files[0].size / 1024 / 1024;
                        if (FileSize > 10) {
                            $('#span_resume_' + key).hide();
                            $('#span_sizeresume_' + key).show();
                            e.preventDefault();
                        } else {
                            $('#span_sizeresume_' + key).hide();
                            $('#span_resume_' + key).hide();
                        }

                    }
                });

            });

            $('#team_data').validate();

            $(document).on('keyup', ".emailval", function () {
                $('.emailval').each(function (key, value) {
                    var email = $('#team_email_' + key).val();
                    if (email != '') {
                        var ids = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                        if (ids.test(email)) {
                            $('#span_email_' + key).hide();
                        } else {
                            $('#span_email_' + key).show();
                        }
                    }
                });
            });

            $(document).on('change', ".resumeval", function () {
                $('.resumeval').each(function (key, value) {
                    var allowedFiles = [".ppt", ".pptx", ".pdf", ".doc", ".docx", ".xlsx", ".xls"];
                    var fileexist = $('#team_resume_' + key).get(0).files.length;
                    var fileUpload = document.getElementById("team_resume_" + key);
                    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
                    if (!regex.test(fileUpload.value.toLowerCase())) {
                        if (fileexist != 0) {
                            $('#span_sizeresume_' + key).hide();
                            $('#span_resume_' + key).show();
                        }
                    } else {
                        var FileSize = $('#team_resume_' + key)[0].files[0].size / 1024 / 1024;
                        if (FileSize > 10) {
                            $('#span_resume_' + key).hide();
                            $('#span_sizeresume_' + key).show();
                        } else {
                            $('#span_resume_' + key).hide();
                            $('#span_sizeresume_' + key).hide();
                        }
                    }
                });
            });


            $('#close_share').live('click', function () {
                var app = confirm("Are you sure to delete this?");
                if (app == true) {
                    var current_url = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                    var id = $(this).parents('tr').find("#shareId").val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/detailed_diligence/remove_share",
                        data: {id: id},
                        dataType: 'json',
                        success: function (msg) {
                            $(this).parents('tr').remove();
                            $("#share_table").load(current_url + " #share_table");
                        },
                    });
                }
            });

            $('.resume').change(function () {
                var indexs = $(this).data('index');
                $('.resume_exist' + indexs).hide();
            });


            $('#moreShare').click(function () {
                var row = $('#add_more_share').clone().find("input").val("").end();
                row.find("#close_share:last").removeClass('hideaction');
                $('.totalBox').append(row);
            });


            $('#close_action').live('click', function () {
                var app = confirm("Are you sure to delete this?");
                if (app == true) {
                    var id = $(this).parents('tr').find("#memberId").val();
                    var current_url = "<?php echo $_SERVER['REQUEST_URI']; ?>";
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/detailed_diligence/remove_member",
                        data: {id: id},
                        dataType: 'json',
                        success: function (msg) {
                            $(this).parents('tr').remove();
                            $("#management_table").load(current_url + " #management_table");
                        },
                    });
                }
            });


            function subsector(val) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/scouting/getSubsector",
                    data: {sector_id: val},
                    dataType: 'json',
                    success: function (msg) {
                        var sub_sec = $('#select_subsec').val();
                        $('#sub_sector').find('option').remove().end();
                        $("#sub_sector").prepend("<option value=''>-Select</option>");
                        $.each(msg, function (i, value) {
                            $('#sub_sector').append($('<option>').text(value.sector).attr('value', value.id));
                            $('#sub_sector').val(sub_sec);
                        });
                    },
                });
            }

        </script>

    </body>
</html>