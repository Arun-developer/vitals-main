<!-- Rejection mail triggering on close action -->
<?php
$innovationID = $innovation['id'];
$formAction = site_url('common/mail/form/' . $innovationID);
?>

<div style="display:none;">
    <div align="center" id="mail_trigger" style="width:420px; height:180px;">

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

<form name="templateForm" enctype="multipart/form-data" action="<?= $formAction ?>" method="post" id="templateForm"
      class="uniform">
    <input type="hidden" name="innovation" value="<?= $innovation['id'] ?>" />
    <input type="hidden" name="mail_type" value="Rejection" />
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


<style type="text/css">
    .triggerBtn {
        font-size: 14px;
    }

    .mailTrigger {
        font-size: 14px;
        text-align: left;
        margin-bottom: 0px;
    }

    .mailTriggerHead {
        font-size: 14px;
        text-align: left;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 999;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    .text-left {
        text-align: left !important;
    }

    .reduce_space {
        width: 95%;
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px 20px 40px 20px;
        border: 1px solid #888;
        width: 40%;
    }

    .modal-head h2 {
        text-align: center;
        padding-bottom: 0px;
        width: 97%;
        margin: 0;
    }

    .modal-head {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .modal-body form {
        text-align: center;
    }

    .modal-body form textarea {
        width: 80%;
        margin: auto;
    }

    /* The Close Button */
    .close,
    .detailCloseModal {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus,
    .detailCloseModal:hover,
    .detailCloseModal:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () {
        $("#inv_add_info").hide();
        $("#inv_info").show();

        $('#inv_info').click(function () {
            $("#inv_add_info").slideToggle();
        });
    });
</script>
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML =
                "<html><head><title></title></head><body>" +
                divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;


    }
</script>


<div style="display:none;">
    <div align="center" id="approve_sheet" style="width:400px; height:460px;">

        <h3>Please select user who will do the Preliminary Assessment scoring on this deal from the list below</h3>

        <form action="<?php echo site_url('scouting/assignInchargeInView'); ?>" id="assign" method="post">

            <select id="associate_employee" data-placeholder="Select Employee" multiple class=""
                    style="width:350px;height:330px;" tabindex="1" name="associate_employee[]">
                        <?php
                        foreach ($usersList as $row) {
                            ?>
                    <option value="<?= $row['emp_number'] ?>"><?= $row['emp_name'] ?></option>
                <?php }
                ?>
            </select>
            <input type="hidden" name="innovations" id="innovations" />
            <br /><br />
            <div>
                <input type="submit" name="txtSubmit" class="button" id="txtsub" value="Submit" />
            </div>
        </form>

    </div>
</div>


<div style="display:none;">
    <div align="center" id="status_log" style="width:800px; height:400px;">

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
                    $time = date('h:i:s a', strtotime($row['modified_date']));

                    $stage = $this->Minnovation->getInnvationStage();
                    $status = $this->Minnovation->getInnvationStatus();
                    $status_text = $status[$row['status']];
                    $stage_text = $stage[$row['stage']];
                    ?>


                    <tr>

                        <?php
                        if ($row['reason'] != '') {
                            ?>
                            <td colspan="6" style="padding:5px;text-align:center;font-weight:bold;">
                                <?php echo $row['reason']; ?></td>
                            <?php
                        } else {
                            ?>

                            <td style="padding:5px;"><?php echo $date; ?></td>
                            <td style="padding:5px;"><?php echo $time; ?></td>
                            <td style="padding:5px;"><?php echo $row['assigned_incharge']; ?></td>
                            <td style="padding:5px;">
                                <?php
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



<div id="form_employeelist" style="display:none;">
    <div align="center" id="form_container" style="height:400px;">

        <form action="<?php echo site_url('scouting/onlyAssignIncharge'); ?>" id="assign" method="post">

            <select id="associate_employee" data-placeholder="Select Employee" multiple class=""
                    style="width:350px;height:330px;" tabindex="1" name="associate_employee[]">
                        <?php
                        foreach ($usersList as $row) {
                            echo "<pre>";
                            print_r($row);
                            ?>
                    <option value="<?= $row['emp_number'] ?>"><?= $row['emp_name'] ?></option>
                <?php }
                ?>
            </select>

            <input type="hidden" name="innovations" id="innovation_id" value="<?php echo $innovationID; ?>" />
            <br /><br />
            <div>
                <input type="submit" name="txtSubmit" class="button" id="txtsub" value="Submit" />
            </div>
        </form>
    </div>
</div>



<?php
$isEdit = false;
$isAssignCycle = false;
if (((in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || $innovation['isAssociate']) && ($this->session->userdata('partner_id') == $innovationDetails[0]['partner_id'])) || ($this->session->userdata('user_type') == 'superadmin')) {
    $isEdit = true;
    $isAssignCycle = true;
}

foreach ($inv_user as $row) {
    if ($innovationDetails[0]['created_by'] == $this->session->userdata('emp_number'))
        $isEdit = true;
    ?>
    <?php if ($innovation['status'] != '3' && $innovation['isAssociate']) { ?>
        <a href="#form_container" id="assign_incharge" style="float:right" class="fancybox button">Assign In Charge</a>
    <?php } ?>
    <!--<a href="javascript:printDiv('print_table')" id="print_form" style="float:right" class="button">Print</a>-->
    <a href="javascript:void(0)" id="print_form" onclick="attachmentDownload('<?php echo $this->uri->segment('3'); ?>', '<?php echo $innovationDetails[0]['program']; ?>', '<?php echo $add_info[0]['business_plan']; ?>', '<?php echo $add_info[0]['add_info']; ?>');" style="float:right" class="button">Download</a>
    <?php
    if ($isEdit) {
        ?>
        <a href="<?= site_url('scouting/inv_app_edit/' . $this->uri->segment('3') . '/' . $row['id']); ?>" style="float:right"
           class="button">Edit</a>
       <?php } ?>
       <?php if ($this->session->userdata('user_type') == 'employee') {
           ?>
        <a href="<?= site_url('scouting/innovation_pool/all') ?>" class="button" style="float:right">Back</a><?php } ?>
    <div id="print_table">
        <style type="text/css">
            tr.odd td {
                background-color: #FFF !important
            }

            tr.even td {
                background-color: #F0F9D9 !important
            }

            .inv-detail-status {
                float: left;
                width: 30%;
            }
        </style>
        <h1><?php echo $row['ent_name']; ?></h1>
        <ul class="inv-detail-status">
            <li><strong>Stage</strong> : <?php
                if ($innovationDetails[0]['stage'] == '2' && $isAssignCycle) {
                    ?>
                    <a href="<?= site_url('scouting/cycle/' . $innovationDetails[0]['id']) ?>"
                       class="fancybox button"><?= $stage[$innovationDetails[0]['stage']] ?></a>
                       <?php
                   } else {
                       echo $stage[$innovationDetails[0]['stage']];
                   }
                   ?></li>
            <li><strong>Status</strong> :
                <?php echo $status[$innovationDetails[0]['status']]; //if(isset($inv_user[0]['ent_sector']) && $inv_user[0]['ent_sector']=="MCH") echo $inv_user[0]['status']; else echo $status[$innovationDetails[0]['status']]; ?>
            </li>
        </ul>
        <?php if ($innovation['status'] != '3' && $innovation['isAssociate']) { ?>
            <div class="inv-detail-status">
                <form>
                    <strong>Action</strong> :
                    <select onchange="changeFancyClass(this.value);" id="inv_sector">
                        <?php if ($innovation['stage'] == '7') { ?>
                            <option value="1">Approve for PA/RD</option>
                        <?php } ?>
                        <option value="24">Open-Banked</option>
                        <option value="2">Close</option>
                    </select>

                    <span><a id="save_action" href="<?= site_url('scouting/action/close/' . $innovationID . '/' . '24'); ?>" class="fancybox button">Save</a></span>
                </form>
            </div>
            <script>
                $(document).on('change', '#inv_sector', function () {
                    var current_val = $(this).val();
                    href_link = '<?= site_url('scouting/action/close/' . $innovationID . '/'); ?>' + '/' + current_val;
                    $("#save_action").attr("href", href_link);
                });

            </script>
            <?php
        } else if ($innovation['status'] == '3') {
            $empName = $this->Sector_model->getEmployeeNameByID($innovation['modified_by']);
            $cmnts = isset($innovation['comments']) && $innovation['comments'] != '' ? $innovation['comments'] : '-N/A-';
            ?>
            <ul class="inv-detail-status">
                <li><strong>Reason</strong> : <?php echo $innovationDetails[0]['reasons_title']; ?></li>
                <li title='<?php echo $cmnts; ?>'><strong>Comments</strong> : <?php echo mb_strimwidth($cmnts, 0, 75, '...'); ?>
                </li>
                <li><strong>Closed By</strong> : <?php echo $empName['emp_name']; ?></li>
            </ul>
        <?php } ?>

        <span><a id="logStatusModal" class="fancybox button" href="#status_log"
                 style="float:right; cursor:pointer;">Application Status Log</a></span>


        <table class="gtable " width="80%" class="items" bgcolor="#F5F5F5" cellspacing="5" cellpadding="5" border="1px">
            <thead>
                <tr>
                    <th colspan="2"><?php echo $row['ent_name']; ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" style="background-color:#FFF"></td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color:#FFF"><b>Basic Information</b></td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color:#FFF"></td>
                </tr>
                <tr>
                    <td>Innovation Id</td>
                    <td><?php echo $innovationDetails[0]['copy_id'] . '_' . $innovationDetails[0]['partner_id'] . '_' . $innovationDetails[0]['partner_count']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Partner</td>
                    <td><?php echo ucfirst($innovationDetails[0]['branch_name']); ?></td>
                </tr>
                <tr>
                    <td style="width:40%">Name of Incubatee </td>
                    <td><?php echo $row['ent_name']; ?></td>
                </tr>
                <tr>
                    <td>Name of Entrepreneur</td>
                    <td><?php echo $row['applicant_name']; ?></td>
                </tr>

                <tr>
                    <td>Email</td>
                    <td><?php echo $row['email']; ?></td>
                </tr>
                <tr>
                    <td>Mobile</td>
                    <td><?php echo $row['mobile']; ?></td>
                </tr>
                <?php if ($innovationDetails[0]['website'] != '') { ?>
                    <tr>
                        <td>Website</td>
                        <td><?php echo $innovationDetails[0]['website']; ?></td>
                    </tr>
                <?php } ?>
                <?php if ($add_info[0]['company_description'] == '') { ?>
                    <tr>
                        <td>Address 1</td>
                        <td><?php echo $row['address1']; ?></td>
                    </tr>
                    <tr>
                        <td>Address 2</td>
                        <td><?php echo $row['address2']; ?></td>
                    </tr>

                    <tr>
                        <td>Country</td>

                        <td><?php
                            if ($row['country'] != '') {
                                $country = $this->Minnovation->getCountryName($row['country']);
                                echo $country[0];
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <td>Is your incubatee a</td>
                    <td><?php echo $row['ent_type']; ?></td>
                </tr>

                <?php if ($add_info[0]['company_description'] == '') { ?>
                    <tr>
                        <td>Will your social incubatee be based in India</td>
                        <td><?php echo $row['india_based']; ?></td>
                    </tr>
                <?php } else {
                    ?>
                    <tr>
                        <td>Where is your incubatee based?</td>
                        <td><?php echo $row['india_based']; ?></td>
                    </tr>
                <?php } ?>
                <?php $sub_sectorname = $this->Sector_model->getSectorNameByID($row['sub_sector']); ?>
                <tr>
                    <td>Sector</td>
                    <td><?php echo $sector_name[0]['sector']; ?></td>
                </tr>

                <tr>
                    <td>Sub Sector</td>
                    <td><?php
                        if ($row['sub_sector'] != "")
                            echo $sub_sectorname;
                        else
                            echo "";
                        ?></td>
                </tr>

                <tr>
                    <td>Who will be the beneficiaries of your product / service?</td>
                    <td><?php
                        $benificary = unserialize($row['benificiary']);
                        echo php72_implode(', ', $benificary);
                        ?></td>
                </tr>

                <tr>
                    <td>What type of impact will your product / service have on the BoP / poor?</td>
                    <td><?php echo $row['impact_of_product']; ?></td>
                </tr>


                <tr>
                    <td colspan="2"><a href="#bottom" id="inv_info" style="color:#719e41;">** Additional Information</a>
                        <?php if ($row['ent_sector'] != "MCH" && $row['ent_sector'] != "Maternal & child health") { ?>
                            <table id="inv_add_info" class="gtable " width="100%">
                                <?php if (php72_count($inv_team) > 0) { ?>
                                    <tr class="even">
                                        <td colspan="2" style="background-color:#FFF"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="background-color:#FFF"><b>Team information </b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="background-color:#FFF"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table width="100%">
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($inv_team as $team) {
                                                            $i = $i + 1;
                                                            if ($team['mem_name'] != '' || $team['mem_occupation'] != '' || $team['mem_org'] != '' || $team['mem_email'] != '' || $team['mem_mobile'] != '' || $team['mem_resume'] != '') {
                                                                ?>

                                                        <tr class="odd">
                                                            <td style="margin-left:152px;font-size:14px;color:#A9CF55;font-weight:bold">
                                                                Member <?= $i ?></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr class="even">
                                                            <td>Name</td>
                                                            <td><?php echo $team['mem_name']; ?></td>
                                                        </tr>
                                                        <tr class="odd">
                                                            <td>Current designation / occupation</td>
                                                            <td><?php echo $team['mem_occupation']; ?></td>
                                                        </tr>
                                                        <tr class="even">
                                                            <td>Current organisation</td>
                                                            <td><?php echo $team['mem_org']; ?></td>
                                                        </tr>
                                                        <tr class="odd">
                                                            <td>Email</td>
                                                            <td><?php echo $team['mem_email']; ?></td>
                                                        </tr>
                                                        <tr class="even">
                                                            <td>Mobile</td>
                                                            <td><?php echo $team['mem_mobile']; ?></td>
                                                        </tr>
                                                        <tr class="odd">
                                                            <td>Gender</td>
                                                            <td><?php echo $team['mem_gender']; ?></td>
                                                        </tr>
                                                        <tr class="even">
                                                            <td>Resume</td>
                                                            <td><?php
                                                                if ($team['mem_resume'] != '') {
                                                                    ?>
                                                                    <a href="<?php echo host_url() . 'IncubationForm/uploads/' . $team['mem_resume']; ?>"
                                                                       target="_blank"><?php echo $team['mem_resume']; ?></a>
                                                                   <?php } ?>
                                                            </td>
                                                        </tr>

                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if ($add_info[0]['company_description'] != '') { ?>
                        <tr class="even">
                            <td colspan="2" style="background-color:#FFF"></td>
                        </tr>
                        <tr class="even">
                            <td style="width:50%">How did you hear about our program</td>
                            <td><?php echo $add_info[0]['hear_abt']; ?></td>
                        </tr>
                        <?php
                        $hear_abt = explode(",", $add_info[0]['hear_abt']);
                        if (php72_in_array('Referral', $hear_abt) || php72_in_array('Past incubatee', $hear_abt) || php72_in_array('Villgro staff', $hear_abt)) {
                            ?>
                            <tr class="odd">
                                <td>Name</td>
                                <td><?php echo $add_info[0]['referal_name']; ?></td>
                            </tr>
                        <?php }
                        ?>

                        <tr class="even">
                            <td>Brief description of your company </td>
                            <td><?php echo $add_info[0]['company_description']; ?></td>
                        </tr>

                        <?php if ($add_info[0]['inv_idea_ent'] != '') { ?>
                            <tr class="odd">
                                <td>What is innovative about your idea/incubatee</td>
                                <td><?php echo $add_info[0]['inv_idea_ent']; ?></td>
                            </tr>
                        <?php } ?>



                    <?php } else {
                        ?>
                        <tr class="even">
                            <td colspan="2" style="background-color:#FFF"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color:#FFF"><b>Information about incubatee</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color:#FFF"></td>
                        </tr>
                        <tr class="even">
                            <td style="width:50%">How long have you been in operation</td>
                            <td><?php
                                switch ($inv_ent_info[0]['in_operation']) {
                                    case '0to6':
                                        echo "0 – 6 months";
                                        break;
                                    case '6to12':
                                        echo "6 – 12 months";
                                        break;
                                    case '1':
                                        echo "1 year";
                                        break;
                                    case '2':
                                        echo "2 years";
                                        break;
                                }
                                ?></td>
                        </tr>


                        <tr class="odd">
                            <td>In which states are you operating / plan to operate</td>
                            <td><?php
                                if ($inv_ent_info[0]['operate_on_state'] != '') {
                                    $states = explode(',', $inv_ent_info[0]['operate_on_state']);
                                    $state_list = '';
                                    foreach ($states as $state) {
                                        if ($state_list != '')
                                            $state_list = $state_list . ', ' . $this->Minnovation->getStateName($state);
                                        else
                                            $state_list = $this->Minnovation->getStateName($state);
                                    }
                                    echo $state_list;
                                }
                                ?></td>
                        </tr>

                        <tr class="even">
                            <td>Are you developing a</td>
                            <td><?php echo $inv_ent_info[0]['develop_product']; ?></td>
                        </tr>

                        <tr class="odd">
                            <td>At what stage is your product / service</td>
                            <td><?php echo $inv_ent_info[0]['stage_product']; ?></td>
                        </tr>

                        <tr class="even">
                            <td>Provide a brief description of your innovation (product or service)</td>
                            <td><?php echo nl2br($inv_ent_info[0]['inv_desc']); ?></td>
                        </tr>

                        <tr class="odd">
                            <td>What problem does your innovation address? </td>
                            <td><?php echo nl2br($inv_ent_info[0]['inv_problem']); ?></td>
                        </tr>

                        <tr class="even">
                            <td>How is the need addressed without your innovation? What are the available alternatives? </td>
                            <td><?php echo nl2br($inv_ent_info[0]['inv_alternatives']); ?></td>
                        </tr>

                        <tr class="odd">
                            <td>Describe your proposed / current business model </td>
                            <td><?php echo nl2br($inv_ent_info[0]['proposal_desc']); ?></td>
                        </tr>

                        <tr class="even">
                            <td>What challenges / risks have you identified in the business?</td>
                            <td><?php echo nl2br($inv_ent_info[0]['inv_risks']); ?></td>
                        </tr>


                        <tr class="odd">
                            <td colspan="2" style="background-color:#FFF"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color:#FFF"><b>Impact of innovation </b></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color:#FFF"></td>
                        </tr>


                        <tr class="even">
                            <td>Who is the intended primary beneficiary of your product / service? </td>
                            <td><?php echo nl2br($inv_impact[0]['primary_benifi']); ?></td>
                        </tr>
                        <tr class="odd">
                            <td>Have you conducted research on your customer segments / run pilots?</td>
                            <td><?php echo $inv_impact[0]['research_cus_seg']; ?></td>
                        </tr>

                        <?php if ($inv_impact[0]['research_cus_seg'] == 'yes') {
                            ?>
                            <tr class="even">
                                <td>What is the demographic profile of the primary beneficiary group? </td>
                                <td><?php echo nl2br($inv_impact[0]['demographic_profie']); ?></td>
                            </tr>


                            <tr class="odd">
                                <td>What is the average monthly earning of the primary beneficiary group? </td>
                                <td><?php echo nl2br($inv_impact[0]['avg_monthly']); ?></td>
                            </tr>
                        <?php } ?>
                        <tr class="even">
                            <td>How many people do you expect to impact through your innovation? </td>
                            <td><?php echo nl2br($inv_impact[0]['inv_impact']); ?></td>
                        </tr>

                        <tr class="odd">
                            <td>Will your product or service benefit other beneficiary groups? Describe these groups briefly. </td>
                            <td><?php echo nl2br($inv_impact[0]['others_benefit']); ?></td>
                        </tr>


                        <tr class="even">
                            <td colspan="2" style="background-color:#FFF"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color:#FFF"><b>Additional information </b></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color:#FFF"></td>
                        </tr>

                        <?php
                        $get_from_villgro = explode(',', $add_info[0]['from_villgro']);
                        $from_villgro = implode(', ', $get_from_villgro);
                        ?>

                        <tr class="odd">
                            <td>Please indicate the support you would like from us</td>
                            <td><?php echo str_replace(',', ', ', $add_info[0]['from_villgro']); ?></td>
                        </tr>
                        <?php
                        $support = explode(",", $add_info[0]['from_villgro']);
                        if (in_array('Other', $support)) {
                            ?>
                            <tr class="even">
                                <td>Other Support</td>
                                <td><?php echo $add_info[0]['support_name']; ?></td>
                            </tr>
                            <?php
                        }
                        ?>

                        <?php
                        $get_hear_abt = explode(',', $add_info[0]['hear_abt']);
                        $hear_abt = implode(', ', $get_hear_abt);
                        ?>

                        <tr class="odd">
                            <td>How did you hear about our program</td>
                            <td><?php echo $add_info[0]['hear_abt']; ?></td>
                        </tr>
                        <?php
                        $hear_abt = explode(",", $add_info[0]['hear_abt']);
                        if (php72_in_array('Referral', $hear_abt) || php72_in_array('Past incubatee', $hear_abt) || php72_in_array('Villgro staff', $hear_abt)) {
                            ?>
                            <tr class="even">
                                <td>Name</td>
                                <td><?php echo $add_info[0]['referal_name']; ?></td>
                            </tr>
                            <?php
                        }
                        ?>

                        <tr class="even">
                            <td>Have you been incubated, funded or participated in an accelerator program with another
                                organization?</td>
                            <td><?php echo $add_info[0]['ant_org']; ?></td>
                        </tr>
                        <?php if ($add_info[0]['ant_org'] == 'Yes') { ?>
                            <tr class="even">
                                <td>Name of organization(s)</td>
                                <td><?php echo $add_info[0]['ant_org_name']; ?></td>
                            </tr>
                        <?php } ?>
                        <tr class="odd">
                            <td>Have you participated in or won any business plan competitions?</td>
                            <td><?php echo $add_info[0]['won_competition']; ?></td>
                        </tr>

                        <?php if ($add_info[0]['won_competition'] == 'Yes') { ?>
                            <tr class="odd">
                                <td>Name of business plan competition(s)</td>
                                <td><?php echo $add_info[0]['competition_name']; ?></td>
                            </tr>
                        <?php } ?>

                        <tr class="even">
                            <td>Business plan (if available)</td>
                            <td><?php
                                if ($add_info[0]['business_plan'] != '') {
                                    ?>
                                    <a href="<?php echo host_url() . 'IncubationForm/uploads/' . $add_info[0]['business_plan']; ?>"
                                       target="_blank"><?php echo $add_info[0]['business_plan']; ?></a>
                                   <?php } ?>
                            </td>
                        </tr>

                        <tr class="even">
                            <td>Additional Information</td>
                            <td><?php
                                if ($add_info[0]['add_info'] != '') {
                                    ?>
                                    <a href="<?php echo host_url() . 'IncubationForm/uploads/' . $add_info[0]['add_info']; ?>"
                                       target="_blank"><?php echo $add_info[0]['add_info']; ?></a>
                                <?php } ?></td>
                        </tr>

                    <?php } ?>



                    </p>
            </table>
        <?php } else { ?>

            <table id="inv_add_info" class="gtable" width="100%">
                <tr class="even">
                    <td colspan="2" style="background-color:#FFF"></td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color:#FFF"><b>MCH Information</b></td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color:#FFF"></td>
                </tr>
                <tr class="odd">
                    <td style="width:50%;"> Have you already started a company?</td>
                    <td><?php echo isset($mch_users[0]['start_company']) ? $mch_users[0]['start_company'] : ''; ?></td>
                </tr>
                <?php if ($mch_users[0]['start_company'] == 'Yes') { ?>
                    <tr class="even">
                        <td>How old is it?</td>
                        <td><?php echo isset($mch_users[0]['company_age']) ? $mch_users[0]['company_age'] : ''; ?></td>
                    </tr>
                    <tr class="odd">
                        <td>What stage is it?</td>
                        <td><?php echo isset($mch_users[0]['company_stage']) ? $mch_users[0]['company_stage'] : ''; ?></td>
                    </tr>
                <?php } ?>
                <tr class="even">
                    <td>What is your citizenship status?</td>
                    <td><?php echo isset($mch_users[0]['citizen_status']) ? $mch_users[0]['citizen_status'] : ''; ?></td>
                </tr>
                <tr class="odd">
                    <td>Is your background?</td>
                    <td><?php echo isset($mch_users[0]['background']) ? $mch_users[0]['background'] : ''; ?></td>
                </tr>
                <tr class="even">
                    <td>Describe the problem in Maternal and Child Health you are most interested in solving?</td>
                    <td><?php echo isset($mch_users[0]['mch_problem']) ? $mch_users[0]['mch_problem'] : ''; ?></td>
                </tr>
                <tr class="odd">
                    <td>Why you are interested in solving this particular problem?</td>
                    <td><?php echo isset($mch_users['problem_solving']) ? $mch_users['problem_solving'] : ''; ?></td>
                </tr>
                <tr class="even">
                    <td>What are your strengths/experience that will help you develop a medical device to solve this problem?
                    </td>
                    <td><?php echo isset($mch_users[0]['strength_exp']) ? $mch_users[0]['strength_exp'] : ''; ?></td>
                </tr>
                <tr class="odd">
                    <td>Do you have any ideas about how to solve it? If so how much work have you done on exploring them?</td>
                    <td><?php echo isset($mch_users[0]['idea_problem']) ? $mch_users[0]['idea_problem'] : ''; ?></td>
                </tr>
                <tr class="even">
                    <td>Why are you interested in solving problems related to maternal and child health for the base of the
                        pyramid?</td>
                    <td><?php echo isset($mch_users[0]['intrest_solve']) ? $mch_users[0]['intrest_solve'] : ''; ?></td>
                </tr>
                <tr>
                    <td>Will you be working on this problem:</td>
                    <td><?php echo isset($mch_users[0]['problem_time']) ? $mch_users[0]['problem_time'] : ''; ?></td>
                </tr>
                <tr class="odd">
                    <td colspan="2" style="background-color:#FFF"></td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color:#FFF">Reference 1:</td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color:#FFF"></td>
                </tr>
                <tr class="even">
                    <td>Name</td>
                    <td><?php echo isset($mch_users[0]['name1']) ? $mch_users[0]['name1'] : ''; ?></td>
                </tr>
                <tr class="odd">
                    <td>Email</td>
                    <td><?php echo isset($mch_users[0]['email1']) ? $mch_users[0]['email1'] : ''; ?></td>
                </tr>
                <tr class="even">
                    <td>Phone</td>
                    <td><?php echo isset($mch_users[0]['phone1']) ? $mch_users[0]['phone1'] : ''; ?></td>
                </tr>
                <tr class="odd">
                    <td colspan="2" style="background-color:#FFF"></td>
                </tr>
                <tr class="even">
                    <td colspan="2" style="background-color:#FFF">Reference 2:</td>
                </tr>
                <tr class="odd">
                    <td colspan="2" style="background-color:#FFF"></td>
                </tr>
                <tr class="even">
                    <td>Name</td>
                    <td><?php echo isset($mch_users[0]['name2']) ? $mch_users[0]['name2'] : ''; ?></td>
                </tr>
                <tr class="odd">
                    <td>Email</td>
                    <td><?php echo isset($mch_users[0]['email2']) ? $mch_users[0]['email2'] : ''; ?></td>
                </tr>
                <tr class="even">
                    <td>Phone</td>
                    <td><?php echo isset($mch_users[0]['phone2']) ? $mch_users[0]['phone2'] : ''; ?></td>
                </tr>

                <tr class="odd">
                    <td colspan="2" style="background-color:#FFF"></td>
                </tr>
                <tr class="even">
                    <td colspan="2" style="background-color:#FFF">Reference 3:</td>
                </tr>
                <tr class="odd">
                    <td colspan="2" style="background-color:#FFF"></td>
                </tr>
                <tr class="even">
                    <td>Name</td>
                    <td><?php echo isset($mch_users[0]['name3']) ? $mch_users[0]['name3'] : ''; ?></td>
                </tr>
                <tr class="odd">
                    <td>Email</td>
                    <td><?php echo isset($mch_users[0]['email3']) ? $mch_users[0]['email2'] : ''; ?></td>
                </tr>
                <tr class="even">
                    <td>Phone</td>
                    <td><?php echo isset($mch_users[0]['phone3']) ? $mch_users[0]['phone3'] : ''; ?></td>
                </tr>
                <tr class="odd">
                    <td>Upload Resume</td>

                    <td><?php
                        if (isset($mch_users) && !empty($mch_users)) {
                            if ($mch_users[0]['documents'] != '') {
                                ?>
                                <a href="<?php echo host_url() . 'IncubationForm/uploads/' . $mch_users[0]['documents']; ?>"
                                   target="_blank"><?php echo $mch_users[0]['documents']; ?></a>
                                   <?php
                               }
                           }
                           ?></td>
                </tr>

            </table>

        <?php } //MCH end    ?>
    </td>
    </tr>
    </tbody>
    </table>
    </div>
<?php } ?>


<script type="text/javascript">
    var inv_ID = "<?php echo $innovation['id']; ?>";
    $('#innovation_id').val(inv_ID);

    $('#assign_incharge').on('click', function () {
        Populate();
    });

    $('#save_action').on('click', function () {
        var action_value = $('#inv_sector').val();
        if (action_value == '1') {
            Populate();
            jQuery.fancybox([{
                    href: '#approve_sheet'
                }]);
        }
    });

    function changeFancyClass(txt) {
        if (txt == 3) {
            $('#save_action').removeClass('fancybox');
        } else {
            $('#save_action').addClass('fancybox button');
        }
    }

    function Populate() {
        var invID = "<?php echo $innovation['id']; ?>";
        $('#innovations').val(invID);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/scouting/getassemployee",
            data: {
                id: invID
            },
            dataType: 'json',
            success: function (msg) {
                var arr = msg;
                for (var prop in arr) {
                    console.log(arr[prop]['associate_employee']);
                    $('#associate_employee option').map(function () {
                        if (arr[prop]['associate_employee'] == $(this).val()) {
                            $(this).attr("selected", 'selected');
                        }
                    });
                }
            },
        });
    }

    function attachmentDownload(inv_id, program, doc1, doc2) {
        if (confirm("Do you want to download attached documents as well?") == true) {
            if (inv_id != '') {
                var url = "<?php echo base_url() . 'index.php/scouting/export_deals_pdf/'; ?>";
                window.location.href = url + inv_id;
            }
            setTimeout(function () {
                attachedfile(program, doc1, doc2)
            }, 10000);
        } else {
            if (inv_id != '') {
                var url = "<?php echo base_url() . 'index.php/scouting/export_deals_pdf/'; ?>";
                window.location.href = url + inv_id;
            }
        }
    }

    function attachedfile(program, doc1, doc2) {
        var url;
        if (program == 0) {
            url = "<?php echo host_url() . 'IncubationForm/mis_download.php?file_name='; ?>";
        } else {
            url = "<?php echo host_url() . 'pitchform/mis_download.php?file_name='; ?>";
        }
        if (doc1 != '') {
            window.location.href = url + doc1;
        }
        var myset = setTimeout(function () {
            if (doc2 != '') {
                window.location.href = url + doc2;
            }
        }, 10000);
    }
</script>