<html>
<head>
    <style>
        body {font-family: Helvetica, Arial, sans-serif; color:#333; font-size:10px;}
        .pdf-page {height:100%; margin:10px -13px -20px -10px; padding:30px;}
        .pdf-page p {width:100%; margin:0 0 20px 0;}
        .front-page {height:100%; margin:0px 0px 0px 0px;}
        h1 {color: #FFFFFF; background-color: #014c67; font-weight:100; font-size:18px; padding:5px;}
        h2 {color: #c41030; font-weight:100; font-size:16px;}
        h3 {color: #014c67; font-size:12px}
        h4 {color: #014c67; background-color: #e5edf0; font-size:12px; font-weight:normal; padding:3px 3px 4px 5px; margin-bottom:3px; padding-bottom:4px;}
        h5 {color: #c41030;}
        table, th, td { padding: 0px; border: 1px solid black; text-align: left}
        th, td {font-size: 14px; padding: 10px; text-align: left;}
        .bold-text { font-weight: bold;}
        .page_break { page-break-before: always; }
        .title_text{font-weight:100; font-size:18px; padding:5px;text-align: center;color: #c41030;}
        img{width:150px;}
        .logo{text-align: right;}
    </style>
</head>
<body>
    <div class="logo">
        <img src="https://mis.villgroapps.org/mis_master/source/template/images/logo.gif" alt="Villgro Logo" height="110" width="259"/>
    </div>
    <?php if ($inv_user[0]['application_type'] == 1) { ?>
        <div>
            <?php if($innovationDetails[0]['program'] == '11') { ?>
                <p class="title_text">SISFS Application</p>
            <?php } else { ?>
                <p class="title_text">Incubation Application</p>
            <?php } ?>
            <h1>Account Information</h1>
            <table width="100%">
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">Partner</td>
                    <td style="width:70%;"><?php echo ucfirst($innovationDetails[0]['branch_name']); ?></td>
                </tr>
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">Name of Incubatee</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['ent_name']; ?></td>
                </tr>
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">Name of the Entrepreneur</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['applicant_name']; ?></td>
                </tr>
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">Email</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['email']; ?></td>
                </tr>
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">Mobile</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['mobile']; ?></td>
                </tr>
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">Address 1</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['address1']; ?></td>
                </tr>
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">Address 2</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['address2']; ?></td>
                </tr>
                <?php $country = $this->Minnovation->getCountryName($inv_user[0]['country']); ?>
                <tr>
                    <td class="bold-text">Country</td>
                    <td style="width:70%;"><?php echo $country[0]; ?></td>
                </tr>
            </table>
            <div class="page_break"></div>
            <h1>Team Information</h1>
            <table width="100%">
                <?php
                $m = 1;
                foreach ($inv_team as $member) {
                    ?>
                    <tr>
                        <td style="width:100%">
                            <table style="width:100%; margin-bottom: 20px;" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="width:30%;"><b>Name</b></td>
                                    <td style="width:70%;"><?php echo $member['mem_name']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width:30%;"><b>Designation</b></td>
                                    <td style="width:70%;"><?php echo $member['mem_occupation']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width:30%;"><b>Organization</b></td>
                                    <td style="width:70%;"><?php echo $member['mem_org']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width:30%;"><b>Email</b></td>
                                    <td style="width:70%;"><?php echo $member['mem_email']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width:30%;"><b>Mobile</b></td>
                                    <td style="width:70%;"><?php echo $member['mem_mobile']; ?></td>
                                </tr>
                                <tr>
                                    <td style="width:30%;" valign='middle'><b>Gender</b></td>
                                    <td style="width:70%;"><?php echo ucfirst($member['mem_gender']); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                    $m++;
                }
                ?>
            </table>
            <div class="page_break"></div>
            <h1>More information about incubatee</h1>
            <table width="100%">
                <?php
                if ($inv_user[0]['ent_type'] == 'profit') {
                    $ent_org = 'Profit Org';
                } else if ($inv_user[0]['ent_type'] == 'nonprofit') {
                    $ent_org = 'Non-profit Org';
                }
                ?>
                <tr>
                    <td style="width:30%;"><b>Is your incubatee a</b></td>
                    <td style="width:70%;"><?php echo $ent_org; ?></td>
                </tr>
                <tr>
                    <td style="width:30%;"><b>Will your social incubatee be based in India</b></td>
                    <td style="width:70%;"><?php echo ucfirst($inv_user[0]['india_based']); ?></td>
                </tr>
                <tr>
                    <td style="width:30%;"><b>Sector</b></td>
                    <td style="width:70%;"><?php echo $sector_name[0]['sector']; ?></td>
                </tr>
                <?php $sub_sectorname = $this->Sector_model->getSectorNameByID($inv_user[0]['sub_sector']); ?>
                <tr>
                    <td style="width:30%;"><b>Sub Sector</b></td>
                    <td style="width:70%;"><?php echo $sub_sectorname; ?></td>
                </tr>
                <?php $benificary = unserialize($inv_user[0]['benificiary']); ?>
                <tr>
                    <td style="width:30%;"><b>Who will be the beneficiaries of your product / service?</b></td>
                    <td style="width:70%;"><?php echo implode(', ', $benificary); ?></td>
                </tr>
                <tr>
                    <td style="width:30%;"><b>What type of impact will your product / service have on the BoP / poor?</b></td>
                    <td style="width:70%;"><?php echo $inv_user[0]['impact_of_product']; ?></td>
                </tr>
                <tr>
                    <td style="width:30%;"><b>How long have you been in operation</b></td>
                    <td style="width:70%;"><?php
                    switch ($inv_ent_info[0]['in_operation']) {
                        case '0to6':
                        echo "0 - 6 months";
                        break;
                        case '6to12':
                        echo "6 - 12 months";
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
                <tr>
                    <td style="width:30%;"><b>In which states are you operating / plan to operate</b></td>
                    <td style="width:70%;"><?php
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
                <tr>
                    <td style="width:30%;"><b>Are you developing a</b></td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['develop_product']; ?></td>
                </tr>
                <tr>
                    <td style="width:30%;"><b>At what stage is your product / service</b></td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['stage_product']; ?></td>
                </tr>
                <tr>
                    <td style="width:30%;"><b>Provide a brief description of your innovation (product or service)</b></td>
                    <td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['inv_desc']); ?></td>
                </tr>
                <tr>
                    <td style="width:30%;"><b>What problem does your innovation address?</b></td>
                    <td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['inv_problem']); ?></td>
                </tr>
                <?php // if ($pitch_org[0]['fund'] == 'yes') { ?>
                    <tr>
                        <td style="width:30%;"><b>How is the need addressed without your innovation? What are the available alternatives?</b></td>
                        <td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['inv_alternatives']); ?></td>
                    </tr>
                    <?php // } ?>
                    <tr>
                        <td style="width:30%;"><b>Describe your proposed / current business model</b></td>
                        <td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['proposal_desc']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What challenges / risks have you identified in the business?</b></td>
                        <td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['inv_risks']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Who is the intended primary beneficiary of your product / service?</b></td>
                        <td style="width:70%;"><?php echo nl2br($inv_impact[0]['primary_benifi']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Have you conducted research on your customer segments / run pilots?</b></td>
                        <td style="width:70%;"><?php echo ucfirst($inv_impact[0]['research_cus_seg']); ?></td>
                    </tr>
                    <?php if ($inv_impact[0]['research_cus_seg'] == 'yes') { ?>
                        <tr>
                            <td style="width:30%;"><b>What is the demographic profile of the primary beneficiary group?</b></td>
                            <td style="width:70%;"><?php echo nl2br($inv_impact[0]['demographic_profie']); ?></td>
                        </tr>
                        <tr>
                            <td style="width:30%;"><b>What is the average monthly earning of the primary beneficiary group?</b></td>
                            <td style="width:70%;"><?php echo nl2br($inv_impact[0]['avg_monthly']); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="width:30%;"><b>How many people do you expect to impact through your innovation?</b></td>
                        <td style="width:70%;"><?php echo nl2br($inv_impact[0]['inv_impact']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Will your product or service benefit other beneficiary groups? Describe these groups briefly.</b></td>
                        <td style="width:70%;"><?php echo nl2br($inv_impact[0]['others_benefit']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Please indicate the support you would like from us</b></td>
                        <td style="width:70%;"><?php echo str_replace(',', ', ', $add_info[0]['from_villgro']); ?></td>
                    </tr>
                    <?php
                    $support = explode(",", $add_info[0]['from_villgro']);
                    if (in_array('Other', $support)) {
                        ?>
                        <tr>
                            <td style="width:30%;"><b>Other Support</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['support_name']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="width:30%;"><b>How did you come to know about us?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['hear_abt']; ?></td>
                    </tr>
                    <?php
                    $hear_abt = explode(",", $add_info[0]['hear_abt']);
                    if (in_array('Referral', $hear_abt) || in_array('Past incubatee', $hear_abt) || in_array('Villgro staff', $hear_abt)) {
                        ?>
                        <tr>
                            <td style="width:30%;"><b>Name</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['referal_name']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="width:30%;"><b>Have you been incubated, funded or participated in an accelerator program with another organization?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['ant_org']; ?></td>
                    </tr>
                    <?php if ($add_info[0]['ant_org'] == 'Yes') { ?>
                        <tr>
                            <td style="width:30%;"><b>Name of organization(s)</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['ant_org_name']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="width:30%;"><b>Have you participated in or won any business plan competitions?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['won_competition']; ?></td>
                    </tr>
                    <?php if ($add_info[0]['won_competition'] == 'Yes') { ?>
                        <tr>
                            <td style="width:30%;"><b>Name of business plan competition(s)</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['competition_name']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="width:30%;" valign='middle'><b>Business plan's</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['business_plan']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Additional Information</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['add_info']; ?></td>
                    </tr>
                </table>
            </div>
        <?php } else if ($inv_user[0]['application_type'] == 2) { ?>
            <div>
                <p class="title_text">Swachhata Startup Challenge</p>
                <h1>Account Information</h1>
                <table width="100%">
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Partner</td>
                        <td style="width:70%;"><?php echo ucfirst($innovationDetails[0]['branch_name']); ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Name of the Organisation</td>
                        <td style="width:70%;"><?php echo $inv_user[0]['ent_name']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Name of the Applicant</td>
                        <td style="width:70%;"><?php echo $inv_user[0]['applicant_name']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Email</td>
                        <td style="width:70%;"><?php echo $inv_user[0]['email']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Mobile</td>
                        <td style="width:70%;"><?php echo $inv_user[0]['mobile']; ?></td>
                    </tr>
                </table>
                <div class="page_break"></div>
                <h1>Entity Details</h1>
                <table width="100%">
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Type of Organisation</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['in_operation']; ?></td>
                    </tr>
                    <?php if ($inv_ent_info[0]['in_operation'] == 'For profit') { ?>
                        <tr bgcolor="#f9f9f9">
                            <td class="bold-text">DPIIT Recognition Number</td>
                            <td style="width:70%;"><?php echo $inv_ent_info[0]['reco_no']; ?></td>
                        </tr>
                        <tr bgcolor="#f9f9f9">
                            <td class="bold-text">Corporate Identity Number</td>
                            <td style="width:70%;"><?php echo $inv_ent_info[0]['cin']; ?></td>
                        </tr>
                    <?php } else if ($inv_ent_info[0]['in_operation'] == 'Collaboration of multiple entities') { ?>
                        <tr bgcolor="#f9f9f9">
                            <td class="bold-text">Please elaborate on the collaboration with a French entity</td>
                            <td style="width:70%;"><?php echo $inv_ent_info[0]['inv_desc']; ?></td>
                        </tr>
                    <?php } ?>
                    <?php $register_date = isset($inv_ent_info[0]['org_reg_date']) && $inv_ent_info[0]['org_reg_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($inv_ent_info[0]['org_reg_date'])) : ''; ?>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Date of registration of your organisation</td>
                        <td style="width:70%;"><?php echo $register_date; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Website URL</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['website_url']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Social media links</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['social_media']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Short description of your organisation</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['org_short_desc']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td style="width:30%;"><b>Sector</b></td>
                        <td style="width:70%;"><?php echo $sector_name[0]['sector']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Focus Area</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['type_prod']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">PAN Number</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['pan']; ?></td>
                    </tr>
                    <?php $state_list = $this->Minnovation->getStateName($inv_ent_info[0]['operate_on_state']); ?>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">State</td>
                        <td style="width:70%;"><?php echo $state_list; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">City</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['city']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Pin code</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['pincode']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Address</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['address']; ?></td>
                    </tr>
                </table>
                <div class="page_break"></div>
                <h1>Preferences</h1>
                <table width="100%">
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Have you participated in the Swachh Technology Challenge, by MOHUA in the past?</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['tech_challege']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Why are you applying for this Swachhata Startup Challenge?</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['startup_challenge']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">What are you most interested in learning more about?</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['vill_support']; ?></td>
                    </tr>
                    <?php if (in_array('Other', $villsupport)) { ?>
                        <tr bgcolor="#f9f9f9">
                            <td class="bold-text">If Other please specify</td>
                            <td style="width:70%;"><?php echo $inv_ent_info[0]['support_name']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <div class="page_break"></div>
                <h1>Team Information</h1>
                <table width="100%">
                    <?php
                    $m = 1;
                    foreach ($inv_team as $member) {
                        ?>
                        <tr>
                            <td style="width:100%">
                                <table style="width:100%; margin-bottom: 20px;" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="width:30%;"><b>Name</b></td>
                                        <td style="width:70%;"><?php echo $member['mem_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;"><b>Current designation / occupation</b></td>
                                        <td style="width:70%;"><?php echo $member['mem_occupation']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;"><b>Current organization</b></td>
                                        <td style="width:70%;"><?php echo $member['mem_org']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;"><b>Email</b></td>
                                        <td style="width:70%;"><?php echo $member['mem_email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;"><b>Mobile</b></td>
                                        <td style="width:70%;"><?php echo $member['mem_mobile']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;" valign='middle'><b>Gender</b></td>
                                        <td style="width:70%;"><?php echo ucfirst($member['mem_gender']); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;" valign='middle'><b>Linkedin Profile</b></td>
                                        <td style="width:70%;"><?php echo ucfirst($member['linkedin_profile']); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php
                        $m++;
                    }
                    ?>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Team Size</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['team_size']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Name and Designation of the primary point of contact for this program</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['primary_point']; ?></td>
                    </tr>
                </table>
                <div class="page_break"></div>
                <h1>Organisation Details</h1>
                <table width="100%">
                    <tr>
                        <td style="width:30%;"><b>Describe the digital innovation developed or used by your organisation. Explain how digital innovation is solving challenges in the waste sector? How is it a different approach from what has been done so far?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['inno_desc']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Which waste management issues do you plan to solve and what solutions do you propose to achieve this? Describe the details of your key activities. How is your solution different from your competition?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['inno_prob']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What category best describes your business currently?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['business_category']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Who will buy your services? If you offer a free of charge service, how do you intend to cover the costs of your organisation?Who are your key competitors?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['avail_alter']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>How much was your turnover (financial report) in the last 2 financial years? If your organisation is less than a year old</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['ident_risk']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What will be the operational model? How do you make your operations robust and efficient?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['robot_efficient']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What is your organisation’s current product stage?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['current_product']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What is the market size of the opportunity?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['market_size']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Describe the geographic area impacted by your activity</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['geographic']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>How do you aim to scale-up?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['scaleup']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Describe how your business model is replicable and scalable</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['business_model']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Estimate quantitatively and qualitatively the social and/or environmental impact of your activity? Any insight into the impact indicators, the method of calculation and the data collection will be preferable?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['estimate_qua']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Who are the key partners of your organisation?in particular with local actors</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['part_org']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Video URL showcasing the product and/or business model</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['video_url']); ?></td>
                    </tr>
                </table>
                <div class="page_break"></div>
                <h1>Funding Details</h1>
                <table width="100%">
                    <tr>
                        <td style="width:30%;"><b>Have you received monetary support under any Central or State government scheme? If Yes, mention the scheme name and amount?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['central_state']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Other funding details, if any?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['other_funding']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>How will this grant support you in your future growth?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['future_growth']); ?></td>
                    </tr>
                </table>
                <div class="page_break"></div>
                <h1>Upload Documents</h1>
                <table width="100%">
                    <tr>
                        <td style="width:30%;"><b>How did you hear about us</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['hear_abt']; ?></td>
                    </tr>
                    <?php
                    if ($add_info[0]['support_name'] != '') {
                        ?>
                        <tr>
                            <td style="width:30%;"><b>Other Support</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['support_name']; ?></td>
                        </tr>
                    <?php } ?>
                    <?php
                    if ($add_info[0]['referal_name'] != '') {
                        ?>
                        <tr>
                            <td style="width:30%;"><b>Name</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['referal_name']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="width:30%;" valign='middle'><b>Uploaded Document</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['business_plan']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Incorporation Certificate</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['add_info']; ?></td>
                    </tr>
                </table>
            </div>
        <?php } else if ($inv_user[0]['application_type'] == 3) { ?>
            <div>
                <p class="title_text">TANSIM’s Tamil Nadu Startup Seed Grant Fund Program</p>
                <h1>Account Information</h1>
                <table width="100%">
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Partner</td>
                        <td style="width:70%;"><?php echo ucfirst($innovationDetails[0]['branch_name']); ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Name of the Organisation</td>
                        <td style="width:70%;"><?php echo $inv_user[0]['ent_name']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Name of the Applicant</td>
                        <td style="width:70%;"><?php echo $inv_user[0]['applicant_name']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Gender</td>
                        <td style="width:70%;"><?php echo ucfirst($inv_user[0]['mobile']); ?></td>
                    </tr>
                    <?php $dob_date = isset($inv_user[0]['dob']) && $inv_user[0]['dob'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($inv_user[0]['dob'])) : ''; ?>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Date of Birth</td>
                        <td style="width:70%;"><?php echo $dob_date; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Email</td>
                        <td style="width:70%;"><?php echo $inv_user[0]['email']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Mobile</td>
                        <td style="width:70%;"><?php echo $inv_user[0]['mobile']; ?></td>
                    </tr>
                </table>
                <div class="page_break"></div>
                <h1>Entity Details</h1>
                <table width="100%">
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">DPIIT Recognition Number</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['reco_no']; ?></td>
                    </tr>  
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">TANSIM Registration Number</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['pilots']; ?></td>
                    </tr>                  
                    <?php $register_date = isset($inv_ent_info[0]['org_reg_date']) && $inv_ent_info[0]['org_reg_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($inv_ent_info[0]['org_reg_date'])) : ''; ?>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Date of registration of your startup</td>
                        <td style="width:70%;"><?php echo $register_date; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td style="width:30%;"><b>Sector</b></td>
                        <td style="width:70%;"><?php echo $sector_name[0]['sector']; ?></td>
                    </tr>
                    <?php $sub_sectorname = $this->Sector_model->getSectorNameByID($inv_user[0]['sub_sector']); ?>
                    <tr>
                        <td style="width:30%;"><b>Sub Sector</b></td>
                        <td style="width:70%;"><?php echo $sub_sectorname; ?></td>
                    </tr>
                    <?php if($sector_name[0]['sub_sector_other'] != '') { ?>
                        <tr bgcolor="#f9f9f9">
                            <td style="width:30%;"><b>Specify</b></td>
                            <td style="width:70%;"><?php echo $sector_name[0]['sub_sector_other']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Where is your company based?</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['org_short_desc']; ?></td>
                    </tr>                    
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Corporate Identity Number</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['cin']; ?></td>
                    </tr> 
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">PAN Number</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['pan']; ?></td>
                    </tr>
                    <?php $state_list = $this->Minnovation->getStateName($inv_ent_info[0]['operate_on_state']); ?>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">State</td>
                        <td style="width:70%;"><?php echo $state_list; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">City</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['city']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Pin code</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['pincode']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Address</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['address']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Is your startup incubated/was incubated at any startup incubation center?</td>
                        <td style="width:70%;"><?php echo ucfirst($inv_ent_info[0]['tech_challege']); ?></td>
                    </tr>                                       
                    <?php if ($inv_ent_info[0]['tech_challege'] == 'yes') { ?>
                        <tr bgcolor="#f9f9f9">
                            <td class="bold-text">Provide the Incubation Center name</td>
                            <td style="width:70%;"><?php echo $inv_ent_info[0]['vill_support']; ?></td>
                        </tr>
                        <?php $inc_date = isset($inv_ent_info[0]['date_from_incubated']) && $inv_ent_info[0]['date_from_incubated'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($inv_ent_info[0]['date_from_incubated'])) : ''; ?>
                        <tr bgcolor="#f9f9f9">
                            <td class="bold-text">Date from which incubated</td>
                            <td style="width:70%;"><?php echo $inc_date; ?></td>
                        </tr>
                    <?php } ?>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Website URL</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['website_url']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Social media links</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['social_media']; ?></td>
                    </tr>
                </table>
                <div class="page_break"></div>
                <h1>Team Information</h1>
                <table width="100%">
                    <?php
                    $m = 1;
                    foreach ($inv_team as $member) {
                        ?>
                        <tr>
                            <td style="width:100%">
                                <table style="width:100%; margin-bottom: 20px;" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="width:30%;"><b>Name</b></td>
                                        <td style="width:70%;"><?php echo $member['mem_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;" valign='middle'><b>Gender</b></td>
                                        <td style="width:70%;"><?php echo ucfirst($member['mem_gender']); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;"><b>Designation</b></td>
                                        <td style="width:70%;"><?php echo $member['desig']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;"><b>Email</b></td>
                                        <td style="width:70%;"><?php echo $member['mem_email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;"><b>Mobile</b></td>
                                        <td style="width:70%;"><?php echo $member['mem_mobile']; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30%;" valign='middle'><b>Linkedin Profile</b></td>
                                        <td style="width:70%;"><?php echo ucfirst($member['linkedin_profile']); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php
                        $m++;
                    }
                    ?>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">What is your background?</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['type_prod']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">How long have you been working on your startup?</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['proposal_desc']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Does your team have a woman co-founder or CXO?</td>
                        <td style="width:70%;"><?php echo ucfirst($inv_ent_info[0]['stage_product']); ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">What is your current team size?</td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['team_size']; ?></td>
                    </tr>
                </table>
                <div class="page_break"></div>
                <h1>Startup Details</h1>
                <table width="100%">
                    <tr>
                        <td style="width:30%;"><b>Provide a short description/ elevator pitch of your startup</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['inno_desc']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Is yours a Technology Startup?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['inno_prob']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What is the problem you are solving and why are you focused on this?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['avail_alter']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What is your value proposition for this problem?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['prop_model']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What is your unique selling point?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['ident_risk']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What is your target customer segment?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['robot_efficient']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What is the market size of the opportunity?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['market_size']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Who are your key competitors and what is your competitive advantage?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['geographic']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>How do you aim to scale-up?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['scaleup']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What is your revenue model?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['business_model']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>How much is your company's monthly burn rate?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['competition_name']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What is your company's current product stage?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['product_stage']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What category best describes your business currently?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['business_category']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Briefly describe the key milestones your company has already achieved</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['estimate_qua']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Have you previously taken part in any pitch training? Please provide details</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['part_org']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Describe where you see your company in the next five years. What impact will you create?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['other_funding']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Video URL explaining the product and/or business model</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['video_url']); ?></td>
                    </tr>
                </table>
                <div class="page_break"></div>
                <h1>Funding Details</h1>
                <table width="100%">
                    <tr>
                        <td style="width:30%;"><b>Have you received monetary support under any Central or State government scheme? If yes,mention the scheme name and amount?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['central_state']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What was the initial investment put into your project?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['future_growth']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What investment are you looking for in the next 12 months and what will the funds be used for?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['investment_looking']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Any other funding details, if any</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['funding_details']); ?></td>
                    </tr>
                </table>
                <div class="page_break"></div>
                <h1>Other Information</h1>
                <table width="100%">
                    <tr>
                        <td style="width:30%;"><b>Why are you applying for the TANSEED program at Villgro?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['tanseed_program']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What are you most interested in learning more about?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['company_description']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What investment are you looking for in the next 12 months and what will the funds be used for?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['investment_looking']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Any other funding details, if any</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['funding_details']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>How did you hear about TANSEED?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['hear_abt']; ?></td>
                    </tr>
                    <?php
                    if ($add_info[0]['support_name'] != '') {
                        ?>
                        <tr>
                            <td style="width:30%;"><b>Name of organisation</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['support_name']; ?></td>
                        </tr>
                    <?php } ?>
                    <?php
                    if ($add_info[0]['referal_name'] != '') {
                        ?>
                        <tr>
                            <td style="width:30%;"><b>Referral By</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['referal_name']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <div class="page_break"></div>
                <h1>Upload Documents</h1>
                <table width="100%">                    
                    <tr>
                        <td style="width:30%;" valign='middle'><b>Uploaded Document</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['business_plan']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>DIPP certificate</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['add_info']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Incorporation Certificate</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['inv_idea_ent']; ?></td>
                    </tr>
                </table>
            </div>
        <?php } ?>
    </body>
    </html>
