<!-- Rejection mail triggering on close action -->
<?php
#error_reporting(-1);
$innovationID = $innovation['id'];
$formAction = site_url('common/mail/form/' . $innovationID);
require_once ("./language/lang_en.php");

#echo'<pre>';print_r($pitch_org);die;
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
                             <?php
                             if (php72_cmp($this->session->userdata('independent_shortlist')) != 1 || php72_cmp($this->session->userdata('role_id')) != 4) {
                                ?>
                                <li><strong>Status</strong> : <?= $status[$innovationDetails[0]['status']]; ?></li>
                            <?php } ?>
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
                            if (php72_cmp($this->session->userdata('independent_shortlist')) != 1 || php72_cmp($this->session->userdata('role_id')) != 4) {
                                ?>
                                <ul class="inv-detail-status">
                                    <li><strong>Reason</strong> : <?php echo $innovationDetails[0]['reasons_title']; ?></li>
                                    <li title='<?php echo $cmnts; ?>'><strong>Comments</strong> : <?php echo mb_strimwidth($cmnts, 0, 75, '...'); ?>
                                </li>
                                <li><strong>Closed By</strong> : <?php echo $empName['emp_name']; ?></li>
                            </ul>
                            <?php
                        }
                    }
                    ?>


                    <span><a id="logStatusModal" class="fancybox button" href="#status_log" style="float:right; cursor:pointer;">Application Status Log</a></span>
                    <?php if (isset($pitch_user[0]['lang_code']) && $pitch_user[0]['lang_code'] == 'hi') { ?>
                        <span><a class="button" href="<?php echo base_url(); ?>index.php/scouting/innovation_details/<?php echo $this->uri->segment(3); ?>/hi" target="_blank" style="float:right; cursor:pointer;">View Original Hindi Application</a></span>
                    <?php } ?>
                    <?php
                    foreach ($pitch_user as $row):

                        $this->db->select("city_name");
                        $this->db->where('id', $row['city']);
                        $q = $this->db->get('partner_city');
                        $city = $q->result_array();
        //$city_name = $city[0]['city_name'];
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
                                        <td colspan="2" style="background-color:#FFF"><b>Basic Information</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="background-color:#FFF"></td>
                                    </tr>
                                    <tr class="odd">
                                        <td style="width:40%;border-right:thick solid #fff;">Innovation Id </td>
                                        <td><?= $innovationDetails[0]['copy_id'] . '_' . $innovationDetails[0]['partner_id'] . '_' . $innovationDetails[0]['partner_count']; ?>
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td>Partner</td>
                                    <td><?= ucfirst($innovationDetails[0]['branch_name']) ?></td>
                                </tr>
                                <tr class="odd">
                                    <td>Name of the Organisation</td>
                                    <td><?= $row['org_name']; ?></td>
                                </tr>
                                <tr class="even">
                                    <td style="border-right:thick solid #fff;">Name of the Applicant</td>
                                    <td><?= $row['app_name']; ?></td>
                                </tr>
                                <tr class="even">
                                    <td style="border-right:thick solid #fff;">Designation of the Applicant</td>
                                    <td><?php if (isset($row['designation']) && $row['designation'] != '') {
                                        echo $row['designation'];
                                    } ?></td>
                                </tr>
                                <tr class="even">
                                    <td style="border-right:thick solid #fff;">Gender of Applicant</td>
                                    <td><?= ucfirst($row['gender']); ?></td>
                                </tr>
                                <?php if (php72_cmp($row['application_type']) == 2) { ?>
                                    <tr class="odd">
                                        <td>What is your enterprise registered as</td>
                                        <td><?= $row['enterprise_registered_under']; ?></td>
                                    </tr>
                                <?php } ?>
                    <!--
    <tr class="even">
    <td style="border-right:thick solid #fff;">GST Number</td>
    <td><?php echo isset($row['gst_number']) && $row['gst_number'] != '' ? $row['gst_number'] : '-'; ?></td>
</tr> -->

<tr class="even">
    <td>Email Address</td>
    <td><?= $row['email']; ?></td>
</tr>
<tr class="odd">
    <td style="border-right:thick solid #fff;">Mobile Number</td>
    <td><?= $row['mobileno']; ?></td>
</tr>
<tr class="even">
    <td>Alternate Phone Number</td>
    <td><?= $alt = (($row['altmobileno'] !== ' ' && $row['altmobileno'] !== '0') ? $row['altmobileno'] : '') ?>
</td>
</tr>

<?php if (php72_cmp($row['application_type']) == 2) { ?>
    <tr class="even">
        <td>Components</td>
        <?php
        $get_components = unserialize($row['components']);
        ?>
        <td><?php echo php72_implode(', ', $get_components); ?></td>
    </tr>
    <tr class="odd">
        <?php
        $get_beneficiary = unserialize($row['beneficiary']);
        ?>
        <td>Primary beneficiaries</td>
        <td><?php echo php72_implode(', ', $get_beneficiary); ?></td>
    </tr>
<?php } ?>
<tr class="even">
    <td style="border-right:thick solid #fff;">Date Created</td>
    <td><?= date('Y-m-d', strtotime($row['reg_date'])) ?></td>
</tr>

<tr class="odd">
    <td style="border-right:thick solid #fff;">Source</td>
    <td>
        <?php // $innovationDetails[0]['source_type']; //= $innovationDetails[0]['source_name']; ?>
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
    <td colspan="2"><a href="#bottom" id="ex_info" style="color:#719e41;">** Additional Information</a>
        <table id="add_info" class="gtable" width="100%">
            <?php if (php72_count($pitch_member) > 0) { ?>
                <tr>
                    <td colspan="2" style="background-color:#FFF"></td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color:#FFF"><b>Application Information</b></td>
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
                                            <td colspan="2"
                                            style="background-color: #A9CF55;text-align: center;">Team
                                            Member <?= $i ?></td>
                                        </tr>
                                        <tr class="even">
                                            <td style="border-right:thin solid #fff;">Name</td>
                                            <td><?= $team['name']; ?></td>
                                        </tr>
                                        <tr class="odd">
                                            <td style="border-right:thin solid #fff;">Designation</td>
                                            <td><?= $team['cur_title']; ?></td>
                                        </tr>
                                        <tr class="even">
                                            <td style="border-right:thin solid #fff;">Email ID</td>
                                            <td><?= $team['email']; ?></td>
                                        </tr>
                                        <tr class="odd">
                                            <td style="border-right:thin solid #fff;">Gender</td>
                                            <td><?= ucfirst($team['gender']); ?></td>
                                        </tr>
                                        <tr class="odd">
                                            <td style="border-right:thin solid #fff;">Age</td>
                                            <td><?= ucfirst($team['age']); ?></td>
                                        </tr>
                                        <tr class="even">
                                            <td style="border-right:thin solid #fff;">Highest Educational Qualification</td>
                                            <td><?= $team['education_qualify']; ?></td>
                                        </tr>
                                        <tr class="even">
                                            <td style="border-right:thin solid #fff;">Mobile No</td>
                                            <td><?= $team['phone']; ?></td>
                                        </tr>

                                        <tr class="odd">
                                            <td style="border-rigOthersht:thin solid #fff;">LinkedIn</td>
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

        <?php //echo'<pre>';print_r($pitch_org); die;    ?>
        <tr></tr>
        <tr>
            <td colspan="2" style="background-color:#FFF"></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color:#FFF"><b>More information about incubatee</b></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color:#FFF"></td>
        </tr>
        <tr class="odd">
            <td width="30%" style="border-right:thick solid #fff;">Management team composition: No. of Male</td>
            <td width="60%"><?php echo $pitch_info[0]['male_numb']; ?></td>
        </tr>
        <tr class="odd">
            <td width="30%" style="border-right:thick solid #fff;">Management team composition: No. of Female</td>
            <td width="60%"><?php echo $pitch_info[0]['female_numb']; ?></td>
        </tr>
        <tr class="odd">
            <td width="30%" style="border-right:thick solid #fff;">Management team composition: No. of Transgender</td>
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
            <td width="60%"><?php echo $pitch_org[0]['website']; ?></td>
        </tr>
        <?php
                                #echo'<pre>';print_r($pitch_org);die;
        $get_state_city = Mincharge::get_state_city($pitch_info[0]['state_id'], $pitch_info[0]['city_id']);

        $get_sectorName = unserialize($pitch_org[0]['sector']);
        $sectorName = $get_sectorName[0];

        $subsectorName = Mincharge::getSubsectorName($pitch_org[0]['sub_sector']);
        ?>
        <?php
        if (php72_cmp($row['application_type']) != 2) {
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
                ?> </td>
                <td width="60%"><?php echo $ent_type; ?></td>
            </tr>
        <?php } ?>
        <tr class="odd">
            <td width="30%" style="border-right:thick solid #fff;">Is your company registered under the MCA?</td>
            <td width="60%"><?php echo ucfirst($pitch_info[0]['company_register']); ?></td>
        </tr>
        <?php if ($pitch_info[0]['company_register'] == 'yes') { ?>
            <tr class="odd">
                <td width="30%" style="border-right:thick solid #fff;">CIN Number</td>
                <td width="60%"><?php echo ucfirst($pitch_info[0]['cin_number']); ?></td>
            </tr>
        <?php } ?>
        <tr class="even">
            <td width="30%" style="border-right:thick solid #fff;">Year of incorporation</td>
            <td width="60%"><?php echo @$pitch_org[0]['incorporation_year']; ?></td>
        </tr>

        <tr class="odd">
            <td width="30%" style="border-right:thick solid #fff;">DIPP Registration</td>
            <td width="60%"><?php echo ucfirst($pitch_info[0]['dipp_register']); ?></td>
        </tr>
        <?php if ($pitch_info[0]['dipp_register'] == 'yes') { ?>
            <tr class="odd">
                <td width="30%" style="border-right:thick solid #fff;">DIPP Number</td>
                <td width="60%"><?php echo ucfirst($pitch_info[0]['dipp_number']); ?></td>
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
            <td width="60%"><?php echo $get_state_city[0]['state_name']; ?></td>
        </tr>
        <tr class="odd">
            <td width="30%" style="border-right:thick solid #fff;"><?php
            if (isset($lang['headquarter_city']) && $lang['headquarter_city'] != '') {
                echo $lang['headquarter_city'];
            } else {
                echo "Headquarter City";
            }
            ?></td>
            <td width="60%"><?php echo $get_state_city[1]['city_name']; ?></td>
        </tr>
        <tr class="even">
            <td style="border-right:thick solid #fff;" width="30%">Stage of Operation</td>
            <td width="60%"><?php
            if ($pitch_org[0]['operation_stage'] == 'Idea') {
                echo 'Idea stage';
            } else if ($pitch_org[0]['operation_stage'] == 'Commercial Piloting / Initial Paying Customers') {
                echo 'Commercial Pilot / Launched in market';
            } else if ($pitch_org[0]['operation_stage'] == 'Scaling up / Rapid sales growth') {
                echo 'Growth stage / generating revenue';
            } else {
                echo $pitch_org[0]['operation_stage'];
            }
            ?></td>
        </tr>

        <tr class="odd">
            <td width="30%" style="border-right:thick solid #fff;">Sector</td>
            <td width="60%"><?php
            if ($sectorName == 'Health') {
                echo 'Healthcare';
            } else if ($sectorName == 'Livelihoods & Job creation') {
                echo 'Livelihoods & Skill Development';
            } else {
                echo $sectorName;
            }
            ?></td>
        </tr>

        <?php if (php72_cmp($row['application_type']) != 2) { ?>
            <tr class="even">
                <td width="30%" style="border-right:thick solid #fff;">Sub Sector</td>
                <td width="60%"><?php
                $str = str_replace('/', '', strtolower(preg_replace('/[ ,-\-&\-\(\)]+/', '_', $subsectorName[0]['sector'])));
                                            //echo $lang[$str];
                if ($subsectorName[0]['sector'] == 'Others') {
                    $sub_sector_spec = ': - ' . $pitch_org[0]['subsector_other_spec'];
                }
                echo $subsectorName[0]['sector'] . $sub_sector_spec;
                ?></td>
            </tr>
            <?php if (@$pitch_org[0]['other_subsector'] != '') { ?>
                <tr class="even">
                    <td width="30%" style="border-right:thick solid #fff;">Other Sub Sector</td>
                    <td width="60%"><?php echo @$pitch_org[0]['other_subsector']; ?></td>
                </tr>
            <?php } ?>

                                    <?php /* if ($subsectorName[0]['sector'] == 'Others') { ?>
                                      <tr class="even">
                                      <td width="30%" style="border-right:thick solid #fff;">Specify</td>
                                      <td width="60%"><?php echo @$pitch_org[0]['subsector_other_spec']; ?></td>
                                      </tr>
                                  <?php } */ ?>


                                  <?php
                                  if ($subsectorName[0]['sector'] == 'Irrigation / Water management' && ($pitch_org[0]['operation_stage'] == 'Commercial Piloting / Initial Paying Customers' || $pitch_org[0]['operation_stage'] == 'Scaling up / Rapid sales growth')) {
                                    ?>
                                    <tr class="odd">
                                        <td width="30%" style="border-right:thick solid #fff;">If Yes, how many liters of water have you saved in the last one year? </td>
                                        <td width="60%"><?php echo $pitch_org[0]['saved_water']; ?></td>
                                    </tr>
                                <?php } ?>

                                <?php if (@$pitch_org[0]['water_consumption'] == 'Yes') { ?>

                                    <?php
                                }
                            }
                            ?>

                            <tr class="odd">
                                <td width="30%" style="border-right:thick solid #fff;">Revenue of company: 2019-20</td>
                                <?php $fy_18 = isset($pitch_org[0]['fy_19_20']) && $pitch_org[0]['fy_19_20'] != '' ? $pitch_org[0]['fy_19_20'] : '0'; ?>
                                <td width="60%"><?php echo $fy_18; ?></td>
                            </tr>
                            <tr class="even">
                                <td width="30%" style="border-right:thick solid #fff;">Revenue of company: 2018-19</td>
                                <?php $fy_17 = isset($pitch_org[0]['fy_18_19']) && $pitch_org[0]['fy_18_19'] != '' ? $pitch_org[0]['fy_18_19'] : '0'; ?>
                                <td width="60%"><?php echo $fy_17; ?></td>
                            </tr>
                            <tr class="odd">
                                <td width="30%" style="border-right:thick solid #fff;">Revenue of company: 2017-18 </td>
                                <?php $fy_16 = isset($pitch_org[0]['fy_17_18']) && $pitch_org[0]['fy_17_18'] != '' ? $pitch_org[0]['fy_17_18'] : '0'; ?>
                                <td width="60%"><?php echo $fy_16; ?></td>
                            </tr>


                            <?php if ($sectorName == 'Agri-business' || $sectorName == 'Energy & CleanTech' || $sectorName == 'Climate Action' || $sectorName == 'Healthcare' || $sectorName == 'ShelterTech & Housing') { ?>

                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;">What would best describe your solution? (Hardware-based/ Software-based/ Both)</td>
                                    <td width="60%"><?php echo $pitch_org[0]['describe_solution']; ?></td>
                                </tr>
                            <?php } ?>



                            <?php if (php72_cmp($row['application_type']) == 2) { ?>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;">Describe your organization's inclusion strategies be it in the case of gender, marginalised communities, or other deprived sections of the society. </td>
                                    <td width="60%"><?php echo nl2br(@$pitch_org[0]['inclusion_strategy']); ?></td>
                                </tr>
                                <tr class="even">
                                    <td width="30%" style="border-right:thick solid #fff; width:50%;">If you have tested your products with prospective users or have made sales, please mention details. </td>
                                    <td width="60%"><?php echo nl2br(@$pitch_org[0]['product_test_details']); ?></td>
                                </tr>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;">Over the last six months, how many units of your product have you sold/installed? </td>
                                    <td width="60%"><?php echo nl2br(@$pitch_org[0]['product_units']); ?></td>
                                </tr>
                            <?php } ?>


                            <tr class="odd">
                                <td width="30%" style="border-right:thick solid #fff;">Have you filed for any patent?</td>
                                <td width="60%">
                                    <?php
                                    if ($pitch_org[0]['patents'] == '1') {
                                        echo'Yes';
                                    } else {
                                        echo'No';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php if ($pitch_org[0]['patents'] == '1') { ?>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;">If Yes, what is the patent for:</td>
                                    <td width="60%"><?php echo $pitch_org[0]['patent_desc']; ?> </td>
                                </tr>
                            <?php } ?>


                            <tr class="odd">
                                <td width="30%" style="border-right:thick solid #fff;">Have you raised funds in the past?</td>
                                <td width="60%">
                                    <?php
                                    if ($pitch_org[0]['past_fund'] == 'yes') {
                                        echo'Yes';
                                    } else {
                                        echo'No';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php if ($pitch_org[0]['past_fund'] == 'yes') { ?>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;">Total Grant Amount </td>
                                    <td width="60%"><?php echo $pitch_org[0]['grant_amount']; ?> </td>
                                </tr>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;">Total Equity Amount </td>
                                    <td width="60%"><?php echo $pitch_org[0]['equity_amount']; ?> </td>
                                </tr>
                            <?php } ?>


                            <tr class="odd">
                                <td width="30%" style="border-right:thick solid #fff;">Have you won a prize, recognition or award for your solution? </td>
                                <td width="60%">
                                    <?php
                                    if ($pitch_org[0]['prize_recognition'] == 'yes') {
                                        echo'Yes';
                                    } else {
                                        echo'No';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php if ($pitch_org[0]['prize_recognition'] == 'yes') { ?>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;">If yes, Specify the details</td>
                                    <td width="60%"><?php echo $pitch_org[0]['awards']; ?> </td>
                                </tr>
                            <?php } ?>


                            <?php if (php72_cmp($row['application_type']) == 2) { ?>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;">Revenue of company: 2015-16</td>
                                    <?php $fy_15 = isset($pitch_org[0]['fy_15_16']) && $pitch_org[0]['fy_15_16'] != '' ? $pitch_org[0]['fy_15_16'] : '0'; ?>
                                    <td width="60%"><?php echo $fy_15; ?></td>
                                </tr>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;">Revenue of company: 2014-15</td>
                                    <?php $fy_14 = isset($pitch_org[0]['fy_14_15']) && $pitch_org[0]['fy_14_15'] != '' ? $pitch_org[0]['fy_14_15'] : '0'; ?>
                                    <td width="60%"><?php echo $fy_14; ?></td>
                                </tr>
                            <?php } ?>
                                <?php /* if ($row['application_type'] != 2) {
                                  if (@$pitch_org[0]['patents'] == '1') {
                                  $patents = 'Yes';
                                  } else {
                                  $patents = 'No';
                                  }
                                  ?>
                                  <tr class="even">
                                  <td width="30%" style="border-right:thick solid #fff;">Do you have any patents?</td>
                                  <td width="60%"><?php echo $patents; ?></td>
                                  </tr>
                              <?php } */ ?>
                                <!--
    <tr class="even">
    <td width="30%" style="border-right:thick solid #fff; width:50%;">When did you last raise funding/ win a grant? Please specify month & year. Also specify the source of funding. </td>
    <td width="60%"><?php echo nl2br(@$pitch_org[0]['last_fund_desc']); ?></td>
</tr> -->
<?php if (php72_cmp($row['application_type']) != 2) { ?>
                                                                                        <!--  <tr class="odd">
                                                                                        <td width="30%" style="border-right:thick solid #fff;">Have you won a prize, recognition, award for your incubatee? If yes, please mention it.</td>
                                                                                        <td width="60%"><?php echo nl2br(@$pitch_org[0]['awards']); ?></td>
                                                                                    </tr> -->
                                                                                    <tr class="odd">
                                                                                        <td width="30%" style="border-right:thick solid #fff;">Has your company been incubated / accelerated by any institution?</td>
                                                                                        <td width="60%"><?php echo ucfirst(@$pitch_org[0]['accelerate_type']); ?></td>
                                                                                    </tr>
                                                                                    <?php if (@$pitch_org[0]['accelerate_type'] == 'Yes') { ?>
                                                                                        <tr class="odd">
                                                                                            <td width="30%" style="border-right:thick solid #fff;">If yes, specify the name of the  incubator / accelerator and the year of participation
                                                                                            </td>
                                                                                            <td width="60%"><?php echo nl2br(@$pitch_org[0]['incubated_accelerated']); ?></td>
                                                                                        </tr>
                                                                                    <?php } ?>

                                                                                    <tr class="even">
                                                                                        <td width="30%" style="border-right:thick solid #fff; width:50%;">Briefly explain the problem that you are addressing. </td>
                                                                                        <td width="60%"><?php echo nl2br(@$pitch_org[0]['addr_problem']); ?></td>
                                                                                    </tr>
                                                                                    <tr class="odd">
                                                                                        <td width="30%" style="border-right:thick solid #fff;">Describe how your solution addresses the problem.</td>
                                                                                        <td width="60%"><?php echo nl2br(@$pitch_org[0]['quest_1']); ?></td>
                                                                                    </tr>



                                                                                    <tr class="even">
                                                                                        <td width="30%" style="border-right:thick solid #fff;">How is your solution creating social impact? </td>
                                                                                        <td width="60%"><?php echo nl2br(@$pitch_org[0]['ent_impact']); ?></td>
                                                                                    </tr>
                                                                                <?php } ?>


                                                                                <tr class="odd">
                                                                                    <td width="30%" style="border-right:thick solid #fff;">Does your solution directly impact women & girls? </td>
                                                                                    <td width="60%">
                                                                                        <?php
                                                                                        if ($pitch_org[0]['direct_impact_status'] == 'Yes') {
                                                                                            echo'Yes';
                                                                                        } else {
                                                                                            echo'No';
                                                                                        }
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php if ($pitch_org[0]['direct_impact_status'] == 'Yes') { ?>
                                                                                    <tr class="odd">
                                                                                        <td width="30%" style="border-right:thick solid #fff;">If yes, how</td>
                                                                                        <td width="60%"><?php echo $pitch_org[0]['direct_impact_sol']; ?> </td>
                                                                                    </tr>
                                                                                <?php } ?>



                                                                                <?php
                                                                                $aboutvill = explode(',', $pitch_org[0]['info_about_program']);
                                                                                $aboutvill_om = explode(',', $pitch_org[0]['info_other_mailer']);

                                                                                foreach ($aboutvill as $key => $value) {
                                                                                    if ($aboutvill[$key] == 'Other Mailers' && $pitch_org[0]['partner_name'] != '') {
                                                                                        $aboutvill[$key] = 'Other Mailers(' . trim($pitch_org[0]['partner_name']) . ')';
                                                                                    } else if ($aboutvill[$key] == 'Past Incubatee' && $pitch_org[0]['inc_name'] != '') {
                                                                                        $aboutvill[$key] = 'Past Incubatee(' . trim($pitch_org[0]['inc_name']) . ')';
                                                                                    } else if ($aboutvill[$key] == 'Referral' && $pitch_org[0]['referral_name'] != '') {
                                                                                        $aboutvill[$key] = 'Referral(' . trim($pitch_org[0]['referral_name']) . ')';
                                                                                    }
                                                                                }
                                                                                $abtVill = implode(', ', $aboutvill);
                                                                                $implode_info = '';
                                                                                $other_org_name = '';
                                                                                if ($pitch_org[0]['info_other_mailer'] != '') {
                                                                                    $info_other_mailer_om = trim($pitch_org[0]['info_other_mailer']);
                                                                                    $explode_info = explode(',', $info_other_mailer_om);
                                                                                    $implode_info = ', ' . implode(', ', $explode_info);
                                                                                }
                                                                                if ($pitch_org[0]['other_org_name'] != '') {
                                                                                    $other_org_name = '(' . trim($pitch_org[0]['other_org_name']) . ')';
                                                                                }
                                                                                ?>


                                                                                <tr class="even">
                                                                                    <td style="border-right:thick solid #fff;" width="30%">How did you hear about us?</td>
                                                                                    <td width="60%"><?php echo $abtVill; ?><?php echo $implode_info . '' . $other_org_name; ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                if (php72_cmp($row['application_type']) == 2) {
                                                                                    $doc_path = host_url() . 'poweringlivelihoods/';
                                                                                } else {
                                                                                    $doc_path = host_url() . 'pitchform/';
                                                                                }
                                                                                ?>
                                                                                <tr class="odd">
                                                                                    <td style="border-right:thick solid #fff;" width="30%">Uploaded documents</td>
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

                                                        <form id="comments_form" name="comments_form" enctype="multipart/form-data" action="<?php echo site_url('scouting/saveshortlist_comments'); ?>" method="post">
                                                            <div class="row" style="padding: 10px 10px">
                                                                <div style="width: 15%;"><strong style="width: 100px">Status <span style="color: red">*</span></strong></div>
                                                                <div style="width: 85%;float: right; margin-top: -20px">
                                                                    <select name="comments_status"  id="comments_status" class="form-control">
                                                                        <option value="">--Select Status--</option>
                                                                        <option value="12" selected>Open</option>
                                                                        <option value="3">Closed</option>
                                                                        <option value="2">On Hold</option>
                                                                        <option value="25">Shortlisted</option>
                                                                        <option value="26">Selected</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row" style="padding: 10px 10px">
                                                                <div style="width: 15%;">
                                                                    <strong >Comments </strong><span style="color: red">*</span></div>
                                                                    <div style="width: 85%;float: right; margin-top: -20px">
                                                                        <textarea cols="35" rows="5" name="shortlist_comment" id="shortlist_comment" class="form-control"></textarea>
                                                                        <span style="float: right; margin: 62px 0px 0px"><a id="save_action" href="javascript:void(0)" onclick="saveComments();"
                                                                            class="button">Save</a></span>
                                                                        </div>

                                                                    </div>
                                                                    <div class="row" style="padding: 10px 10px; width: 50%;">

                                                                    </div>
                                                                    <input type="hidden" name="application_type" id="application_type" value="1" />
                                                                    <input type="hidden" name="application_id" id="application_id" value="<?= $application_id; ?>" />
                                                                </form>
                                                                <table style="width:100%" id="table1" class="gtable sortable">
                                                                    <thead style="border-bottom: 2px solid #ccc;">
                                                                        <tr>
                                                                            <th width="10%">Date</th>
                                                                            <th width="20%" style="text-align:left;">Added By</th>
                                                                            <th width="10%">Status</th>
                                                                            <th width="60%">Comments</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        if (php72_count($shortlist_comment) > 0) {
                                                                            foreach ($shortlist_comment as $commentlist) {

                                                                                $emp_name = $this->Minnovation->getUsername($commentlist['created_by']);
                                                                                if (php72_cmp($commentlist['application_status']) == 12) {
                                                                                    $app_status = 'Open';
                                                                                } else if (php72_cmp($commentlist['application_status']) == 3) {
                                                                                    $app_status = 'Closed';
                                                                                } else if (php72_cmp($commentlist['application_status']) == 2) {
                                                                                    $app_status = 'On Hold';
                                                                                } else if (php72_cmp($commentlist['application_status']) == 25) {
                                                                                    $app_status = 'Shortlisted';
                                                                                } else if (php72_cmp($commentlist['application_status']) == 26) {
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