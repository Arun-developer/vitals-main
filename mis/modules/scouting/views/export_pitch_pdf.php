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
        table, th, td { padding: 0px; border: 1px solid black; text-align: left; word-wrap: break-word !important; height:auto !important;}
        th, td {font-size: 14px; padding: 10px; text-align: left;}
        .bold-text { font-weight: bold;}
        .page_break { page-break-before: always; }
        .title_text{font-weight:100; font-size:18px; padding:5px;text-align: center;color: #c41030;}
        img{width:100px;}
        .logo{text-align: right;}
    </style>
</head>
<body>
    <div class="logo">
        <img src="https://mis.villgroapps.org/mis_master/source/template/images/logo.png" alt="Villgro Logo" height="110" width="259"/>
    </div>
    <div>
        <?php if ($pitch_user[0]['application_type'] == 5) { ?>
        <p class="title_text">YSVF Application</p>
        <?php } else { ?>
        <p class="title_text">iPitch Application</p>
        <?php } ?>
        <h1>Account Information</h1>
        <table width="100%">
            <tr>
                <td class="bold-text" style="width:30%;">Name of the Organization</td>
                <td style="width:70%;"><?php echo $pitch_user[0]['org_name']; ?></td>
            </tr>
            <tr>
                <td class="bold-text" style="width:30%;">Name of the Applicant</td>
                <td style="width:70%;"><?php echo $pitch_user[0]['app_name']; ?></td>
            </tr>
            <tr>
                <td class="bold-text" style="width:30%;">Designation of the Applicant</td>
                <td style="width:70%;"><?php echo $pitch_user[0]['designation']; ?></td>
            </tr>
            <?php if ($pitch_user[0]['application_type'] != 5) { ?>
            <tr>
                <td class="bold-text" style="width:30%;">Gender</td>
                <td style="width:70%;"><?php echo ucfirst($pitch_user[0]['gender']); ?></td>
            </tr>
            <?php } ?>
            <?php if ($pitch_user[0]['application_type'] == 2) { ?>
            <tr>
                <td class="bold-text" style="width:30%;">Your enterprise registered as</td>
                <td style="width:70%;"><?php echo $pitch_user[0]['enterprise_registered_under']; ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td class="bold-text" style="width:30%;">Email</td>
                <td style="width:70%;"><?php echo $pitch_user[0]['email']; ?></td>
            </tr>
            <tr>
                <td class="bold-text" style="width:30%;">Mobile</td>
                <td style="width:70%;"><?php echo $pitch_user[0]['mobileno']; ?></td>
            </tr>
            <tr>
                <td class="bold-text" style="width:30%;">Alternate Mobile</td>
                <td style="width:70%;"><?php echo $pitch_user[0]['altmobileno']; ?></td>
            </tr>
            <?php if ($pitch_user[0]['application_type'] == 2) { ?>
            <tr>
                <td class="bold-text" style="width:30%;">Components of Your product / solution</td>
                <?php
                if ($pitch_user[0]['components'] != '') {
                $get_components = unserialize($pitch_user[0]['components']);
                $components = implode(', ', $get_components);
            } else {
            $components = '';
        }
        ?>
        <td style="width:70%;"><?php echo $components; ?></td>
    </tr>
    <tr>
        <td class="bold-text" style="width:30%;">Primary beneficiaries of your product / service</td>
        <?php
        if ($pitch_user[0]['beneficiary'] != '') {
        $get_beneficiary = unserialize($pitch_user[0]['beneficiary']);
        $beneficiary = implode(', ', $get_beneficiary);
    } else {
    $beneficiary = '';
}
?>
<td style="width:70%;"><?php echo $beneficiary; ?></td>
</tr>
<?php } ?>
</table>
<div class="page_break"></div>
<h1>Team Information</h1>
<table width="100%">
    <?php
    $m = 1;
    foreach ($pitch_member as $member) {
    ?>
    <tr>
        <td style="width:100%">
            <table style="width:100%; margin-bottom: 20px;" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="bold-text" style="width:30%;">Name</td>
                    <td style="width:70%;"><?php echo $member['name']; ?></td>
                </tr>
                <tr>
                    <td class="bold-text" style="width:30%;">Title</td>
                    <td style="width:70%;"><?php
                        if ($member['other_title'] != '') {
                        echo $member['cur_title'] . ' - ' . $member['other_title'];
                    } else {
                    echo $member['cur_title'];
                }
                ?></td>
            </tr>
            <tr>
                <td class="bold-text" style="width:30%;">Email</td>
                <td style="width:70%;"><?php echo $member['email']; ?></td>
            </tr>
            <tr>
                <td class="bold-text" style="width:30%;">Mobile</td>
                <td style="width:70%;"><?php echo $member['phone']; ?></td>
            </tr>
            <?php if ($pitch_user[0]['application_type'] == 5) { ?>
            <tr>
                <td class="bold-text" style="width:30%;" valign='middle'>Designation</td>
                <td style="width:70%;"><?php echo ucfirst($member['cur_org']); ?></td>
            </tr>
            <?php } else { ?>
            <tr>
                <td class="bold-text" style="width:30%;" valign='middle'>Gender</td>
                <td style="width:70%;"><?php echo ucfirst($member['gender']); ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td class="bold-text" style="width:30%;" valign='middle'>Age</td>
                <td style="width:70%;"><?php echo $member['age']; ?></td>
            </tr>
            <?php if ($pitch_user[0]['application_type'] != 5) { ?>
            <tr>
                <td class="bold-text" style="width:30%;" valign='middle'>Qualification</td>
                <td style="width:70%;"><?php echo $member['education_qualify']; ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td class="bold-text" style="width:30%;">LinkedIn</td>
                <td style="width:70%;"><?php echo $member['linkedin']; ?></td>
            </tr>
            <?php if ($pitch_user[0]['application_type'] == 5 && $m != 4 && $pitch_info[0]['applicant_type'] == 'Individual') { ?>
            <tr>
                <td class="bold-text" style="width:30%;">Institution</td>
                <td style="width:70%;"><?php echo $member['institute']; ?></td>
            </tr>
            <tr>
                <td class="bold-text" style="width:30%;">Institution Type</td>
                <td style="width:70%;"><?php echo $member['institute_type']; ?></td>
            </tr>
            <tr>
                <td class="bold-text" style="width:30%;">Institution Link</td>
                <td style="width:70%;"><?php echo $member['institute_link']; ?></td>
            </tr>
            <?php } ?>
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
    <tr>
        <td class="bold-text" style="width:30%;">Is there any team member who is between the age group 15 - 25 years?</td>
        <td style="width:70%;"><?php echo $pitch_info[0]['young_team']; ?></td>
    </tr>
    <?php if ($pitch_user[0]['application_type'] == 5) { ?>
    <tr>
        <td class="bold-text" style="width:30%;">Applicant Type</td>
        <td style="width:70%;"><?php echo $pitch_info[0]['applicant_type']; ?></td>
    </tr>
    <?php } ?>
    <?php
    if ($pitch_user[0]['application_type'] != 2) {
    if ($pitch_info[0]['ent_type'] == 'profit') {
    $ent_org = 'Profit Organization';
} else if ($pitch_info[0]['ent_type'] == 'nonprofit') {
$ent_org = 'Non-profit Organization';
} else if ($pitch_info[0]['ent_type'] == 'notapplicable') {
$ent_org = 'Applying as an individual';
}
?>
<tr>
    <td class="bold-text" style="width:30%;">Incubatee Based on</td>
    <td style="width:70%;"><?php echo $ent_org; ?></td>
</tr>
<?php } ?>
<tr>
    <td class="bold-text" style="width:30%;">Website</td>
    <td style="width:70%;"><?php echo $pitch_org[0]['website']; ?></td>
</tr>
<?php if ($pitch_user[0]['application_type'] == 5) { ?>
<tr>
    <td class="bold-text" style="width:30%;">Is your company registered as a legal entity?</td>
    <td style="width:70%;"><?php echo ucfirst($pitch_info[0]['company_register']); ?></td>
</tr>
<?php if ($pitch_info[0]['company_register'] == 'yes') { ?>
<tr>
    <td class="bold-text" style="width:30%;">If Yes, provide relevant Registration Number</td>
    <td style="width:70%;"><?php echo ucfirst($pitch_info[0]['cin_number']); ?></td>
</tr>
<?php } ?>
<tr>
    <td class="bold-text" style="width:30%;">Year of incorporation</td>
    <td style="width:70%;"><?php echo $pitch_org[0]['incorporation_year']; ?></td>
</tr>
<tr>
    <td class="bold-text" style="width:30%;">Country</td>
    <td style="width:70%;"><?php echo $pitch_info[0]['country']; ?></td>
</tr>
<tr>
    <td class="bold-text" style="width:30%;">State</td>
    <td style="width:70%;"><?php echo $pitch_info[0]['state_id']; ?></td>
</tr>
<tr>
    <td class="bold-text" style="width:30%;">City</td>
    <td style="width:70%;"><?php echo $pitch_info[0]['city_id']; ?></td>
</tr>
<?php } else { ?>
<tr>
    <td class="bold-text" style="width:30%;">Is your company registered under the MCA?</td>
    <td style="width:70%;"><?php echo ucfirst($pitch_info[0]['company_register']); ?></td>
</tr>
<?php if ($pitch_info[0]['company_register'] == 'yes') { ?>
<tr>
    <td class="bold-text" style="width:30%;">If Yes, CIN Number</td>
    <td style="width:70%;"><?php echo ucfirst($pitch_info[0]['cin_number']); ?></td>
</tr>
<?php } ?>
<?php } ?>
<?php if ($pitch_user[0]['application_type'] != 3 && $pitch_user[0]['application_type'] != 5) { ?>
<tr>
    <td class="bold-text" style="width:30%;">Year of incorporation</td>
    <td style="width:70%;"><?php echo $pitch_org[0]['incorporation_year']; ?></td>
</tr>
<tr>
    <td class="bold-text" style="width:30%;">DIPP Registration</td>
    <td style="width:70%;"><?php echo ucfirst($pitch_info[0]['dipp_register']); ?></td>
</tr>
<?php if ($pitch_info[0]['dipp_register'] == 'yes') { ?>
<tr>
    <td class="bold-text" style="width:30%;">If Yes, DIPP Number</td>
    <td style="width:70%;"><?php echo ucfirst($pitch_info[0]['dipp_number']); ?></td>
</tr>
<?php } ?>
<tr>
    <td class="bold-text" style="width:30%;">Management team composition: No. of Male</td>
    <td style="width:70%;"><?php echo $pitch_info[0]['male_numb']; ?></td>
</tr>
<tr>
    <td class="bold-text" style="width:30%;">Management team composition: No. of Female</td>
    <td style="width:70%;"><?php echo $pitch_info[0]['female_numb']; ?></td>
</tr>
<tr>
    <td class="bold-text" style="width:30%;">Management team composition: No. of Transgender</td>
    <td style="width:70%;"><?php echo $pitch_info[0]['transgender_numb']; ?></td>
</tr>
<tr>
    <td class="bold-text" style="width:30%;">Total number of Women Founders/Co-Founders with 50% or more ownership</td>
    <td style="width:70%;"><?php echo $pitch_info[0]['women_founder']; ?></td>
</tr>
<?php } ?>

<?php
if ($pitch_user[0]['application_type'] == 3) {
if ($pitch_org[0]['applying_stage'] == '1') {
$applying_stage = 'Affordable, easy to use solutions for early diagnosis of pregnancy';
} else if ($pitch_org[0]['applying_stage'] == '2') {
$applying_stage = 'Affordable and multi-parameter, ovulation monitoring and management solutions';
} else if ($pitch_org[0]['applying_stage'] == '3') {
$applying_stage = 'Easy and non-invasive diagnosis of Polycystic Ovary Syndrome (PCOS) among young girls';
} else if ($pitch_org[0]['applying_stage'] == '4') {
$applying_stage = 'Low cost, eco-friendly, easy to use solutions for dispensing and disposing of sanitary napkins';
} else if ($pitch_org[0]['applying_stage'] == '5') {
$applying_stage = 'Technology-driven solutions for providing multilingual comprehensive sexual education to youth';
} else if ($pitch_org[0]['applying_stage'] == '6') {
$applying_stage = 'Other';
}
?>
<tr>
    <td class="bold-text" style="width:30%;">Under which problem statement are you applying</td>
    <td style="width:70%;"><?php echo $applying_stage; ?></td>
</tr>
<?php } ?>
<?php if ($pitch_user[0]['application_type'] == 5) { ?>
<tr>
    <td class="bold-text" style="width:30%;">Under which problem statement are you applying?</td>
    <td style="width:70%;"><?php echo $pitch_org[0]['areas_other']; ?></td>
</tr>
<?php } ?>
<tr>
    <td class="bold-text" style="width:30%;">Stage of Operation</td>
    <td style="width:70%;"><?php echo $pitch_org[0]['operation_stage']; ?></td>
</tr>
<?php if ($pitch_user[0]['application_type'] != 5) { ?>
<?php $sector = unserialize(((isset($pitch_org[0]['sector'])) ? $pitch_org[0]['sector'] : "")); ?>
<tr>
    <td class="bold-text" style="width:30%;">Sector</td>
    <td style="width:70%;"><?php echo $sector[0]; ?></td>
</tr>
<?php if ($pitch_user[0]['application_type'] == 2) { ?>
<tr>
    <td class="bold-text" style="width:30%;">If you have tested your products with prospective users or have made sales, please mention details.</td>
    <td style="width:70%;"><?php echo $pitch_org[0]['product_test_details']; ?></td>
</tr>
<tr>
    <td class="bold-text" style="width:30%;">Over the last six months, how many units of your product have you sold/installed?</td>
    <td style="width:70%;"><?php echo $pitch_org[0]['product_units']; ?></td>
</tr>
<?php
}
if ($pitch_user[0]['application_type'] != 2) {
?>
<tr>
    <td class="bold-text" style="width:30%;">Sub Sector</td>
    <td style="width:70%;"><?php echo $subsector[0]['sector']; ?></td>
</tr>
<?php } ?>
<?php if ($pitch_user[0]['application_type'] != 3) { ?>
<tr>
    <td class="bold-text" style="width:30%;">SDGs that the innovation aligns with</td>
    <td style="width:70%;"><?php echo $sdg_align[0]['name']; ?></td>
</tr>
<tr>
    <td class="bold-text" style="width:30%;">Revenue of company: 2020-21</td>
    <td style="width:70%;"><?php echo $pitch_org[0]['fy_20_21']; ?></td>
</tr>
<tr>
    <td class="bold-text" style="width:30%;">Revenue of company: 2019-20</td>
    <td style="width:70%;"><?php echo $pitch_org[0]['fy_19_20']; ?></td>
</tr>
<tr>
    <td class="bold-text" style="width:30%;">Revenue of company: 2018-19</td>
    <td style="width:70%;"><?php echo $pitch_org[0]['fy_18_19']; ?></td>
</tr>
                            <!-- <tr>
                                <td class="bold-text" style="width:30%;">Revenue of company: 2017-18</td>
                                <td style="width:70%;"><?php echo $pitch_org[0]['fy_17_18']; ?></td>
                            </tr>
                            <tr>
                                <td class="bold-text" style="width:30%;">Revenue of company: 2016-17</td>
                                <td style="width:70%;"><?php echo $pitch_org[0]['fy_16_17']; ?></td>
                            </tr> -->
                            <?php if ($pitch_user[0]['application_type'] == 2) { ?>
                            <tr>
                                <td class="bold-text" style="width:30%;">Revenue of company: 2015-16</td>
                                <td style="width:70%;"><?php echo $pitch_org[0]['fy_15_16']; ?></td>
                            </tr>
                            <tr>
                                <td class="bold-text" style="width:30%;">Revenue of company: 2014-15</td>
                                <td style="width:70%;"><?php echo $pitch_org[0]['fy_14_15']; ?></td>
                            </tr>
                            <?php } ?>
                            <?php
                            if ($pitch_user[0]['application_type'] != 2) {
                            if ($pitch_org[0]['patents'] == '1') {
                            $patents = "Yes";
                        } else {
                        $patents = "No";
                    }
                    ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">Do you have any patents?</td>
                        <td style="width:70%;"><?php echo $patents; ?></td>
                    </tr>
                    <?php if ($pitch_org[0]['patents'] == '1') { ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">If Yes, what is the patent for:</td>
                        <td style="width:70%;"><?php echo ucfirst($pitch_org[0]['patent_desc']); ?></td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">Have you raised funding?</td>
                        <td style="width:70%;"><?php echo ucfirst($pitch_org[0]['past_fund']); ?></td>
                    </tr>
                    <?php if ($pitch_org[0]['past_fund'] == 'yes') { ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">Total Grant Amount</td>
                        <td style="width:70%;"><?php echo $pitch_org[0]['grant_amount']; ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">Total Equity Amount</td>
                        <td style="width:70%;"><?php echo $pitch_org[0]['equity_amount']; ?></td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <?php
                    if ($pitch_user[0]['application_type'] != 2) {
                    ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">Have you won a prize, recognition or award for your solution</td>
                        <td style="width:70%;"><?php echo ucfirst($pitch_org[0]['prize_recognition']); ?></td>
                    </tr>
                    <?php if ($pitch_org[0]['prize_recognition'] == 'yes') { ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">If yes, specify the details</td>
                        <td style="width:70%;"><?php echo $pitch_org[0]['awards']; ?></td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <?php if ($pitch_user[0]['application_type'] != 3) { ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">What kind of funding instruments are you looking for?</td>
                        <td style="width:70%;"><?php echo $pitch_add[0]['funding_instrument']; ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">Are you looking to raise debt funding in the next 6-12 months? If yes, how much?</td>
                        <td style="width:70%;"><?php echo $pitch_org[0]['raise_debt_fund']; ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">What is the range of funding that you are looking for?</td>
                        <td style="width:70%;"><?php echo $pitch_add[0]['funding_range']; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">Briefly explain the specific problem that your innovation addresses.</td>
                        <td style="width:70%;"><?php echo $pitch_org[0]['addr_problem']; ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">Describe your idea, product or service and how it addresses the problem.</td>
                        <td style="width:70%;"><?php echo $pitch_org[0]['quest_1']; ?></td>
                    </tr>
                    <?php if ($pitch_user[0]['application_type'] == 3) { ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">Do you have a prototype?</td>
                        <td style="width:70%;"><?php echo ucfirst($pitch_org[0]['prototype_solution']); ?></td>
                    </tr>
                    <?php if ($pitch_org[0]['prototype_solution'] == 'Yes') { ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">If yes, what is your existing solution?</td>
                        <td style="width:70%;"><?php echo $pitch_org[0]['prototype_yes']; ?></td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">If no, how much time would you require to develop your prototype?</td>
                        <td style="width:70%;"><?php echo $pitch_org[0]['prototype_no']; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">Will you be able to devote 7-10 hrs per week for an immersion program?</td>
                        <td style="width:70%;"><?php echo ucfirst($pitch_org[0]['immersion_program']); ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">Would you like us to know any other information about your solution/ team?</td>
                        <td style="width:70%;"><?php echo $pitch_org[0]['other_team_info']; ?></td>
                    </tr>
                    <?php } ?>
                    <?php if ($pitch_user[0]['application_type'] == 2) { ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">Describe your organization's inclusion strategies be it in the case of gender, marginalised communities, or other deprived sections of the society.</td>
                        <td style="width:70%;"><?php echo $pitch_org[0]['inclusion_strategy']; ?></td>
                    </tr>
                    <?php } ?>
                    <?php
                    if ($pitch_user[0]['application_type'] != 3) {
                    if ($pitch_user[0]['application_type'] != 2) {
                    ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">How is your solution for creating environmental, economic, or social impact through its operations</td>
                        <td style="width:70%;"><?php echo $pitch_org[0]['ent_impact']; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">Has your company been incubated / accelerated by any institution?</td>
                        <td style="width:70%;"><?php echo ucfirst($pitch_org[0]['accelerate_type']); ?></td>
                    </tr>
                    <?php if ($pitch_org[0]['accelerate_type'] == 'Yes') { ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">If yes, please provide the name of the incubator / accelerator and the year of participation.</td>
                        <td style="width:70%;"><?php echo $pitch_org[0]['incubated_accelerated']; ?></td>
                    </tr>
                    <?php } ?>
                    <?php } ?>

                    <?php if ($pitch_org[0]['sub_sector'] == '154' || $pitch_org[0]['sub_sector'] == '155') { ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">The Technology Readiness Level (TRL) of the proposed innovation</td>
                        <td style="width:70%;"><?php echo $pitch_add[0]['trl_innovation']; ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">Any existing partnerships and collaborations</td>
                        <td style="width:70%;"><?php echo $pitch_add[0]['partnerships_collaborations']; ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">The evidence generated through pilot studies to support your assumptions</td>
                        <td style="width:70%;"><?php echo $pitch_add[0]['pilot_studies']; ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">The potential of your solution to fit in the Indian Public Healthcare Infrastructure or Private Sector</td>
                        <td style="width:70%;"><?php echo $pitch_add[0]['solution_to_fit']; ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">The stage of clinical validation is your solution at</td>
                        <td style="width:70%;"><?php echo $pitch_add[0]['clinical_solution']; ?></td>
                    </tr>

                    <tr>
                        <td class="bold-text" style="width:30%;">The expected investment amount as against the total cost of the project</td>
                        <td style="width:70%;"><?php echo $pitch_add[0]['expected_investment_amount']; ?></td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                    <?php if ($pitch_user[0]['application_type'] == 5) { ?>
                    <tr>
                        <td class="bold-text" style="width:30%;">What would best describe your solution?</td>
                        <td style="width:70%;"><?php echo ucfirst($pitch_org[0]['describe_solution']); ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">If Other, please specify the details</td>
                        <td style="width:70%;"><?php echo ucfirst($pitch_org[0]['quest_2']); ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">Have you raised funds, won a prize, recognition or award for your solution?</td>
                        <td style="width:70%;"><?php echo ucfirst($pitch_org[0]['prize_recognition']); ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">If yes, specify the details</td>
                        <td style="width:70%;"><?php echo ucfirst($pitch_org[0]['awards']); ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">Briefly explain the problem that you are addressing.</td>
                        <td style="width:70%;"><?php echo ucfirst($pitch_org[0]['addr_problem']); ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">Describe how your solution addresses the problem.</td>
                        <td style="width:70%;"><?php echo ucfirst($pitch_org[0]['quest_1']); ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">Do you have a prototype? If yes, what is your existing solution?</td>
                        <td style="width:70%;"><?php echo ucfirst($pitch_org[0]['quest_3']); ?></td>
                    </tr>
                    <tr>
                        <td class="bold-text" style="width:30%;">Would you like us to know any other information about your solution/ team?</td>
                        <td style="width:70%;"><?php echo ucfirst($pitch_org[0]['quest_4']); ?></td>
                    </tr>
                    <?php } ?>


                    <?php
                    $aboutvill = explode(',', $pitch_org[0]['info_about_program']);
                    $aboutvill_om = explode(',', $pitch_org[0]['info_other_mailer']);
                    foreach ($aboutvill as $key => $value) {
                    if ($aboutvill[$key] == 'Other Mailers' && $pitch_org[0]['partner_name'] != '') {
                    $aboutvill[$key] = 'Other Mailers (' . $pitch_org[0]['partner_name'] . ')';
                } else if ($aboutvill[$key] == 'Past Incubatee' && $pitch_org[0]['inc_name'] != '') {
                $aboutvill[$key] = 'Past Incubatee (' . $pitch_org[0]['inc_name'] . ')';
            } else if ($aboutvill[$key] == ' Referral' && $pitch_org[0]['referral_name'] != '') {
            $aboutvill[$key] = 'Referral (' . $pitch_org[0]['referral_name'] . ')';
        } else if ($aboutvill[$key] == 'Member Association (MA)' && $additional_information[0]['inc_name'] != '') {
        $aboutvill[$key] = 'Member Association (' . trim($additional_information[0]['inc_name']) . ')';
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
<tr>
    <td class="bold-text" style="width:30%;">How did you come to know about us?</td>
    <td style="width:70%;"><?php echo $abtVill . $implode_info . '' . $other_org_name; ?></td>
</tr>
<tr>
    <td class="bold-text" style="width:30%;" valign='middle'>Document</td>
    <td style="width:70%;"><?php echo $pitch_doc[0]['doc1']; ?></td>
</tr>
                <!-- <tr>
                    <td class="bold-text" style="width:30%;">Document 2</td>
                    <td style="width:70%;"><?php echo $pitch_doc[0]['doc2']; ?></td>
                </tr> -->
                <?php if ($pitch_user[0]['application_type'] == 1) { ?>
                <tr>
                    <td class="bold-text" style="width:30%;">I am aware and give permission for my company profile to be automatically created on the Artha Platform</td>
                    <td style="width:70%;"><?php echo $pitch_org[0]['artha_platform']; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </body>
    </html>