<?php foreach ($step1 as $row) { ?>

    <table class="gtable " width="80%" class="items" bgcolor="#F5F5F5" cellspacing="5" cellpadding="5" border="1px">
        <thead>
            <tr>
                <th colspan="2"><?php echo $row['name_venture']; ?></th>
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
                <td style="width:40%">Name </td>
                <td><?php echo $row['firstname']; ?></td>
            </tr>
            <tr>
                <td>Contact Email Address(es)</td>
                <td><?php echo $row['email']; ?></td>
            </tr>
            <tr>
                <td>Contact Phone Number(s)</td>
                <td><?php echo $row['phone']; ?></td>
            </tr>
            <tr>
                <td>How did you hear about SEED Programme </td>
                <td><?php echo $row['hear_seed']; ?></td>
            </tr>
            <tr>
                <td>Country of Citizenship</td>
                <td><?php echo $row['citizenship']; ?></td>
            </tr>
            <tr>
                <td>Full Time Committed</td>
                <td><?php echo ($row['commit_fulltime'] == 'yes' || $row['commit_fulltime'] == 'Yes') ? "Yes.I am full time committed." : "No.I have another full time engagement"; ?>
                </td>
            </tr>

            <tr>
                <td>Name of the Venture</td>
                <td><?php echo $row['name_venture']; ?></td>
            </tr>


            <tr>
                <td>Is your organization an incorporated for profit entity</td>
                <td><?php echo $row['org_incorp']; ?></td>
            </tr>

            <tr>
                <td>Source</td>
                <td><?= $innovationDetails[0]['source_type'] ?> - <?= $innovationDetails[0]['source_name'] ?></td>
            </tr>


            <tr>
                <td colspan="2">
                    <table id="seed_add_info" class="gtable " width="100%">
                        <tr class="even">
                            <td colspan="2" style="background-color:#FFF"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color:#FFF"><b>Applicant Information</b></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color:#FFF"></td>
                        </tr>


                        <tr class="even">
                            <td>Website</td>
                            <td><?php echo $row['website']; ?></td>
                        </tr>


                        <tr class="odd">
                            <td>Postal Address</td>
                            <td><?php echo $row['postal_add']; ?></td>
                        </tr>
                        <tr class="even">
                            <td>Region(s) of Organization</td>
                            <td><?php echo $row['regions_ope']; ?></td>
                        </tr>

                        <tr class="odd">
                            <td>Number of months in operation</td>
                            <td><?php echo $row['nom_ope']; ?></td>
                        </tr>
                        <tr class="even">
                            <td>What sector do you operate in?</td>
                            <td><?php echo $row['sector']; ?></td>
                        </tr>
                        <tr class="odd">
                            <td>Have you raised institutional funding/grants/investment in the past? If so, how much and
                                from whom?</td>
                            <td><?php echo $row['funding_summary']; ?></td>
                        </tr>

                        <tr class="even">
                            <td colspan="2" style="background-color:#FFF"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color:#FFF"><b>Management Team</b></td>
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
    $i = 1;
    foreach ($member as $mem) {
        if ($mem['s2_name'] != '' || $mem['s2_email'] != '' || $mem['s2_phone'] != '' || $mem['s2_resume'] != '') {
            ?>

                                            <tr class="odd">
                                                <td style="margin-left:152px;font-size:14px;color:#A9CF55;font-weight:bold">Member
                                                    <?= $i ?></td>
                                                <td></td>
                                            </tr>
                                            <tr class="even">
                                                <td>Name</td>
                                                <td><?php echo $mem['s2_name']; ?></td>
                                            </tr>
                                            <tr class="odd">
                                                <td>Email ID</td>
                                                <td><?php echo $mem['s2_email']; ?></td>
                                            </tr>
                                            <tr class="even">
                                                <td>Phone Number</td>
                                                <td><?php echo $mem['s2_phone']; ?></td>
                                            </tr>
                                            <tr class="odd">
                                                <td>Resume</td>
                                                <td><a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/seedForm/memberuploads/' . $mem['s2_resume']; ?>"
                                                       target="_blank"><?php echo $mem['s2_resume']; ?></a></td>
                                            </tr>
                                            <tr class="even">
                                                <td>Member of Founding Team</td>
                                                <td><?php echo ($mem['s2_check'] == '1') ? 'YES' : 'NO'; ?></td>
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



            <tr class="even">
                <td colspan="2" style="background-color:#FFF"></td>
            </tr>
            <tr>
                <td colspan="2" style="background-color:#FFF"><b>Entrepreneur</b></td>
            </tr>
            <tr>
                <td colspan="2" style="background-color:#FFF"></td>
            </tr>
            <tr class="even">
                <td>What inspired you to start this social incubatee?</td>
                <td><?php echo $step2[0]['inspire_start']; ?></td>
            </tr>


            <tr class="odd">
                <td>What value do you expect the SEED program to bring to you and your organization?</td>
                <td><?php echo $step2[0]['seed_value']; ?></td>
            </tr>



            <tr class="even">
                <td colspan="2" style="background-color:#FFF"></td>
            </tr>
            <tr>
                <td colspan="2" style="background-color:#FFF"><b>Product</b></td>
            </tr>
            <tr>
                <td colspan="2" style="background-color:#FFF"></td>
            </tr>


            <tr class="even">
                <td>What is your product/service?</td>
                <td><?php echo $step2[0]['product_service']; ?></td>
            </tr>
            <tr class="odd">
                <td>What need does your product/service address?</td>
                <td><?php echo $step2[0]['need_service']; ?></td>
            </tr>


            <tr class="even">
                <td>What makes your solution innovative?</td>
                <td><?php echo $step2[0]['solution_inno']; ?></td>
            </tr>

            <tr>
                <td colspan="2" style="background-color:#FFF"></td>
            </tr>
            <tr>
                <td colspan="2" style="background-color:#FFF"><b>Social Impact</b></td>
            </tr>
            <tr>
                <td colspan="2" style="background-color:#FFF"></td>
            </tr>


            <tr class="even">
                <td>What is the social impact that your innovation creates?</td>
                <td><?php echo $step2[0]['social_impact']; ?></td>
            </tr>
            <tr class="odd">
                <td>How does your organizaton measure its social impact? </td>
                <td><?php echo $step2[0]['measure_impact']; ?></td>
            </tr>

            <tr class="even">
                <td colspan="2" style="background-color:#FFF"></td>
            </tr>
            <tr>
                <td colspan="2" style="background-color:#FFF"><b>Business Viability</b></td>
            </tr>
            <tr>
                <td colspan="2" style="background-color:#FFF"></td>
            </tr>


            <tr class="even">
                <td>How big do you estimate the market for your product to be?(In terms of Rs. crores) </td>
                <td><?php echo $step3[0]['ques1']; ?></td>
            </tr>

            <tr class="odd">
                <td>Have you undertaken pilots for your venture? If so, where and to what scale?</td>
                <td><?php echo $step3[0]['ques2']; ?></td>
            </tr>

            <tr class="even">
                <td>What have been your major learning since launching your incubatee?</td>
                <td><?php echo $step3[0]['ques3']; ?></td>
            </tr>
            <tr class="odd">
                <td>Who are your key customers? And who is your end user?</td>
                <td><?php echo $step3[0]['ques4']; ?></td>
            </tr>
            <tr class="even">
                <td>Business plan document</td>
                <td><a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/seedForm/businessdocs/' . $step3[0]['business_plan']; ?>"
                       target="_blank"><?php echo $step3[0]['business_plan']; ?></a></td>
            </tr>

            <tr>
                <td colspan="2" style="background-color:#FFF"></td>
            </tr>
            <tr>
                <td colspan="2" style="background-color:#FFF"><b>Scalability</b></td>
            </tr>
            <tr>
                <td colspan="2" style="background-color:#FFF"></td>
            </tr>

            <tr class="even">
                <td>List the steps you will take to achieve your business goals for the next six month?</td>
                <td><?php echo $step3[0]['ques5']; ?></td>
            </tr>

            </p>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </div>
    <?php
}
?>