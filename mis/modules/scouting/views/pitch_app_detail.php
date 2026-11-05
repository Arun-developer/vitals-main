<?php
foreach ($pitch_user as $row):
    ?>
    <div id="user-grid" class="grid-view">
        <table width="80%" class="items gtable" bgcolor="#F5F5F5" cellspacing="5" cellpadding="5" border="1px">
            <thead>
                <tr>
                    <th colspan="2"><?= $row['org_name'] ?></th>
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
                    <td><?= $row['inno_id'] ?></td>
                </tr>
                <tr class="even">
                    <td>Name of the Organisation</td>
                    <td><?= $row['org_name'] ?></td>
                </tr>
                <tr class="odd">
                    <td style="border-right:thick solid #fff;">Name of the Applicant</td>
                    <td><?= $row['app_name'] ?></td>
                </tr>
                <tr class="even">
                    <td>Age</td>
                    <td><?= $row['age'] ?></td>
                </tr>
                <tr class="odd">
                    <td>Email Address</td>
                    <td><?= $row['email'] ?></td>
                </tr>
                <tr class="even">
                    <td style="border-right:thick solid #fff;">Mobile Number</td>
                    <td><?= $row['mobileno'] ?></td>
                </tr>
                <tr class="odd">
                    <td>Alternate Phone Number</td>
                    <td><?= $alt = (($row['altmobileno'] !== ' ' && $row['altmobileno'] !== '0') ? $row['altmobileno'] : '') ?></td>
                </tr>
                <tr class="odd">
                    <td>City</td>
                    <td><?= $row['city'] ?></td>
                </tr>

                <tr class="even">
                    <td style="border-right:thick solid #fff;">Date Created</td>
                    <td><?= date('Y-m-d', strtotime($row['reg_date'])) ?></td>
                </tr>

                <tr></tr>
                <tr>
                    <td colspan="2">
                        <table id="add_info" class="gtable" width="100%">
                            <?php if (count($pitch_member) > 0) { ?>
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
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <?php
                                                    $i = 1;
                                                    foreach ($pitch_member as $team) {
                                                        if ($team['name'] != '' || $team['cur_org'] != '' || $team['cur_title'] != '' || $team['email'] != '' || $team['phone'] != '') {
                                                            ?>

                                                    <tr class="odd">
                                                        <td style="margin-left:152px;font-size:14px;color:#A9CF55;font-weight:bold">
                                                            Member <?= $i ?></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr class="even">
                                                        <td>Name</td>
                                                        <td><?= $team['name'] ?></td>
                                                    </tr>
                                                    <tr class="odd">
                                                        <td>Current Organisation</td>
                                                        <td><?= $team['cur_org'] ?></td>
                                                    </tr>
                                                    <tr class="odd">
                                                        <td>Email id</td>
                                                        <td><?= $team['email'] ?></td>
                                                    </tr>
                                                    <tr class="even">
                                                        <td>Mobile No</td>
                                                        <td><?= $team['phone'] ?></td>
                                                    </tr>
                                                    <?php
                                                }

                                                $i++;
                                            }
                                            ?>
                                    </td>
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
                    <td colspan="2" style="background-color:#FFF"><b>Information about incubatee</b></td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color:#FFF"></td>
                </tr>
                <tr class="even">
                    <td style="border-right:thick solid #fff;" width="30%">Briefly explain the specific problem addressed.
                        (max. 150 words):</td>
                    <td width="60%"><?= $pitch_org[0]['addr_problem'] ?></td>
                </tr>
                <tr class="odd">
                    <td style="border-right:thick solid #fff;" width="30%">Describe your idea, product or service and how it
                        addresses the problem. (max. 250 words)</td>
                    <td width="60%"><?= $pitch_org[0]['quest_1'] ?></td>
                </tr>
                <tr class="even">
                    <td style="border-right:thick solid #fff;" width="30%">Explain using bullet points, the impact your
                        incubatee has on people at the bottom of the pyramid (max. 150 words).</td>
                    <td width="60%"><?= $pitch_org[0]['ent_impact'] ?></td>
                </tr>
                <tr class="odd">
                    <td style="border-right:thick solid #fff;" width="30%">Sector</td>
                    <td width="60%"><?php
                        $sector = unserialize($pitch_org[0]['sector']);
                        if (!empty($sector)) {
                            if (is_array($sector))
                                $sec = implode(',', $sector);
                            else
                                $sec = $sector;
                            if (in_array('others', $sector) || $sector == 'others') {
                                $sec .= ' - ' . $pitch_org[0]['areas_other'];
                            }
                            echo $sec;
                        }
                        ?></td>
                </tr>
                <tr class="even">
                    <td style="border-right:thick solid #fff;" width="30%">Incubatee Stage</td>
                    <td width="60%"><?php
                        $stage = unserialize($pitch_org[0]['stage']);

                        echo $stage;
                        ?></td>
                </tr>
                <tr class="odd">
                    <td style="border-right:thick solid #fff;" width="30%">Indicate the current status of your incubatee
                        and your funding requirement. (max. 150 words)</td>
                    <td width="60%"><?= $pitch_org[0]['fund_req'] ?></td>
                </tr>
                <tr class="even">
                    <td width="30%" style="border-right:thick solid #fff;">Explain your business model. How will your
                        product/service generate revenue (who pays you, your channels of distribution and profit margin)?
                        (max. 150 words)</td>
                    <td width="60%"><?= $pitch_org[0]['revenue'] ?></td>
                </tr>
                <tr class="odd">
                    <td width="30%" style="border-right:thick solid #fff;">Provide a brief profile of your management team
                        and founders. (max. 250 words)</td>
                    <td width="60%"><?= $pitch_org[0]['profile_desc'] ?></td>
                </tr>
                <tr class="even">
                    <td style="border-right:thick solid #fff;" width="30%">Have you raised funding?</td>
                    <td width="60%"><?= $pitch_org[0]['fund'] ?></td>
                </tr>
                <?php if ($pitch_org[0]['fund'] == 'yes') { ?>
                    <tr class="odd">
                        <td style="border-right:thick solid #fff;" width="30%">If yes, how much and from whom? (100 characters)
                        </td>
                        <td width="60%"><?= $pitch_org[0]['quest_5'] ?></td>
                    </tr>
                <?php } ?>
                <tr class="even">
                    <td width="30%" style="border-right:thick solid #fff;">Have you won a prize, recognition, award for your
                        incubatee? If yes, please mention below.</td>
                    <td width="60%"><?= $pitch_org[0]['awards_yes'] ?></td>
                </tr>
                <tr class="odd">
                    <td width="30%" style="border-right:thick solid #fff;">Which city your incubatee based-out of?</td>
                    <td width="60%"><?= $pitch_org[0]['city'] ?></td>
                </tr>

                <tr class="even">
                    <td style="border-right:thick solid #fff;" width="30%">How did you come to know about us?</td>
                    <td width="60%"><?= $pitch_org[0]['about_us'] ?>
                        <?php
                        switch ($pitch_org[0]['about_us']) {
                            case 'emailer':
                                echo ' - ' . $pitch_org[0]['emailer'];
                                break;
                            case 'social media':
                                echo ' - ' . $pitch_org[0]['social_media'];
                                break;
                            case 'website': {
                                    echo ' - ' . $pitch_org[0]['website'];
                                    if ($pitch_org[0]['website'] == 'other')
                                        echo ' - ' . $pitch_org[0]['other_website'];
                                    break;
                                }
                            case 'others':
                                echo ' - ' . $pitch_org[0]['other_aboutus'];
                                break;
                        }
                        ?>
                    </td>
                </tr>
                <tr class="odd">
                    <td style="border-right:thick solid #fff;" width="30%">Upload Documents</td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color:#FFF"></td>
                </tr>
                <tr class="even">
                    <td></td>
                    <td style="width:50%;">
                        <a href="<?php echo host_url() . 'pitchform/document/' . $pitch_doc[0]['doc1']; ?>" download
                           target="_blank"><?php echo $pitch_doc[0]['doc1']; ?></a>
                    </td>
                </tr>
                <tr class="even">
                    <td></td>
                    <td width="30%">
                        <a href="<?php echo host_url() . 'pitchform/document/' . $pitch_doc[0]['doc2']; ?>" download
                           target="_blank"><?php echo $pitch_doc[0]['doc2']; ?></a>
                    </td>
                </tr>
                <tr class="odd">
                    <td></td>
                    <td width="30%">
                        <a href="<?php echo host_url() . 'pitchform/document/' . $pitch_doc[0]['doc3']; ?>" download
                           target="_blank"><?php echo $pitch_doc[0]['doc3']; ?></a>
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