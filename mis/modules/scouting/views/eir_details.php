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
        //document.body.innerHTML = oldPage;
        setTimeout("closePrintView()", 2000);


    }

    function closePrintView() {
        document.location.href = "<?php echo site_url('scouting/innovation_details/' . $this->uri->segment('3')); ?>";
    }
</script>

<?php
$isEdit = false;
$isAssignCycle = false;

if ($innovationDetails[0]['created_by'] == $this->session->userdata('emp_number')) {
    $isEdit = true;
}

if (in_array($this->session->userdata('user_type'), array('admin', 'ceo', 'cio')) || $innovation['isAssociate'] || $isEdit == true) {

    $isEdit = true;
    $isAssignCycle = true;
    ?>
    <a href="<?= site_url('scouting/eir_app_edit/' . $innovationDetails[0]['id'] . '/' . $eir_user[0]['id']) ?>" id="edit_form"
       style="float:right" class="button">Edit</a>
       <?php
   }
   ?>

<a href="javascript:printDiv('print_table')" id="print_form" style="float:right" class="button">Print</a>
<?php if ($this->session->userdata('user_type') == 'employee') {
    ?>
    <a href="<?= site_url('scouting/innovation_pool/all') ?>" class="button" style="float:right">Back</a><?php } ?>
<div id="print_table">
    <h1><?= $innovationDetails[0]['name_of_enterprise'] ?></h1>
    <ul>
        <li><strong>Stage</strong> : <?php
            if ($innovationDetails[0]['stage'] == '2' && $isAssignCycle) {
                ?>
                <a href="<?= site_url('scouting/cycle/' . $row['id']) ?>"
                   class="fancybox button"><?= $stage[$innovationDetails[0]['stage']] ?></a>
                   <?php
               } else {
                   echo $stage[$innovationDetails[0]['stage']];
               }
               ?></li>
        <li><strong>Status</strong> : <?= $status[$innovationDetails[0]['status']] ?></li>

    </ul>

    <?php
    $this->load->model('eirmodel');
    foreach ($eir_user as $row):
        ?>
        <h2><?= $row['name_of_organisation'] ?></h2>
        <div id="user-grid" class="grid-view">
            <table class="gtable " width="80%" class="items" bgcolor="#F5F5F5" cellspacing="5" cellpadding="5" border="1px">
                <thead>
                    <tr>
                        <th colspan="2"><?= $row['name_of_organisation'] ?></th>
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
                        <td><?= $row['innovation_no'] ?></td>
                    </tr>
                    <tr class="even">
                        <td>Name of the Organisation</td>
                        <td><?= $row['name_of_organisation'] ?></td>
                    </tr>
                    <tr class="odd">
                        <td style="border-right:thick solid #fff;">Name of the Applicant</td>
                        <td><?= $row['name_of_applicant'] ?></td>
                    </tr>
                    <tr class="even">
                        <td>Email Address</td>
                        <td><?= $row['email_id'] ?></td>
                    </tr>
                    <tr class="odd">
                        <td style="border-right:thick solid #fff;">Mobile Number</td>
                        <td><?= $row['mobile_no'] ?></td>
                    </tr>
                    <tr class="even">
                        <td>Alternate Phone Number</td>
                        <td><?= $row['alt_phone_no'] ?></td>
                    </tr>
                    <tr class="odd">
                        <td>Address</td>
                        <td><?= $row['address'] ?></td>
                    </tr>
                    <tr class="even">
                        <td style="border-right:thick solid #fff;">State</td>
                        <td><?php echo eirmodel::get_city_state($row['city'], 'state'); ?></td>
                    </tr>
                    <tr class="odd">
                        <td>City</td>
                        <td><?php echo eirmodel::get_city_state($row['city'], 'city'); ?></td>
                    </tr>
                    <tr class="even">
                        <td style="border-right:thick solid #fff;">Date Created</td>
                        <td><?= $row['date_created'] ?></td>
                    </tr>
                    <tr class="odd">
                        <td>Date Submitted</td>
                        <td><?= $row['date_submitted'] ?></td>
                    </tr>

                    <tr class="even">
                        <td style="border-right:thick solid #fff;">Source</td>
                        <td><?= $innovationDetails[0]['source_type'] ?> - <?= $innovationDetails[0]['source_name'] ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><a href="#bottom" id="ex_info" style="color:#719e41;">** Additional Information</a>
                            <table id="add_info" class="gtable " width="100%">
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"><b>Application Information</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"></td>
                                </tr>
                                <tr class="odd">
                                    <td colspan="2">
                                        <table width="100%" cellspacing="2" cellpadding="2">
                                            <tr>
                                                <?php
                                                $i = 0;
                                                foreach ($eir_team as $team):
                                                    $i = $i + 1;
                                                    ?>
                                                    <td>
                                                        <table style="font: 12px/15px Arial,sans-serif;background-color:none"
                                                               cellspacing="2" cellpadding="2" border="1px;">
                                                            <tr>
                                                                <td colspan="2"
                                                                    style="background-color: #A9CF55;text-align: center;">Team
                                                                    Member <?= $i ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-right:thin solid #fff;">Name</td>
                                                                <td><?= $team['name'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-right:thin solid #fff;">Current Organisation
                                                                </td>
                                                                <td><?= $team['current_organisation'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-right:thin solid #fff;">Current title</td>
                                                                <td><?= $team['current_title'] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-right:thin solid #fff;">Email id</td>
                                                                <td><?= $team['email_id'] ?></td>
                                                            </tr>
                                                            <tr class="odd">
                                                                <td style="border-right:thin solid #fff;">Mobile No</td>
                                                                <td><?= $team['mobile_no'] ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                <?php endforeach; ?>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr></tr>
                                <tr></tr>
                                <tr class="even">
                                    <td width="30%">Briefly describe your key competencies and skills that will enable you
                                        to set up an
                                        incubatee (250 words):
                                    </td>
                                    <td width="60%"><?= $eir_detail[0]['skills'] ?></td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="background-color:#FFF"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"><b>Information about incubatee</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"></td>
                                </tr>
                                <tr class="even">
                                    <td width="30%">Briefly describe your idea, product or service (250 words)</td>
                                    <td width="60%"><?= $eir_detail[0]['describtion_of_idea'] ?></td>
                                </tr>
                                <tr class="odd">
                                    <td width="30%" style="border-right:thick solid #fff;">Describe the innovative element
                                        in your incubatee (250 words)</td>
                                    <td width="60%"><?= $eir_detail[0]['innovative_element'] ?></td>
                                </tr>
                                <tr class="even">
                                    <td width="30%">What need does your idea address? What is the social benefit created by
                                        your idea
                                        (250 words)</td>
                                    <td width="60%"><?= $eir_detail[0]['social_benefit'] ?></td>
                                </tr>
                                <tr class="odd">
                                    <td style="border-right:thick solid #fff;" width="30%">Have you undertaken any pilots
                                        for your idea? If yes, please provide some detail on
                                        the pilot and the key insights you gathered form the pilot (250 words)</td>
                                    <td width="60%"><?= $eir_detail[0]['pilots_of_idea'] ?></td>
                                </tr>
                                <tr class="even">
                                    <td width="30%">What are your expectations from the EIR program? What specific value
                                        addition
                                        are you looking for? (250 words)</td>
                                    <td width="60%"><?= $eir_detail[0]['expectation_from_EIR'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"><b>Additional Information</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"></td>
                                </tr>
                                <tr class="odd">
                                    <td style="border-right:thick solid #fff;" width="30%">Have you raised any funding for
                                        your incubatee?</td>
                                    <td width="60%">
                                        <?php echo $val = ($eir_detail[0]['funding'] == '1') ? 'YES' : 'No'; ?>
                                    </td>
                                </tr>
                                <?php
                                if ($eir_detail[0]['funding'] == '1') {
                                    ?>
                                    <tr class="even">
                                        <td width="30%">If yes, provide details of funding raised</td>
                                        <td width="60%"><?= $eir_detail[0]['funding_detail'] ?></td>
                                    </tr>
                                <?php }
                                ?>
                                <tr class="odd">
                                    <td style="border-right:thick solid #fff;" width="30%">Have you set up an incubatee
                                        previously?</td>
                                    <td width="60%">
                                        <?php echo $val = ($eir_detail[0]['enterprise_setup'] == '1') ? 'YES' : 'No'; ?>
                                    </td>
                                </tr>
                                <?php
                                if ($eir_detail[0]['enterprise_setup'] == '1') {
                                    ?>
                                    <tr class="even">
                                        <td width="30%">If yes, provide details of incubatee and current status of the
                                            enterprise </td>
                                        <td width="60%"><?= $eir_detail[0]['setup_detail'] ?></td>
                                    </tr>
                                <?php }
                                ?>
                                <tr class="odd">
                                    <td style="border-right:thick solid #fff;" width="30%">Are you incorporated as a
                                        for-profit entity?</td>
                                    <td width="60%">
                                        <?php echo $val = ($eir_detail[0]['for_profit'] == '1') ? 'YES' : 'No'; ?>
                                    </td>
                                </tr>
                                <tr class="even">
                                    <td style="border-right:thick solid #fff;" width="30%">The Entrepreneur-in-Residence
                                        program is a full-time, 12-month commitment. Are you willing to commit 12 months to
                                        establishing your business?</td>
                                    <td width="60%">
                                        <?php echo $val = ($eir_detail[0]['program_time'] == '1') ? 'YES' : 'No'; ?>
                                    </td>
                                </tr>
                                <tr class="odd">
                                    <td style="border-right:thick solid #fff;" width="30%">How did you hear about the
                                        Entrepreneur-in-Residence program?</td>
                                    <td width="60%"><?= $eir_detail[0]['know_about'] ?></td>
                                </tr>
                                <?php
                                $resume = explode("|", $files[0]['resume']);
                                $docs = explode("|", $files[0]['additional_documents']);
                                ?>
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"><b>Additional Documents</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="background-color:#FFF"></td>
                                </tr>
                                <tr class="odd">
                                    <td style="border-right:thick solid #fff;">Resume</td>
                                    <td width="30%"><?php
                                        $j = 0;
                                        foreach ($resume as $row) {
                                            if ($j != 0) {
                                                echo ",";
                                            }
                                            $filename = pathinfo($row, PATHINFO_FILENAME);
                                            ?>
                                            <a href="<?php echo $row; ?>" download target="_blank"><?php echo $filename; ?></a>
                                            <?php
                                            $j = $j + 1;
                                        }
                                        ?></td>
                                </tr>
                                <tr class="even">
                                    <td>General Documents</td>
                                    <td style="width:50%;"><?php
                                        $j = 0;
                                        foreach ($docs as $row1) {
                                            if ($j != 0) {
                                                echo ",";
                                            }
                                            $filename1 = pathinfo($row1, PATHINFO_FILENAME);
                                            ?>
                                            <a href="<?php echo $row1; ?>" download target="_blank"><?php echo $filename1; ?></a>
                                            <?php
                                            $j = $j + 1;
                                        }
                                        ?></td>
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