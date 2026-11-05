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
                    <input type="hidden" name="dilegence" id="dilegence" value="1">
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
                            <strong>Assigned To</strong>:&nbsp;<?php echo isset($assign_to) && $assign_to != '' ? $assign_to : '-'; ?>
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
                        <form id="form1">
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

            <?php
            $app = $iic = $nda = $quest = $doc_rec = $site = $asses = $eic = 'red';
            $app_date = $iic_date = $nda_date = $quest_date = $site_date = $eic_date = '-';
            $iic_action = $eic_action = 'approved';
            $doc_rec_val = $asses_val = '-';

            $docs_type = array('1', '2', '3', '4', '5', '6');
            for ($i = 0; $i < php72_count($all_docs); $i++) {
                $get_docs[$all_docs[$i]['doc_type']] = $all_docs[$i]['doc_type'];
            }
            $avail_docs = php72_array_keys($get_docs);

            if (!empty($all_docs) && !array_diff($docs_type, $avail_docs)) {
                $doc_rec = 'green';
                $doc_rec_val = 'Yes';
            }

            if ($application_date[0]['submitted_date'] != '0000-00-00') {
                $app = 'green';
                $app_date = date('d-M-Y', strtotime($application_date[0]['submitted_date']));
            }

            if ($iic_val[0]['internal_status'] != '') {
                $iic_date = date('d-M-Y', strtotime($iic_val[0]['modified_date']));
                $iic_action = $iic_val[0]['internal_status'] == 'Accept' ? 'approved' : 'rejected';
                if ($iic_val[0]['internal_status'] == 'Accept') {
                    $iic = 'green';
                }
            }
            if ($nda_signed[0]['id'] != '') {
                $nda = 'green';
                $nda_date = date('d-M-Y', strtotime($nda_signed[0]['created_at']));
            }
            if ($quest_res[0]['id'] != '') {
                $quest = 'green';
                $quest_date = date('d-M-Y', strtotime($quest_res[0]['created_at']));
            }
            if ($site_plan[0]['id'] != '') {
                $site = 'green';
                $site_date = date('d-M-Y', strtotime($site_plan[0]['created_at']));
            }
            if ($assessment[0]['id'] != '') {
                $asses = 'green';
                $asses_val = 'Yes';
            }

            if ($eic_app != '' && (($innovation['status'] == '17' || $innovation['status'] == '20') || ($innovation['stage'] == '12' && $innovation['status'] == '12'))) {
                $eic = 'green';
                $eic_action = 'approved';
                $eic_date = date('d-M-Y', strtotime($eic_app[0]['modified_date']));
            } else if ($eic_app != '' && $innovation['status'] == '18') {
                $eic = 'red';
                $eic_action = 'rejected';
                $eic_date = date('d-M-Y', strtotime($eic_app[0]['modified_date']));
            }
            ?>

            <div class="enterpriseDetails-table">
                <div>
                    <table width="100%" cellpadding="0" cellspacing="0" >
                        <tbody>
                            <tr>
                                <th style="width:11%;" class="<?= $app; ?>">Application submitted</th>
                                <th style="width:11%;" class="<?= $iic; ?>">IIC <?= $iic_action; ?></th>
                                <th style="width:11%;" class="<?= $nda; ?>">NDA signed</th>
                                <th style="width:11%;" class="<?= $doc_rec; ?>">Documents received</th>
                                <th style="width:11%;" class="<?= $quest; ?>">DD questionnaire received</th>
                                <th style="width:11%;" class="<?= $site; ?>">Site visit plan created</th>
                                <th style="width:12%;" class="<?= $asses; ?>">DD assessment in progress</th>
                                <th style="width:11%;" class="<?= $eic; ?>">EIC <?= $eic_action; ?></th>
                            </tr>
                            <tr>
                                <td style="width:11%;text-align:center;"><?= $app_date; ?></td>
                                <td style="width:11%;text-align:center;"><?= $iic_date; ?></td>
                                <td style="width:11%;text-align:center;"><?= $nda_date; ?></td>
                                <td style="width:11%;text-align:center;"><?= $doc_rec_val; ?></td>
                                <td style="width:11%;text-align:center;"><?= $quest_date; ?></td>
                                <td style="width:11%;text-align:center;"><?= $site_date; ?></td>
                                <td style="width:12%;text-align:center;"><?= $asses_val; ?></td>
                                <td style="width:11%;text-align:center;"><?= $eic_date; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="enterpriseDetails-button">
                <ul>
                    <li>
                        <a class="yellow-color" href="<?= site_url('detailed_diligence/company_team/' . $id); ?>"><span class="btn-icon"><i class="fa fa-users" aria-hidden="true"></i></span>Company and Team >></a>
                    </li>
                    <li>
                        <a class="blue-color" href="<?= site_url('detailed_diligence/document_meeting/' . $id); ?>"><span class="btn-icon"><i class="fa fa-file-text" aria-hidden="true"></i></span>Documents and Meetings >></a>
                    </li>
                    <li>
                        <a class="orange-color" href="<?= site_url('detailed_diligence/detailed_assessment/' . $id); ?>"><span class="btn-icon"><i class="fa fa-file-text-o" aria-hidden="true"></i></span> Detailed Assessment >></a>
                    </li>
                </ul>
            </div>

            <div style="height:40px;"></div>
        </div>

        <div style="display:none;">
            <div id="dateModal" class="global_search" align="center" style="width:500px;">
                <h1 class="text-left reduce_space">Select start date of <span id='eic_title'></span></h1>
                <!--                <div class="modal-head">
                                    <p style="width: 100%;text-align:center;font-size: 16px;margin-bottom:0;font-weight: bold;">Search Across Partners</p>
                                </div>-->
                <div class="modal-body">
                    <br/>
                    <label>Choose date : </label>
                    <input type="text" name="status_change_date" id="status_change_date" style="padding: 5px;" value="<?= $eic_app_date; ?>" />
                </div>
                <br/>
                <input type="button" value="Submit" id='dateSubmit' class="button" />
            </div>
        </div>

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
            .enterpriseDetails-table{
                padding:20px 0px;
            }
            .save-btn {
                background: #36c6ad;
                padding: 6px 36px;
                font-size: 14px;
                color: #fff;
                border-radius: 30px;
                box-shadow: 0px 5px 20px rgba(0,0,0,0.12);
            }
            .enterpriseDetails-table table tr th.green{
                background-color: #d1deab;
                color: #000;
                text-align: center;
                padding: 10px 5px;
                border-right: 1px solid #5d7d00;
                border-bottom: 2px solid #5f8d4a;
                vertical-align: middle;
            }
            a:hover{
                color: #fff !important;
            }
            .enterpriseDetails-table table tr th.red {
                background-color: #f1c2c4;
                color: #000;
                text-align: center;
                padding: 10px 5px;
                border-right: 1px solid #ef4f56;
                border-bottom: 2px solid #ef4f56;
                vertical-align: middle;
            }
            .enterpriseDetails-table table tr th:last-child{
                border-right: none;
            }
            .enterpriseDetails-table table tr td{
                padding: 10px 5px;
                border: 1px solid #ccc;
            }
            .enterpriseDetails-button ul li{
                display: inline-block;
            }
            .enterpriseDetails-button{
                padding:10px 0px 20px;
                text-align: center;
            }
            .enterpriseDetails-button ul li a {
                color: #333;
                padding: 15px 40px;
                font-weight: 600;
                border-radius: 30px;
                margin-right: 10px;
                box-shadow: 0px 5px 20px rgba(0,0,0,0.12);
                font-size: 14px;
            }
            .enterpriseDetails-button ul li a .btn-icon{
                font-size: 15px ;
                padding-right: 10px;
            }
            .yellow-color{
                background-color: #fdd22c;
            }
            .blue-color{
                background-color: #9dc467;
            }
            .orange-color{
                background-color: #fba227;
            }
        </style>

        <script type="text/javascript">
            $(document).ready(function () {
                var isAdmin = "<?php echo $this->session->userdata('isAdmin'); ?>";
                var isPartner = "<?php echo $this->session->userdata('partner_id'); ?>";
                var isAssociate = "<?php echo $innovation['isAssociate']; ?>";
                if ((isAssociate != '1' && isAdmin != 'Yes') || isPartner == '') {
                    $(".container :input").attr("disabled", true);
                    $('.button:not(:#logStatusModal)').css('pointer-events', 'none');
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
                                if (arr[prop]['associate_employee'] == $(this).val())
                                {
                                    $(this).attr("selected", 'selected');
                                }
                            });
                        }
                    },
                });
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

    </body>
</html>

