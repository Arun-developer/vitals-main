<!-- Rejection mail triggering on close action -->
<?php
$innovationID = $innovation['id'];
$formAction = site_url('common/mail/form/' . $innovationID);
header('Content-type: text/html; charset=UTF-8');
require_once ("./language/lang_hi.php");
require_once ("./language/state_city_hi.php");


$user_lang_code = $pitch_user[0]['lang_code'];

/* foreach($get_all_sectors as $lists){
  $str = str_replace('/', '', strtolower(preg_replace('/[ ,-\-&\-\(\)]+/', '_', $lists['sector'])));
  echo $lists['sector']; echo'------';echo $lang[$str];
  echo'<br>';
  }

  die;
  echo'<pre>';print_r($get_all_sectors);die;


  $str = str_replace('/', '', strtolower(preg_replace('/[ ,-\-&\-\(\)]+/', '_', $sectorName)));
  echo $lang[$str]; */
  ?>

  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
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
  <input type="hidden" name="innovation" value="<?= $innovation['id']; ?>" />
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


<script type="text/javascript">
    $(document).ready(function () {
        $("#add_info").hide();
        $("#ex_info").show();

        $('#ex_info').click(function () {
            $("#add_info").slideToggle();
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
                <option value="<?= $row['emp_number']; ?>"><?= $row['emp_name']; ?></option>
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
if ($innovationDetails[0]['created_by'] == $this->session->userdata('emp_number') && $this->session->userdata('partner_id') == $innovationDetails[0]['partner_id']) {
    $isEdit = true;
}

if (((in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || $innovation['isAssociate']) && ($this->session->userdata('partner_id') == $innovationDetails[0]['partner_id'])) || ($this->session->userdata('user_type') == 'superadmin') || $isEdit == true) {
    $isEdit = true;
    $isAssignCycle = true;
    if (!empty($pitch_user) && $pitch_user[0]['inno_id'] != '') {
        ?>
                                                                                                                                                <!--        <a href="<?= site_url('scouting/pitch_app_edit/' . $pitch_user[0]['inno_id'] . '/' . $pitch_user[0]['pitch_id']) ?>"
                                                                                                                                                   id="edit_form" style="float:right" class="button">Edit</a>-->
                                                                                                                                                   <?php
                                                                                                                                               }
                                                                                                                                           }
                                                                                                                                           ?>
                                                                                                                                           <?php if ($innovationDetails[0]['status'] != '3' && $innovation['isAssociate']) { ?>
                                                                                                                                            <a href="#form_container" id="assign_incharge" style="float:right" class="fancybox button">Assign In Charge</a>
                                                                                                                                        <?php } ?>
                                                                                                                                        <!--<a href="javascript:printDiv('print_table')" id="print_form" style="float:right" class="button">Print</a>-->
                                                                                                                                        <a href="javascript:void(0)" id="print_form" onclick="attachmentDownload('<?php echo $this->uri->segment('3'); ?>', '<?php echo $innovationDetails[0]['program']; ?>', '<?php echo $pitch_doc[0]['doc1']; ?>', '<?php echo $pitch_doc[0]['doc2']; ?>');" style="float:right" class="button">Download</a>
                                                                                                                                        <a id="logCommentsModal" class="fancybox button" href="#comments_log"
                                                                                                                                        style="float:right; cursor:pointer;">Shortlist / Comments</a>
                                                                                                                                        <?php if ($this->session->userdata('user_type') == 'employee') {
                                                                                                                                         ?>
                                                                                                                                         <a href="<?= site_url('scouting/innovation_pool/all') ?>" class="button" style="float:right">Back</a><?php } ?>
                                                                                                                                         <div id="print_table">
                                                                                                                                            <h1><?= $innovationDetails[0]['name_of_enterprise']; ?></h1>
                                                                                                                                            <ul class="inv-detail-status">
                                                                                                                                                <li><strong>Stage</strong> : <?php
                                                                                                                                                if ($innovationDetails[0]['stage'] == '2' && $isAssignCycle) {
                                                                                                                                                    ?>
                                                                                                                                                    <a href="<?= site_url('scouting/cycle/' . $row['id']) ?>"
                                                                                                                                                     class="fancybox button"><?= $stage[$innovationDetails[0]['stage']]; ?></a>
                                                                                                                                                     <?php
                                                                                                                                                 } else {
                                                                                                                                                     echo $stage[$innovationDetails[0]['stage']];
                                                                                                                                                 }
                                                                                                                                                 ?></li>
                                                                                                                                                 <li><strong>Status</strong> : <?= $status[$innovationDetails[0]['status']]; ?></li>

                                                                                                                                             </ul>

                                                                                                                                             <?php if ($innovationDetails[0]['status'] != '3' && $innovation['isAssociate']) { ?>
                                                                                                                                                <div class="inv-detail-status">
                                                                                                                                                    <form>
                                                                                                                                                        <strong>Action</strong> :
                                                                                                                                                        <select name="status" onchange="changeFancyClass(this.value);" id="inv_sector">
                                                                                                                                                            <?php if ($innovationDetails[0]['stage'] == '7') { ?>
                                                                                                                                                                <option value="1">Approve for PA/RD</option>
                                                                                                                                                            <?php } ?>
                                                                                                                                                            <option value="24">Open-Banked</option>
                                                                                                                                                            <option value="2">Close</option>
                                                                                                                                                        </select>

                                                                                                                                                        <span><a id="save_action" href="<?= site_url('scouting/action/close/' . $innovationID); ?>"
                                                                                                                                                           class="fancybox button">Save</a></span>
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
                                                                                                                                            } else if ($innovationDetails[0]['status'] == '3') {
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


                                                                                                                                        <span><a id="logStatusModal" class="fancybox button" href="#status_log" style="float:right; cursor:pointer;">Application Status Log</a></span>

                                                                                                                                        <?php
                                                                                                                                        foreach ($pitch_user as $row):

                                                                                                                                            $this->db->select("city_name");
                                                                                                                                            $this->db->where('id', $row['city']);
                                                                                                                                            $q = $this->db->get('partner_city');
                                                                                                                                            $city = $q->result_array();
                                                                                                                                            $city_name = $city[0]['city_name'];
                                                                                                                                            ?>
                                                                                                                                            <div id="user-grid" class="grid-view">
                                                                                                                                                <table width="80%" class="items gtable" bgcolor="#F5F5F5" cellspacing="5" cellpadding="5" border="1px">
                                                                                                                                                    <thead>
                                                                                                                                                        <tr>
                                                                                                                                                            <th colspan="2"><?= $row['org_name']; ?></th>
                                                                                                                                                        </tr>
                                                                                                                                                    </thead>
                                                                                                                                                    <tbody>
                                                                                                                                                        <tr>
                                                                                                                                                            <td colspan="2" style="background-color:#FFF"></td>
                                                                                                                                                        </tr>
                                                                                                                                                        <tr>
                                                                                                                                                            <td colspan="2" style="background-color:#FFF"><b><?php
                                                                                                                                                            if (isset($lang['basic_information']) && $lang['basic_information'] != '') {
                                                                                                                                                                echo $lang['basic_information'];
                                                                                                                                                            } else {
                                                                                                                                                                echo 'Basic Information';
                                                                                                                                                            }
                                                                                                                                                            ?></b></td>
                                                                                                                                                        </tr>
                                                                                                                                                        <tr>
                                                                                                                                                            <td colspan="2" style="background-color:#FFF"></td>
                                                                                                                                                        </tr>
                                                                                                                                                        <tr class="odd">
                                                                                                                                                            <td style="width:40%;border-right:thick solid #fff;"><?php
                                                                                                                                                            if (isset($lang['innovation_id']) && $lang['innovation_id'] != '') {
                                                                                                                                                                echo $lang['innovation_id'];
                                                                                                                                                            } else {
                                                                                                                                                                echo 'Innovation Id';
                                                                                                                                                            }
                                                                                                                                                            ?> </td>
                                                                                                                                                            <td><?= $innovationDetails[0]['copy_id'] . '_' . $innovationDetails[0]['partner_id'] . '_' . $innovationDetails[0]['partner_count']; ?>
                                                                                                                                                        </td>
                                                                                                                                                    </tr>
                                                                                                                                                    <tr class="even">
                                                                                                                                                        <td><?php
                                                                                                                                                        if (isset($lang['partner']) && $lang['partner'] != '') {
                                                                                                                                                            echo $lang['partner'];
                                                                                                                                                        } else {
                                                                                                                                                            echo 'Partner';
                                                                                                                                                        }
                                                                                                                                                        ?></td>
                                                                                                                                                        <td><?= ucfirst($innovationDetails[0]['branch_name']) ?></td>
                                                                                                                                                    </tr>
                                                                                                                                                    <tr class="odd">
                                                                                                                                                        <td><?php
                                                                                                                                                        if (isset($lang['name_of_the_org']) && $lang['name_of_the_org'] != '') {
                                                                                                                                                            echo $lang['name_of_the_org'];
                                                                                                                                                        } else {
                                                                                                                                                            echo "Name of the organisation";
                                                                                                                                                        }
                                                                                                                                                        ?></td>
                                                                                                                                                        <td><?= $row['org_name_hi']; ?></td>
                                                                                                                                                    </tr>
                                                                                                                                                    <tr class="even">
                                                                                                                                                        <td style="border-right:thick solid #fff;"><?php
                                                                                                                                                        if (isset($lang['name_of_the_applicant']) && $lang['name_of_the_applicant'] != '') {
                                                                                                                                                            echo $lang['name_of_the_applicant'];
                                                                                                                                                        } else {
                                                                                                                                                            echo "Name of the applicant";
                                                                                                                                                        }
                                                                                                                                                        ?></td>
                                                                                                                                                        <td><?= $row['app_name_hi']; ?></td>
                                                                                                                                                    </tr>
                                                                                                                                                    <tr class="even">
                                                                                                                                                        <td style="border-right:thick solid #fff;"><?php
                                                                                                                                                        if (isset($lang['designation_of_the_applicant']) && $lang['designation_of_the_applicant'] != '') {
                                                                                                                                                            echo $lang['designation_of_the_applicant'];
                                                                                                                                                        } else {
                                                                                                                                                            echo "Designation of the Applicant";
                                                                                                                                                        }
                                                                                                                                                        ?></td>
                                                                                                                                                        <td><?= $row['designation_hi']; ?></td>
                                                                                                                                                    </tr>
                                                                                                                                                    <tr class="even">
                                                                                                                                                        <td style="border-right:thick solid #fff;"><?php
                                                                                                                                                        if (isset($lang['gender_of_applicant']) && $lang['gender_of_applicant'] != '') {
                                                                                                                                                            echo $lang['gender_of_applicant'];
                                                                                                                                                        } else {
                                                                                                                                                            echo "Gender of Applicant";
                                                                                                                                                        }
                                                                                                                                                        ?></td>
                                                                                                                                                        <td><?= $lang[$row['gender']]; ?></td>
                                                                                                                                                    </tr>
                                                                                                                                                    <?php if ($row['application_type'] == 2) { ?>
                                                                                                                                                        <tr class="odd">
                                                                                                                                                            <td><?php
                                                                                                                                                            if (isset($lang['what_is_your_enterprise_registered_as']) && $lang['what_is_your_enterprise_registered_as'] != '') {
                                                                                                                                                                echo $lang['what_is_your_enterprise_registered_as'];
                                                                                                                                                            } else {
                                                                                                                                                                echo 'What is your enterprise registered as';
                                                                                                                                                            }
                                                                                                                                                            ?></td>
                                                                                                                                                            <td><?= $row['enterprise_registered_under']; ?></td>
                                                                                                                                                        </tr>
                                                                                                                                                    <?php } ?>
                    <!--
    <tr class="even">
    <td style="border-right:thick solid #fff;"><?php
                    if (isset($lang['gst_num']) && $lang['gst_num'] != '') {
                        echo $lang['gst_num'];
                    } else {
                        echo "GST number";
                    }
                    ?></td>
    <td><?php echo isset($row['gst_number']) && $row['gst_number'] != '' ? $row['gst_number'] : '-'; ?></td>
</tr> -->

<tr class="even">
    <td><?php
    if (isset($lang['email_address']) && $lang['email_address'] != '') {
        echo $lang['email_address'];
    } else {
        echo 'Email Address';
    }
    ?></td>
    <td><?= $row['email']; ?></td>
</tr>
<tr class="odd">
    <td style="border-right:thick solid #fff;"><?php
    if (isset($lang['mobile_number']) && $lang['mobile_number'] != '') {
        echo $lang['mobile_number'];
    } else {
        echo "Mobile number";
    }
    ?></td>
    <td><?= $row['mobileno']; ?></td>
</tr>
<tr class="even">
    <td><?php
    if (isset($lang['alternate_phone_number']) && $lang['alternate_phone_number'] != '') {
        echo $lang['alternate_phone_number'];
    } else {
        echo "Alternate phone number";
    }
    ?></td>
    <td><?= $alt = (($row['altmobileno'] !== ' ' && $row['altmobileno'] !== '0') ? $row['altmobileno'] : '') ?>
</td>
</tr>

<?php if ($row['application_type'] == 2) { ?>
    <tr class="even">
        <td><?php
        if (isset($lang['components']) && $lang['components'] != '') {
            echo $lang['components'];
        } else {
            echo 'Components';
        }
        ?></td>
        <?php
        $get_components = unserialize($row['components']);
        ?>
        <td><?php echo implode(', ', $get_components); ?></td>
    </tr>
    <tr class="odd">
        <?php
        $get_beneficiary = unserialize($row['beneficiary']);
        ?>
        <td><?php
        if (isset($lang['primary_beneficiaries']) && $lang['primary_beneficiaries'] != '') {
            echo $lang['primary_beneficiaries'];
        } else {
            echo 'Primary beneficiaries';
        }
        ?></td>
        <td><?php echo implode(', ', $get_beneficiary); ?></td>
    </tr>
<?php } ?>
<tr class="even">
    <td style="border-right:thick solid #fff;"><?php
    if (isset($lang['date_created']) && $lang['date_created'] != '') {
        echo $lang['date_created'];
    } else {
        echo 'Date Created';
    }
    ?></td>
    <td><?= date('Y-m-d', strtotime($row['reg_date'])) ?></td>
</tr>

<tr class="odd">
    <td style="border-right:thick solid #fff;"><?php
    if (isset($lang['source']) && $lang['source'] != '') {
        echo $lang['source'];
    } else {
        echo 'Source';
    }
    ?></td>
    <td>

        <?php
                            //echo'<pre>';print_r($innovationDetails);die;
        if ($innovationDetails[0]['source'] == '126' && $innovationDetails[0]['sourceType'] == '135') {
            echo $innovationDetails[0]['source_type'] . ' - ' . $innovationDetails[0]['source_name'];
        } else if ($innovationDetails[0]['source'] == '124') {
            echo $innovationDetails[0]['source_type'] . ' - ' . $innovationDetails[0]['source_name'];
        }
        ?>

    </td>
</tr>
<tr></tr>
<tr></tr>
<tr>
    <td colspan="2"><a href="#bottom" id="ex_info" style="color:#719e41;">** <?php
    if (isset($lang['additional_informationi']) && $lang['additional_informationi'] != '') {
        echo $lang['additional_informationi'];
    } else {
        echo 'Additional Information';
    }
    ?></a>
    <table id="add_info" class="gtable" width="100%">
        <?php if (count($pitch_member) > 0) { ?>
            <tr>
                <td colspan="2" style="background-color:#FFF"></td>
            </tr>
            <tr>
                <td colspan="2" style="background-color:#FFF"><b><?php
                if (isset($lang['application_information']) && $lang['application_information'] != '') {
                    echo $lang['application_information'];
                } else {
                    echo 'Application Information';
                }
                ?></b></td>
            </tr>
            <tr>
                <td colspan="2" style="background-color:#FFF"></td>
            </tr>
            <tr></tr>
            <tr class="odd">
                <td colspan="2">
                    <table width="100%" class="gtable" style="background-color:none" cellspacing="2"
                    cellpadding="2">

                    <tr>
                        <?php
                        $i = 0;
                        foreach ($pitch_member as $team):
                            $i = $i + 1;
                            if ($team['name'] != '' || $team['linkedin'] != '' || $team['cur_title'] != '' || $team['email'] != '' || $team['phone'] != '' || $team['gender'] != '') {
                                ?>

                                <td>
                                    <table style="font: 12px/15px Arial,sans-serif;background-color:none"
                                    cellspacing="2" cellpadding="2" border="1px;">
                                    <tr>
                                        <td colspan="2" style="background-color: #A9CF55;text-align: center;"><?php
                                        if (isset($lang['team_member']) && $lang['team_member'] != '') {
                                            echo $lang['team_member'];
                                        } else {
                                            echo "Team Member";
                                        }
                                        ?> <?= $i ?></td>
                                    </tr>
                                    <tr class="even">
                                        <td style="border-right:thin solid #fff;"><?php
                                        if (isset($lang['name']) && $lang['name'] != '') {
                                            echo $lang['name'];
                                        } else {
                                            echo "Name";
                                        }
                                        ?></label></dt><dd><?php echo $fit_name[0]['name']; ?></td>
                                            <td><?= $team['name_hi']; ?></td>
                                        </tr>
                                        <tr class="odd">
                                            <td style="border-right:thin solid #fff;"><?php
                                            if (isset($lang['title']) && $lang['title'] != '') {
                                                echo $lang['title'];
                                            } else {
                                                echo "Designation";
                                            }
                                            ?></label></dt><dd><?php echo $fit_title[0]['title']; ?></td>
                                                <td><?= $team['cur_title_hi']; ?></td>
                                            </tr>
                                            <tr class="even">
                                                <td style="border-right:thin solid #fff;"><?php
                                                if (isset($lang['email']) && $lang['email'] != '') {
                                                    echo $lang['email'];
                                                } else {
                                                    echo "Email ID";
                                                }
                                                ?></label></dt><dd><?php echo $fit_email[0]['email']; ?></td>
                                                    <td><?= $team['email']; ?></td>
                                                </tr>
                                                <tr class="odd">
                                                    <td style="border-right:thin solid #fff;"><?php
                                                    if (isset($lang['gender']) && $lang['gender'] != '') {
                                                        echo $lang['gender'];
                                                    } else {
                                                        echo "Gender";
                                                    }
                                                    ?></label></dt><dd><?php echo $lang[$fit_gender[0]['gender']]; ?></td>
                                                        <td><?= $lang[$team['gender']]; ?></td>
                                                    </tr>
                                                    <tr class="odd">
                                                        <td style="border-right:thin solid #fff;"><?php
                                                        if (isset($lang['age']) && $lang['age'] != '') {
                                                            echo $lang['age'];
                                                        } else {
                                                            echo 'Age';
                                                        }
                                                        ?></label></dt><dd><?php echo isset($fit_age[0]['age']) ? $fit_age[0]['age'] : ''; ?></td>
                                                            <td><?= ucfirst($team['age']); ?></td>
                                                        </tr>
                                                        <tr class="even">
                                                            <td style="border-right:thin solid #fff;"><?php
                                                            if (isset($lang['highest_eucational_qualification']) && $lang['highest_eucational_qualification'] != '') {
                                                                echo $lang['highest_eucational_qualification'];
                                                            } else {
                                                                echo 'Highest Educational Qualification';
                                                            }
                                                            ?></label></dt><dd><?php
                                                            if (isset($fit_education_qualify[0]['education_qualify']) && $fit_education_qualify[0]['education_qualify'] != '') {
                                                                echo $fit_education_qualify[0]['education_qualify'];
                                                            }
                                                            ?></td>
                                                            <td><?= $team['education_qualify_hi']; ?></td>
                                                        </tr>
                                                        <tr class="even">
                                                            <td style="border-right:thin solid #fff;"><?php
                                                            if (isset($lang['mobile']) && $lang['mobile'] != '') {
                                                                echo $lang['mobile'];
                                                            } else {
                                                                echo "Mobile";
                                                            }
                                                            ?></label></dt><dd><?php echo $fit_phone[0]['phone']; ?></td>
                                                                <td><?= $team['phone']; ?></td>
                                                            </tr>

                                                            <tr class="odd">
                                                                <td style="border-right:thin solid #fff;">लिंक्डइन प्रोफाइल का लिंक</label></dt><dd><?php echo $fit_linkedin[0]['linkedin']; ?></td>
                                                                    <td><?= $team['linkedin']; ?></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    <?php } endforeach; ?>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr></tr>
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"><b><?php
                                    if (isset($lang['more_information_about_incubatee']) && $lang['more_information_about_incubatee'] != '') {
                                        echo $lang['more_information_about_incubatee'];
                                    } else {
                                        echo 'More information about incubatee';
                                    }
                                    ?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"></td>
                                </tr>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;">पप्रबंधन टीम के सदस्यों की कुल संख्या:  <?php
                                    if (isset($lang['no_of_male']) && $lang['no_of_male'] != '') {
                                        echo $lang['no_of_male'];
                                    } else {
                                        echo 'Management team composition: No. of Male';
                                    }
                                    ?></td>
                                    <td width="60%"><?php echo $pitch_info[0]['male_numb']; ?></td>
                                </tr>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;">पप्रबंधन टीम के सदस्यों की कुल संख्या:  <?php
                                    if (isset($lang['no_of_female']) && $lang['no_of_female'] != '') {
                                        echo $lang['no_of_female'];
                                    } else {
                                        echo 'Management team composition: No. of Female';
                                    }
                                    ?></td>
                                    <td width="60%"><?php echo $pitch_info[0]['female_numb']; ?></td>
                                </tr>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;">पप्रबंधन टीम के सदस्यों की कुल संख्या:  <?php
                                    if (isset($lang['no_of_transgender']) && $lang['no_of_transgender'] != '') {
                                        echo $lang['no_of_transgender'];
                                    } else {
                                        echo 'Management team composition: No. of Transgender';
                                    }
                                    ?></td>
                                    <td width="60%"><?php echo $pitch_info[0]['transgender_numb']; ?></td>
                                </tr>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;"><?php
                                    if (isset($lang['company_website_link']) && $lang['company_website_link'] != '') {
                                        echo $lang['company_website_link'];
                                    } else {
                                        echo "Does your company have a website? If yes, specify the link.(Enter NA if you do not have a website)";
                                    }
                                    ?></td>
                                    <td width="60%"><?php echo @$pitch_org[0]['website_hi']; ?></td>
                                </tr>
                                <?php
                                $get_state_city = Mincharge::get_state_city($pitch_info[0]['state_id'], $pitch_info[0]['city_id']);
                                $get_sectorName = unserialize($pitch_org[0]['sector']);
                                $sectorName = $get_sectorName[0];
                                $subsectorName = Mincharge::getSubsectorName($pitch_org[0]['sub_sector']);
                                ?>
                                <?php
                                if ($row['application_type'] != 2) {
                                    if (@$pitch_info[0]['ent_type'] == 'profit') {
                                        $ent_type = 'For-profit Organization';
                                    } else {
                                        $ent_type = 'Non-profit Organization';
                                    }
                                    ?>
                                    <tr class="even">
                                        <td width="30%" style="border-right:thick solid #fff;"><?php
                                        if (isset($lang['is_your_enterprise']) && $lang['is_your_enterprise'] != '') {
                                            echo $lang['is_your_enterprise'];
                                        } else {
                                            echo "Is your enterprise a";
                                        }
                                        ?>  </td>
                                        <td width="60%"><?php
                                        if (@$pitch_info[0]['ent_type'] == 'profit') {
                                            $ent_types = ' लाभ के लिए संगठन';
                                        } else {
                                            $ent_types = 'गैर लाभकारी संगठन';
                                        }
                                        echo $ent_types;
                                        ?></td>
                                    </tr>
                                <?php } ?>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;"><?php
                                    if (isset($lang['is_your_company_registered']) && $lang['is_your_company_registered'] != '') {
                                        echo $lang['is_your_company_registered'];
                                    } else {
                                        echo 'Is your company registered under the MCA?';
                                    }
                                    ?></td>
                                    <td width="60%"><?php
                                    echo

                                    $lang[lcfirst($pitch_info[0]['company_register'])];
                                    ?></td>
                                </tr>
                                <?php if ($pitch_info[0]['company_register'] == 'yes') { ?>
                                    <tr class="odd">
                                        <td width="30%" style="border-right:thick solid #fff;"><?php
                                        if (isset($lang['if_yes']) && $lang['if_yes'] != '') {
                                            echo $lang['if_yes'];
                                        } else {
                                            echo 'If Yes';
                                        }
                                        ?>,<?php
                                        if (isset($lang['cin_number']) && $lang['cin_number'] != '') {
                                            echo $lang['cin_number'];
                                        } else {
                                            echo 'CIN Number';
                                        }
                                        ?></td>
                                        <td width="60%"><?php
                                        echo $pitch_info[0]['cin_number_hi'];
                                        ?></td>
                                    </tr>
                                <?php } ?>
                                <tr class="even">
                                    <td width="30%" style="border-right:thick solid #fff;"><?php
                                    if (isset($lang['year_of_incorporation']) && $lang['year_of_incorporation'] != '') {
                                        echo $lang['year_of_incorporation'];
                                    } else {
                                        echo "Year of incorporation";
                                    }
                                    ?></td>
                                    <td width="60%"><?php echo @$pitch_org[0]['incorporation_year']; ?></td>
                                </tr>

                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;"><?php
                                    if (isset($lang['dipp_reg']) && $lang['dipp_reg'] != '') {
                                        echo $lang['dipp_reg'];
                                    } else {
                                        echo 'DIPP Registration';
                                    }
                                    ?></td>
                                    <td width="60%"><?php echo $lang[$pitch_info[0]['dipp_register']]; ?></td>
                                </tr>
                                <?php if ($pitch_info[0]['dipp_register'] == 'yes') { ?>
                                    <tr class="odd">
                                        <td width="30%" style="border-right:thick solid #fff;">यदि हां, तो DIPP नंबर</td>
                                        <td width="60%"><?php echo $pitch_info[0]['dipp_number_hi']; ?></td>
                                    </tr>
                                <?php } ?>

                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;"><?php
                                    if (isset($lang['headquarter_state']) && $lang['headquarter_state'] != '') {
                                        echo $lang['headquarter_state'];
                                    } else {
                                        echo "Headquarter State/UT";
                                    }
                                    ?></td>
                                    <td width="60%"><?php
                                    $underscore_val = strtolower(preg_replace('/\s+/', '_', $get_state_city[0]['state_name']));
                                    echo $lang[$underscore_val];
                                    ?></td>
                                </tr>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;"><?php
                                    if (isset($lang['headquarter_city']) && $lang['headquarter_city'] != '') {
                                        echo $lang['headquarter_city'];
                                    } else {
                                        echo "Headquarter City";
                                    }
                                    ?></td>
                                    <td width="60%"><?php
                                    $underscore_vall = strtolower(preg_replace('/\s+/', '_', $get_state_city[1]['city_name']));
                                    echo $lang[$underscore_vall];
                                    ?></td>
                                </tr>

                                <tr class="even">
                                    <td style="border-right:thick solid #fff;" width="30%">ऑपरेशन या संचालन का स्तर</td>
                                    <td width="60%"><?php
                                    if ($pitch_org[0]['operation_stage'] == "Idea") {
                                        echo $lang['idea_stage'];
                                    }
                                    if ($pitch_org[0]['operation_stage'] == "Commercial Piloting / Initial Paying Customers") {
                                        echo $lang['commercial_pilot_launched'];
                                    }
                                    if ($pitch_org[0]['operation_stage'] == "Minimum Viable Product / Prototype ready") {
                                        echo $lang['minimum_viable'];
                                    }
                                    if ($pitch_org[0]['operation_stage'] == "Scaling up / Rapid sales growth") {
                                        echo $lang['growth_stage_generating_revenue'];
                                    }
                                    ?></td>
                                </tr>

                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;"><?php
                                    if (isset($lang['sector']) && $lang['sector'] != '') {
                                        echo $lang['sector'];
                                    } else {
                                        echo "Sector";
                                    }
                                    ?></td>
                                    <td width="60%"><?php
                                    $str = str_replace('/', '', strtolower(preg_replace('/[ ,-\-&\-\(\)]+/', '_', $sectorName)));
                                    echo $lang[$str];
                                    ?></td>
                                </tr>

                                <?php if ($row['application_type'] != 2) { ?>
                                    <tr class="even">
                                        <td width="30%" style="border-right:thick solid #fff;"><?php
                                        if (isset($lang['sub_sector']) && $lang['sub_sector'] != '') {
                                            echo $lang['sub_sector'];
                                        } else {
                                            echo "Sub sector";
                                        }
                                        ?></td>
                                        <td width="60%"><?php
                                        $str = str_replace('/', '', strtolower(preg_replace('/[ ,-\-&\-\(\)]+/', '_', $subsectorName[0]['sector'])));
                        // echo $lang[$str];
                                        $sub_sector_spec = '';
                                        if ($subsectorName[0]['sector'] == 'Others') {
                                            $sub_sector_spec = ': - ' . $pitch_org[0]['subsector_other_spec_hi'];
                                        }
                                        echo $lang[$str] . $sub_sector_spec;
                                        ?>

                                    </td>
                                </tr>
                                <?php if (@$pitch_org[0]['other_subsector'] != '') { ?>
                                    <tr class="even">
                                        <td width="30%" style="border-right:thick solid #fff;"><?php
                                        if (isset($lang['Other_sub_sector']) && $lang['Other_sub_sector'] != '') {
                                            echo $lang['Other_sub_sector'];
                                        } else {
                                            echo "Other sub sector";
                                        }
                                        ?></td>
                                        <td width="60%"><?php
                                        if ($user_lang_code == 'hi') {
                                            echo $pitch_org[0]['other_subsector_hi'];
                                        } else {
                                            echo $pitch_org[0]['other_subsector'];
                                        }
                                        ?></td>
                                    </tr>
                                <?php } ?>


                <?php /* if ($subsectorName[0]['sector'] == 'Others') { ?>
                  <tr class="even">
                  <td width="30%" style="border-right:thick solid #fff;"><?php
                  if (isset($lang['specify']) && $lang['specify'] != '') {
                  echo $lang['specify'];
                  } else {
                  echo "specify";
                  }
                  ?></td>
                  <td width="60%"><?php echo @$pitch_org[0]['subsector_other_spec']; ?></td>
                  </tr>
              <?php } */ ?>






              <?php if ($subsectorName[0]['sector'] == 'Irrigation / Water management' && ($pitch_org[0]['operation_stage'] == 'Commercial Piloting / Initial Paying Customers' || $pitch_org[0]['operation_stage'] == 'Scaling up / Rapid sales growth')) { ?>
                <tr class="odd">
                    <td width="30%" style="border-right:thick solid #fff;"><?php
                    if (isset($lang['how_many_liters']) && $lang['how_many_liters'] != '') {
                        echo $lang['how_many_liters'];
                    } else {
                        echo "How many liters of water have you saved in the last one year?";
                    }
                    ?></td>
                    <td width="60%"><?php echo $pitch_org[0]['saved_water']; ?></td>
                </tr>
            <?php } ?>

            <tr class="odd">
                <td width="30%" style="border-right:thick solid #fff;"><?php
                if (isset($lang['revenue_of_company']) && $lang['revenue_of_company'] != '') {
                    echo $lang['revenue_of_company'];
                } else {
                    echo "Revenue of company";
                }
                ?>: 2019-20</td>
                <?php $fy_18 = isset($pitch_org[0]['fy_19_20']) && $pitch_org[0]['fy_19_20'] != '' ? $pitch_org[0]['fy_19_20'] : '0'; ?>
                <td width="60%"><?php echo $fy_18; ?></td>
            </tr>
            <tr class="even">
                <td width="30%" style="border-right:thick solid #fff;"><?php
                if (isset($lang['revenue_of_company']) && $lang['revenue_of_company'] != '') {
                    echo $lang['revenue_of_company'];
                } else {
                    echo "Revenue of company";
                }
                ?>: 2018-19</td>
                <?php $fy_17 = isset($pitch_org[0]['fy_18_19']) && $pitch_org[0]['fy_18_19'] != '' ? $pitch_org[0]['fy_18_19'] : '0'; ?>
                <td width="60%"><?php echo $fy_17; ?></td>
            </tr>
            <tr class="odd">
                <td width="30%" style="border-right:thick solid #fff;"><?php
                if (isset($lang['revenue_of_company']) && $lang['revenue_of_company'] != '') {
                    echo $lang['revenue_of_company'];
                } else {
                    echo "Revenue of company";
                }
                ?>: 2017-18 </td>
                <?php $fy_16 = isset($pitch_org[0]['fy_17_18']) && $pitch_org[0]['fy_17_18'] != '' ? $pitch_org[0]['fy_17_18'] : '0'; ?>
                <td width="60%"><?php echo $fy_16; ?></td>
            </tr>
            <?php if ($sectorName == 'Agri-business' || $sectorName == 'Energy & CleanTech' || $sectorName == 'Climate Action' || $sectorName == 'Healthcare' || $sectorName == 'ShelterTech & Housing') { ?>
                <tr class="odd">
                    <td width="30%" style="border-right:thick solid #fff;">आपके द्वारा दिए जाने वाले समाधान का सबसे अच्छा वर्णन क्या होगा?</td>

                    <td width="60%"><?php
                    if ($pitch_org[0]['describe_solution'] == 'Both are critical') {
                        echo $lang['both_are_critical'];
                    } else if ($pitch_org[0]['describe_solution'] == 'Hardware based') {
                        echo $lang['hardware_based'];
                    } else if ($pitch_org[0]['describe_solution'] == 'Service based') {
                        echo $lang['service_based'];
                    }
                    ?></td>
                </tr>
            <?php } ?>


            <?php if (@$pitch_org[0]['water_consumption'] == 'Yes') { ?>

                <?php
            }
        }
        ?>

    </tr>

    <tr class="odd">
        <td width="30%" style="border-right:thick solid #fff;"><?php
        if (isset($lang['have_you_filed_for']) && $lang['have_you_filed_for'] != '') {
            echo $lang['have_you_filed_for'];
        } else {
            echo 'Have you filed for any patent';
        }
        ?>?</td>
        <td width="60%">
            <?php
            if ($pitch_org[0]['patents'] == '1') {
                echo $lang['yes'];
            } else {
                echo $lang['no'];
            }
            ?>
        </td>
    </tr>
    <?php if ($pitch_org[0]['patents'] == '1') { ?>
        <tr class="odd">
            <td width="30%" style="border-right:thick solid #fff;"><?php
            if (isset($lang['if_yes_what_is_the_patent']) && $lang['if_yes_what_is_the_patent'] != '') {
                echo $lang['if_yes_what_is_the_patent'];
            } else {
                echo 'If Yes, what is the patent for:';
            }
            ?></td>
            <td width="60%"><?php echo $pitch_org[0]['patent_desc_hi']; ?> </td>
        </tr>
    <?php } ?>


    <tr class="odd">
        <td width="30%" style="border-right:thick solid #fff;"><?php
        if (isset($lang['have_you_raised_funds']) && $lang['have_you_raised_funds'] != '') {
            echo $lang['have_you_raised_funds'];
        } else {
            echo 'I Have you raised funds in the past?';
        }
        ?></td>
        <td width="60%">
            <?php
            if ($pitch_org[0]['past_fund'] == 'yes') {
                echo $lang['yes'];
            } else {
                echo $lang['no'];
            }
            ?>
        </td>
    </tr>
    <?php if ($pitch_org[0]['past_fund'] == 'yes') { ?>
        <tr class="odd">
            <td width="30%" style="border-right:thick solid #fff;"><?php
            if (isset($lang['total_grant_amount']) && $lang['total_grant_amount'] != '') {
                echo $lang['total_grant_amount'];
            } else {
                echo 'Total Grant Amount';
            }
            ?>  </td>
            <td width="60%"><?php echo $pitch_org[0]['grant_amount']; ?> </td>
        </tr>
        <tr class="odd">
            <td width="30%" style="border-right:thick solid #fff;"><?php
            if (isset($lang['total_equity_amount']) && $lang['total_equity_amount'] != '') {
                echo $lang['total_equity_amount'];
            } else {
                echo 'Total Equity Amount';
            }
            ?> </td>
            <td width="60%"><?php echo $pitch_org[0]['equity_amount']; ?> </td>
        </tr>
    <?php } ?>


    <tr class="odd">
        <td width="30%" style="border-right:thick solid #fff;">क्या आपने अपने समाधान के लिए पुरस्कार, मान्यता या पुरस्कार जीता है?</td>
        <td width="60%">
            <?php
            if ($pitch_org[0]['prize_recognition'] == 'yes') {
                echo $lang['yes'];
            } else {
                echo $lang['no'];
            }
            ?>
        </td>
    </tr>
    <?php if ($pitch_org[0]['prize_recognition'] == 'yes') { ?>
        <tr class="odd">
            <td width="30%" style="border-right:thick solid #fff;"><?php
            if (isset($lang['if_yes_specify_the_details']) && $lang['if_yes_specify_the_details'] != '') {
                echo $lang['if_yes_specify_the_details'];
            } else {
                echo 'If yes, Specify the details';
            }
            ?></td>
            <td width="60%"><?php echo $pitch_org[0]['awards_hi']; ?> </td>
        </tr>
    <?php } ?>



    <?php
    if ($row['application_type'] != 2) {
        if (@$pitch_org[0]['patents'] == '1') {
            $patents = $lang['yes'];
        } else {
            $patents = $lang['no'];
        }
        ?>

    <?php } ?>

    <?php if ($row['application_type'] != 2) { ?>
                                                                                    <!--  <tr class="odd">
                                                                                          <td width="30%" style="border-right:thick solid #fff;">Have you won a prize, recognition, award for your incubatee? If yes, please mention it.</td>
                                                                                          <td width="60%"><?php echo nl2br(@$pitch_org[0]['awards_hi']); ?></td>
                                                                                      </tr> -->

                                                                                  <?php } ?>
                                                                                  <tr class="odd">
                                                                                    <td width="30%" style="border-right:thick solid #fff;"><?php
                                                                                    if (isset($lang['how_is_your_company']) && $lang['how_is_your_company'] != '') {
                                                                                        echo $lang['how_is_your_company'];
                                                                                    } else {
                                                                                        echo "Has your company been incubated / accelerated by any institution?";
                                                                                    }
                                                                                    ?></td>
                                                                                    <td width="60%"><?php echo $lang[lcfirst($pitch_org[0]['accelerate_type'])]; ?></td>
                                                                                </tr>

                                                                                <?php if (@$pitch_org[0]['accelerate_type'] == 'Yes') { ?>
                                                                                    <tr class="odd">
                                                                                        <td width="30%" style="border-right:thick solid #fff;"><?php
                                                                                        if (isset($lang['if_yes_specify_name_of_incubator']) && $lang['if_yes_specify_name_of_incubator'] != '') {
                                                                                            echo $lang['if_yes_specify_name_of_incubator'];
                                                                                        } else {
                                                                                            echo 'If yes, specify the the name of the incubator / accelerator and the year of participation.';
                                                                                        }
                                                                                        ?> </td>
                                                                                        <td width="60%"><?php echo nl2br(@$pitch_org[0]['incubated_accelerated_hi']); ?></td>
                                                                                    </tr>
                                                                                <?php } ?>


                                                                                <tr class="even">
                                                                                    <td width="30%" style="border-right:thick solid #fff; width:50%;"><?php
                                                                                    if (isset($lang['briefly_explain']) && $lang['briefly_explain'] != '') {
                                                                                        echo $lang['briefly_explain'];
                                                                                    } else {
                                                                                        echo "Briefly explain the problem that you are addressing.";
                                                                                    }
                                                                                    ?> </td>
                                                                                    <td width="60%"><?php echo nl2br(@$pitch_org[0]['addr_problem_hi']); ?></td>
                                                                                </tr>
                                                                                <tr class="odd">
                                                                                    <td width="30%" style="border-right:thick solid #fff;">आपका उपाय समस्या को कैसे सुलझाता है, वर्णन करें।</td>
                                                                                    <td width="60%"><?php echo nl2br(@$pitch_org[0]['quest_1_hi']); ?></td>

                                                                                    <tr class="even">
                                                                                        <td width="30%" style="border-right:thick solid #fff;">आपका समाधान सामाजिक प्रभाव कैसे बना रहा है?</td>

                                                                                        <td width="60%"><?php echo nl2br(@$pitch_org[0]['ent_impact_hi']); ?></td>

                                                                                    </tr>



                                                                                    <tr class="odd">
                                                                                        <td width="30%" style="border-right:thick solid #fff;"><?php
                                                                                        if (isset($lang['does_your_solution']) && $lang['does_your_solution'] != '') {
                                                                                            echo $lang['does_your_solution'];
                                                                                        } else {
                                                                                            echo 'Does your solution directly impact women & girls?';
                                                                                        }
                                                                                        ?> </td>
                                                                                        <td width="60%">
                                                                                            <?php
                                                                                            if ($pitch_org[0]['direct_impact_status'] == 'Yes') {
                                                                                                echo $lang['yes'];
                                                                                            } else {
                                                                                                echo $lang['no'];
                                                                                            }
                                                                                            ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php if ($pitch_org[0]['direct_impact_status'] == 'Yes') { ?>
                                                                                        <tr class="odd">
                                                                                            <td width="30%" style="border-right:thick solid #fff;">यदि हाँ, तो कैसे ?</td>
                                                                                            <td width="60%"><?php echo $pitch_org[0]['direct_impact_sol_hi']; ?> </td>
                                                                                        </tr>
                                                                                    <?php } ?>



                                                                                    <?php
                                                                                    $aboutvill = explode(',', $pitch_org[0]['info_about_program']);
                                                                                    $aboutvill_om = explode(',', $pitch_org[0]['info_other_mailer']);

                                                                                    foreach ($aboutvill as $key => $value) {
                                                                                        if ($aboutvill[$key] == 'Other Mailers' && $pitch_org[0]['partner_name'] != '') {
                                                                                            $aboutvill[$key] = 'Other Mailers(' . trim($pitch_org[0]['partner_name']) . ') ';
                                                                                        } else if ($aboutvill[$key] == 'Past Incubatee' && $pitch_org[0]['inc_name'] != '') {
                                                                                            $aboutvill[$key] = 'Past Incubatee(' . trim($pitch_org[0]['inc_name']) . ') ';
                                                                                        } else if ($aboutvill[$key] == 'Referral' && $pitch_org[0]['referral_name'] != '') {
                                                                                            $aboutvill[$key] = 'Referral(' . trim($pitch_org[0]['referral_name']) . ') ';
                                                                                        }
                                                                                    }

                                                                                    $abtVill = implode(', ', $aboutvill);

                                                                                    $info_other_mailer_om = '';
                                                                                    $other_org_name = '';
                                                                                    if ($pitch_org[0]['info_other_mailer'] != '') {
                                                                                        $info_other_mailer_om = trim($pitch_org[0]['info_other_mailer']);
                                                                                    }
                                                                                    if ($pitch_org[0]['other_org_name_hi'] != '') {
                                                                                        $other_org_name = trim($pitch_org[0]['other_org_name_hi']);
                                                                                    }
                                                                                    ?>
                                                                                    <tr class="even">
                                                                                        <td style="border-right:thick solid #fff;" width="30%"><?php
                                                                                        if (isset($lang['how_did_you_hear']) && $lang['how_did_you_hear'] != '') {
                                                                                            echo $lang['how_did_you_hear'];
                                                                                        } else {
                                                                                            echo "How did you hear about us?";
                                                                                        }
                                                                                        ?></td>
                                                                                        <td width="60%"><?php
                                                                                        foreach ($aboutvill as $info_abtVill_val) {
                                                                                            $values = trim($info_abtVill_val);
                                                                                            if ($values == 'Villgro Mailer/Newsletter') {
                                                                                                echo $lang['villgro_mailer_news'] . ',';
                                                                                            } else if ($values == 'Other Mailers(Previous)') {
                                                                                                echo $lang['other_mailer_news'] . ',';
                                                                                                $test1 = '';
                                                                                                if ($details['partner_name_hi'] != '') {
                                                                                                    $test1 = ' (' . $details['partner_name_hi'] . '), ';
                                                                                                }
                                                                                                echo $test1;
                                                                                            } else if ($values == 'Other Mailers') {
                                                                                                echo $lang['other_mailer_news'] . ', ';
                                                                                            } else if ($values == 'Facebook') {
                                                                                                echo $lang['facebook'] . ', ';
                                                                                            } else if ($values == 'Twitter') {
                                                                                                echo $lang['twitter'] . ', ';
                                                                                            } else if ($values == 'LinkedIn') {
                                                                                                echo $lang['linkedIn'] . ', ';
                                                                                            } else if ($values == 'Instagram') {
                                                                                                echo $lang['instagram'] . ',';
                                                                                            } else if ($values == 'Inc42') {
                                                                                                echo $lang['inc42'] . ', ';
                                                                                            } else if ($values == 'YourStory') {
                                                                                                echo $lang['yourstory'] . ', ';
                                                                                            } else if ($values == 'BetterIndia') {
                                                                                                echo $lang['the_better_india'] . ', ';
                                                                                            } else if ($values == 'Press') {
                                                                                                echo $lang['press_media'] . ', ';
                                                                                            } else if (trim($values) == 'Referral') {
                                                                                                echo $lang['referral'] . ', ';
                                                                                            } else if ($values == 'Google search') {
                                                                                                echo $lang['google_search'] . ',';
                                                                                            } else {
                                                                                                $aboutvill = $referalArr = explode('(', $values);
                                                                                                if ($referalArr[0] == 'Referral') {
                                                                                                    $referral_only = $lang['referral'] . '';
                                                                                                    $referal_sub = '';
                                                                                                    if ($referalArr[1] != '' && $pitch_org[0]['referral_name_hi'] != '') {
                                                                                                        $referal_sub = '(' . $pitch_org[0]['referral_name_hi'] . '), ';
                                                                                                    }
                                                                                                    echo $referral_only . $referal_sub;
                                                                                                }
                                                                                            }
                                                                                        }
                    //echo $abtVill;
                                                                                        ?><?php
                                                                                        $info_other_mailer = explode(',', $info_other_mailer_om);
                                                                                        foreach ($info_other_mailer as $info_other_mailer_val) {
                                                                                            $om_values = trim($info_other_mailer_val);
                                                                                            if ($om_values == 'ANDE') {
                                                                                                echo $lang['ande'] . ', ';
                                                                                            } else if ($om_values == 'AVPN') {
                                                                                                echo $lang['avpn'] . ', ';
                                                                                            } else if ($om_values == 'Cartier Women’s Initiative') {
                                                                                                echo $lang['cartier_women_initiative'] . ', ';
                                                                                            } else if ($om_values == 'Dhriiti') {
                                                                                                echo $lang['dhriiti'] . ', ';
                                                                                            } else if ($om_values == 'NASSCOM') {
                                                                                                echo $lang['nasscom'] . ', ';
                                                                                            } else if ($om_values == 'TiE') {
                                                                                                echo $lang['tie'] . ', ';
                                                                                            } else if ($om_values == 'Others') {
                                                                                                echo $lang['Others'];
                                                                                            }
                                                                                        }
                                                                                        if (in_array('Others', $info_other_mailer)) {
                                                                                            if ($user_lang_code == 'hi') {
                                                                                                echo '(' . $other_org_name . ') ';
                                                                                            } else {
                                                                                                echo '(' . $other_org_name . ')';
                                                                                            }
                                                                                        }
                    //echo '('.$info_other_mailer_om.$other_org_name.')';
                                                                                        ?></td>
                                                                                    </tr>
                                                                                    <?php
                                                                                    if ($row['application_type'] == 2) {
                                                                                        $doc_path = host_url() . 'poweringlivelihoods/';
                                                                                    } else {
                                                                                        $doc_path = host_url() . 'pitchform/';
                                                                                    }
                                                                                    ?>
                                                                                    <tr class="odd">
                                                                                        <td style="border-right:thick solid #fff;" width="30%"><?php
                                                                                        if (isset($lang['upload_doc']) && $lang['upload_doc'] != '') {
                                                                                            echo $lang['upload_doc'];
                                                                                        } else {
                                                                                            echo "Uploaded documents";
                                                                                        }
                                                                                        ?></td>
                                                                                        <td style="width:50%;">
                                                                                            <?php if (isset($pitch_doc) && $pitch_doc[0]['doc1'] != '') { ?>
                                                                                                <a href="<?php echo $doc_path . 'document/' . $pitch_doc[0]['doc1']; ?>"
                                                                                                 target="_blank"><?php echo $pitch_doc[0]['doc1']; ?></a>
                                                                                             <?php } ?>
                                                                                         </td>
                                                                                     </tr>
                                                                                     <tr class="even">
                                                                                        <td></td>
                                                                                        <td width="30%">
                                                                                            <?php if (isset($pitch_doc) && $pitch_doc[0]['doc2'] != '') { ?>
                                                                                                <a href="<?php echo $doc_path . 'document/' . $pitch_doc[0]['doc2']; ?>"
                                                                                                 target="_blank"><?php echo $pitch_doc[0]['doc2']; ?></a>
                                                                                             <?php } ?>
                                                                                         </td>
                                                                                     </tr>
                                                                                     <tr class="odd">
                                                                                        <td></td>
                                                                                        <td width="30%">
                                                                                            <?php if (isset($pitch_doc) && $pitch_doc[0]['doc3'] != '') { ?>
                                                                                                <a href="<?php echo $doc_path . 'document/' . $pitch_doc[0]['doc3']; ?>"
                                                                                                 target="_blank"><?php echo $pitch_doc[0]['doc3']; ?></a>
                                                                                             <?php } ?>
                                                                                         </td>
                                                                                     </tr>

                                                                                 </table>
                                                                             </td>
                                                                         </tr>
                                                                     </tbody>
                                                                 </table>
                                                                 <?php
                                                             endforeach;
                                                             ?>
                                                         </div>





                                                         <div style="display:none;">
                                                            <div align="center" id="approve_sheet" style="width:400px; height:460px;">

                                                                <h3>Please select user who will do the Preliminary Assessment scoring on this deal from the list below</h3>

                                                                <form action="<?php echo site_url('scouting/assignInchargeInView'); ?>" id="assign" method="post">

                                                                    <select id="associate_employee" data-placeholder="Select Employee" multiple class=""
                                                                    style="width:350px;height:330px;" tabindex="1" name="associate_employee[]">
                                                                    <?php
                                                                    foreach ($usersList as $row) {
                                                                        ?>
                                                                        <option value="<?= $row['emp_number']; ?>"><?= $row['emp_name']; ?></option>
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
                                                        <div id="comments_log" style="width:800px; height:400px;">

                                                            <h1 class="text-left reduce_space">Comments Log </h1>
                                                            <?php
                                                            if ($this->session->userdata('independent_shortlist') == 1 && $this->session->userdata('role_id') == 4) {
                                                                ?>
                                                                <form id="comments_form" name="comments_form" enctype="multipart/form-data" action="<?php echo site_url('scouting/saveshortlist_comments'); ?>" method="post">
                                                                    <div class="row" style="padding: 10px 10px">
                                                                        <div><strong>Status</strong><span style="color: red">*</span> :</div>
                                                                        <select name="comments_status"  id="comments_status" class="form-control">
                                                                            <option value="">--Select Status</option>
                                                                            <option value="12">Open</option>
                                                                            <option value="3">Closed</option>
                                                                            <option value="2">On Hold</option>
                                                                            <option value="25">Shortlisted</option>
                                                                            <option value="26">Selected</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="row" style="padding: 10px 10px">
                                                                        <div><strong>Comments</strong><span style="color: red">*</span> :</div>
                                                                        <textarea cols="35" rows="5" name="shortlist_comment" id="shortlist_comment" class="form-control"></textarea>
                                                                    </div>
                                                                    <div class="row" style="padding: 10px 10px">
                                                                        <span><a id="save_action" href="javascript:void(0)" onclick="saveComments();"
                                                                           class="button">Save</a></span>
                                                                       </div>
                                                                       <input type="hidden" name="application_type" id="application_type" value="1" />
                                                                       <input type="hidden" name="application_id" id="application_id" value="<?= $application_id; ?>" />
                                                                   </form>
                                                               <?php } ?>
                                                               <table style="width:100%" id="table1" class="gtable sortable">
                                                                <thead style="border-bottom: 2px solid #ccc;">
                                                                    <tr>
                                                                        <th style="padding:5px;text-align: left;">Date</th>
                                                                        <th style="padding:5px;text-align: left;">Added By</th>
                                                                        <th style="padding:5px;text-align: left;">Status</th>
                                                                        <th style="padding:5px;text-align: left;">Comments</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    if (count($shortlist_comment) > 0) {
                                                                        foreach ($shortlist_comment as $commentlist) {

                                                                            $emp_name = $this->Minnovation->getUsername($commentlist['created_by']);
                                                                            if ($commentlist['application_status'] == 12) {
                                                                                $app_status = 'Open';
                                                                            } else if ($commentlist['application_status'] == 3) {
                                                                                $app_status = 'Closed';
                                                                            } else if ($commentlist['application_status'] == 2) {
                                                                                $app_status = 'On Hold';
                                                                            } else if ($commentlist['application_status'] == 25) {
                                                                                $app_status = 'Shortlisted';
                                                                            } else if ($commentlist['application_status'] == 26) {
                                                                                $app_status = 'Selected';
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <td><?= date('d-m-Y', strtotime($commentlist['created_date'])); ?></td>
                                                                                <td><?= $emp_name[0]['emp_firstname']; ?></td>
                                                                                <td><?= $app_status; ?></td>
                                                                                <td><?= $commentlist['comments']; ?></td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <tr style="text-align: center;">
                                                                            <td colspan="4">No Record Found</td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                            </table>

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
                                                                    $reg_date = date('d-m-Y', strtotime($log_details[0]['created_date']));
                                                                    $reg_time = date('h:i A', strtotime($log_details[0]['created_date']));
                                                                    ?>

                                                                    <tr>
                                                                        <td style="padding:5px;"><?php echo $reg_date; ?></td>
                                                                        <td style="padding:5px;"><?php echo $reg_time; ?></td>
                                                                        <td style="padding:5px;"><?php echo $log_details[0]['assigned_incharge']; ?></td>
                                                                        <td style="padding:5px;">-</td>
                                                                        <td style="padding:5px;">Application</td>
                                                                        <td style="padding:5px;">Registered</td>
                                                                    </tr>

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

                                                                .inv-detail-status {
                                                                    float: left;
                                                                    width: 30%;
                                                                }
                                                            </style>



                                                            <script type="text/javascript">
                                                                var inv_ID = "<?php echo $innovation['id']; ?>";
                                                                $('#innovation_id').val(inv_ID);

                                                                $('#assign_incharge').on('click', function () {
                                                                    Populate();
                                                                });

                                                                $('#comments_form').validate({
                                                                    rules: {
                                                                        comments_status: "required",
                                                                        shortlist_comment: "required"
                                                                    },
                                                                    messages: {
                                                                        comments_status: "Select status",
                                                                        shortlist_comment: "Enter Comment"
                                                                    }
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

                                                                function saveComments() {
                                                                    $('#comments_form').submit();
                                                                }

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
                                                                    } else if (program == 3) {
                                                                        url = "<?php echo host_url() . 'pitchform/mis_download.php?file_name='; ?>";
                                                                    } else if (program == 4) {
                                                                        url = "<?php echo host_url() . 'poweringlivelihoods/mis_download.php?file_name='; ?>";
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

                                                            <style type="text/css">
                                                                .text-left {
                                                                    text-align: left !important;
                                                                }
                                                            </style>