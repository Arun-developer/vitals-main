<?php
foreach ($inv_user as $row) {
    ?>
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
                    $country = $this->Minnovation->getCountryName($row['country']);
                    echo $country[0];
                    ?></td>
            </tr>

            <tr>
                <td>Is your incubatee a</td>
                <td><?php echo $row['ent_type']; ?></td>
            </tr>

            <tr>
                <td>Will your social incubatee be based in India</td>
                <td><?php echo $row['india_based']; ?></td>
            </tr>

            <tr>
                <td>Please select the relevant sector for your incubatee</td>
                <td><?php echo $sector_name; ?></td>
            </tr>

            <tr>
                <td>Who will be the beneficiaries of your product / service?</td>
                <td><?php
                    $benificary = unserialize($row['benificiary']);
                    echo php72_implode(',', $benificary);
                    ?></td>
            </tr>

            <tr>
                <td>What type of impact will your product / service have on the BoP / poor?</td>
                <td><?php echo $row['impact_of_product']; ?></td>
            </tr>

            <tr>
                <td colspan="2"><a href="#bottom" id="inv_info" style="color:#719e41;">** Additional Information</a>
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
                                                    <td style="margin-left:152px;font-size:14px;color:#A9CF55;font-weight:bold">Member
                                                        <?= $i ?></td>
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
                                $state_list = $state_list . ',' . $this->Minnovation->getStateName($state);
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
                <td><?php echo $inv_ent_info[0]['inv_desc']; ?></td>
            </tr>

            <tr class="odd">
                <td>What problem does your innovation address? </td>
                <td><?php echo $inv_ent_info[0]['inv_problem']; ?></td>
            </tr>

            <tr class="even">
                <td>How is the need addressed without your innovation? What are the available alternatives? </td>
                <td><?php echo $inv_ent_info[0]['inv_alternatives']; ?></td>
            </tr>

            <tr class="even">
                <td>Describe your proposed / current business model </td>
                <td><?php echo $inv_ent_info[0]['proposal_desc']; ?></td>
            </tr>

            <tr class="odd">
                <td>What challenges / risks have you identified in the business?</td>
                <td><?php echo $inv_ent_info[0]['inv_risks']; ?></td>
            </tr>



            <tr class="even">
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
                <td><?php echo $inv_impact[0]['primary_benifi']; ?></td>
            </tr>
            <tr class="odd">
                <td>Have you conducted research on your customer segments / run pilots?</td>
                <td><?php echo $inv_impact[0]['research_cus_seg']; ?></td>
            </tr>

            <?php if ($inv_impact[0]['research_cus_seg'] == 'yes') {
                ?>
                <tr class="even">
                    <td>What is the demographic profile of the primary beneficiary group? </td>
                    <td><?php echo $inv_impact[0]['demographic_profie']; ?></td>
                </tr>

                <tr class="odd">
                    <td>What is the average monthly earning of the primary beneficiary group? </td>
                    <td><?php echo $inv_impact[0]['avg_monthly']; ?></td>
                </tr>
            <?php } ?>

            <tr class="even">
                <td>How many people do you expect to impact through your innovation? </td>
                <td><?php echo $inv_impact[0]['inv_impact']; ?></td>
            </tr>

            <tr class="odd">
                <td>Will your product or service benefit other beneficiary groups? Describe these groups briefly. </td>
                <td><?php echo $inv_impact[0]['others_benefit']; ?></td>
            </tr>


            <tr>
                <td colspan="2" style="background-color:#FFF"></td>
            </tr>
            <tr>
                <td colspan="2" style="background-color:#FFF"><b>Additional information </b></td>
            </tr>
            <tr>
                <td colspan="2" style="background-color:#FFF"></td>
            </tr>


            <tr class="even">
                <td>Please indicate the support you would like from Villgro</td>
                <td><?php echo $add_info[0]['from_villgro']; ?></td>
            </tr>
            <?php
            $support = explode(",", $add_info[0]['from_villgro']);
            if (in_array('Other', $support)) {
                ?>
                <tr class="odd">
                    <td>Other Support</td>
                    <td><?php echo $add_info[0]['support_name']; ?></td>
                </tr>
                <?php
            }
            ?>
            <tr class="even">
                <td>How did you hear about Villgro</td>
                <td><?php echo $add_info[0]['hear_abt']; ?></td>
            </tr>

            <?php
            $hear_abt = explode(",", $add_info[0]['hear_abt']);
            if (in_array('Referral', $hear_abt) || in_array('Past incubatee', $hear_abt) || in_array('Villgro staff', $hear_abt)) {
                ?>
                <tr class="odd">
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
                <tr class="odd">
                    <td>Name of organization(s)</td>
                    <td><?php echo $add_info[0]['ant_org_name']; ?></td>
                </tr>
            <?php } ?>
            <tr class="even">
                <td>Have you participated in or won any business plan competitions?</td>
                <td><?php echo $add_info[0]['won_competition']; ?></td>
            </tr>

            <tr class="odd">
                <td>Name of business plan competition(s)</td>
                <td><?php echo $add_info[0]['competition_name']; ?></td>
            </tr>

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

            <tr class="odd">
                <td>Additional Information</td>
                <td><?php
                    if ($add_info[0]['add_info'] != '') {
                        ?>
                        <a href="<?php echo host_url() . 'IncubationForm/uploads/' . $add_info[0]['add_info']; ?>"
                           target="_blank"><?php echo $add_info[0]['add_info']; ?></a>
                    <?php } ?></td>
            </tr>

            </p>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </div>
<?php } ?>