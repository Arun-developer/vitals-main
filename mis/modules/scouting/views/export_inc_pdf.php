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
    <div>
        <p class="title_text">Villgro CFA</p>
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
            <?php foreach ($inv_team as $member) { ?>
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
                            <tr>
                                <td style="width:30%;"><b>Linkedin Profile</b></td>
                                <td style="width:70%;"><?php echo $member['linkedin_profile']; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            <?php } ?>
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
            <tr>
                <td style="width:30%;"><b>How long have you been in operation</b></td>
                <td style="width:70%;">
                    <?php
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
                    ?>
                </td>
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
                    ?>
                </td>
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
                <td style="width:30%;"><b>Describe your proposed / current business model</b></td>
                <td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['proposal_desc']); ?></td>
            </tr>
            <tr>
                <td style="width:30%;"><b>Please elaborate on the product-market fit including targeted geographies.</b></td>
                <td style="width:70%;"><?php echo $add_info[0]['company_description']; ?></td>
            </tr>
            <tr>
                <td style="width:30%;"><b>Are you currently working with any government organization? If yes, please mention the details.</b></td>
                <td style="width:70%;"><?php echo $add_info[0]['inv_idea_ent']; ?></td>
            </tr>
            <tr>
                <td style="width:30%;"><b>What are the regulatory compliances and licenses required for the targeted geographies? List based on geographies</b></td>
                <td style="width:70%;"><?php echo $add_info[0]['prop_model']; ?></td>
            </tr>
            <tr>
                <td style="width:30%;"><b>What is the current stage of regulatory and procurement?</b></td>
                <td style="width:70%;"><?php echo $add_info[0]['ident_risk']; ?></td>
            </tr>
            <tr>
                <td style="width:30%;"><b>(Where applicable) What is the breakdown of the product's pricing? e.g., COGS , marketing, margins</b></td>
                <td style="width:70%;"><?php echo $add_info[0]['geographic']; ?></td>
            </tr>
            <tr>
                <td style="width:30%;"><b>What is the profitability outlook? </b></td>
                <td style="width:70%;"><?php echo $add_info[0]['future_growth']; ?></td>
            </tr>
            <tr>
                <td style="width:30%;"><b>Details of your current work with any government organization</b></td>
                <td style="width:70%;"><?php echo $add_info[0]['target_beneficiary']; ?></td>
            </tr>
            <tr>
                <td style="width:30%;"><b>What are your marketing KPIs and goals? Please provide for the next 2-3 years</b></td>
                <td style="width:70%;"><?php echo $add_info[0]['central_state']; ?></td>
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
</body>
</html>
