<?php
foreach ($basic_info as $row):
    ?>
    <h2><?= $row['name_of_organisation'] ?></h2>

    <div id="user-grid" class="grid-view">
        <table width="80%" class="items" bgcolor="#F5F5F5" cellspacing="2" cellpadding="2" border="1px">
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
                    <td style="width:40%">Innovation Id </td>
                    <td><?= $row['innovation_no'] ?></td>
                </tr>

                <tr class="even">
                    <td>Source</td>
                    <td>EIR Application</td>
                </tr>

                <tr class="odd">
                    <td>Name of the Applicant</td>
                    <td><?= $row['name_of_applicant'] ?></td>
                </tr>
                <tr class="even">
                    <td>Email Address</td>
                    <td><?= $row['email_id'] ?></td>
                </tr>
                <tr class="odd">
                    <td>Mobile Number</td>
                    <td><?= $row['mobile_no'] ?></td>
                </tr>
                <tr class="even">
                    <td>Alternate Phone Number</td>
                    <td><?= $row['alt_phone_no'] ?></td>
                </tr>
                <tr class="odd">
                    <td>Date Created</td>
                    <td><?= $row['date_created'] ?></td>
                </tr>
                <tr class="even">
                    <td>Date Submitted</td>
                    <td><?= $row['date_submitted'] ?></td>
                </tr>
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
                                foreach ($team_info as $team):
                                    $i = $i + 1;
                                    ?>
                                    <td>
                                        <table style="font: 12px/15px Arial,sans-serif;background-color:none" cellspacing="2"
                                               cellpadding="2" border="1px;">
                                            <tr>
                                                <td colspan="2" style="background-color: #A9CF55;text-align: center;">Team
                                                    Member <?= $i ?></td>
                                            </tr>
                                            <tr>
                                                <td>Name</td>
                                                <td><?= $team['name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Current Organisation</td>
                                                <td><?= $team['current_organisation'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Current title</td>
                                                <td><?= $team['current_title'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Email id</td>
                                                <td><?= $team['email_id'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Mobile No</td>
                                                <td><?= $team['mobile_no'] ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php foreach ($app_info as $app): ?>
                    <tr></tr>
                    <tr></tr>
                    <tr class="even">
                        <td>Briefly describe your key competencies and skills that will enable you to set up an
                            incubatee (250 words):
                        </td>
                        <td><?= $app['skills'] ?></td>
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
                        <td>Briefly describe your idea, product or service (250 words)</td>
                        <td><?= $app['describtion_of_idea'] ?></td>
                    </tr>
                    <tr class="odd">
                        <td>Describe the innovative element in your incubatee (250 words)</td>
                        <td><?= $app['innovative_element'] ?></td>
                    </tr>
                    <tr class="even">
                        <td>What need does your idea address? What is the social benefit created by your idea
                            (250 words)</td>
                        <td><?= $app['social_benefit'] ?></td>
                    </tr>
                    <tr class="odd">
                        <td>Have you undertaken any pilots for your idea? If yes, please provide some detail on
                            the pilot and the key insights you gathered form the pilot (250 words)</td>
                        <td><?= $app['pilots_of_idea'] ?></td>
                    </tr>
                    <tr class="even">
                        <td>What are your expectations from the EIR program? What specific value addition
                            are you looking for? (250 words)</td>
                        <td><?= $app['expectation_from_EIR'] ?></td>
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
                        <td>Have you raised any funding for your incubatee?</td>
                        <td>
                            <? echo $val = ($app['funding'] == '1') ? 'YES' : 'No'; ?>
                        </td>
                    </tr>
                    <?php
                    if ($app['funding'] == '1') {
                        ?>
                        <tr class="even">
                            <td>If yes, provide details of funding raised</td>
                            <td><?= $app['funding_detail'] ?></td>
                        </tr>
                    <?php }
                    ?>
                    <tr class="odd">
                        <td>Have you set up an incubatee previously?</td>
                        <td>
                            <? echo $val = ($app['enterprise_setup'] == '1') ? 'YES' : 'No'; ?>
                        </td>
                    </tr>
                    <?php
                    if ($app['enterprise_setup'] == '1') {
                        ?>
                        <tr class="even">
                            <td>If yes, provide details of set u</td>
                            <td><?= $app['setup_detail'] ?></td>
                        </tr>
                    <?php }
                    ?>
                    <tr class="odd">
                        <td>Are you incorporated as a for-profit entity?</td>
                        <td>
                            <? echo $val = ($app['for_profit'] == '1') ? 'YES' : 'No'; ?>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>The Entrepreneur-in-Residence program is a full-time, 12-month commitment. Are you willing to commit
                            12 months to establishing your business?</td>
                        <td>
                            <? echo $val = ($app['program_time'] == '1') ? 'YES' : 'No'; ?>
                        </td>
                    </tr>
                    <tr class="odd">
                        <td>How did you hear about the Entrepreneur-in-Residence program?</td>
                        <td><?= $app['know_about'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
    endforeach;
    ?>
</div>