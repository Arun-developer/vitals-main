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
    <?php if ($inv_user[0]['application_type'] == 32 ) {  ?>
        <div>
             <p class="title_text">Villgro Debt Access Program</p>
			 
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
				 <?php $country = $this->Minnovation->getCountryName($inv_user[0]['country']); ?>
                <tr>
                    <td class="bold-text">Country</td>
                    <td style="width:70%;"><?php echo $country[0]; ?></td>
                </tr>
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">Address 1</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['address1']; ?></td>
                </tr>
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">Address 2</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['address2']; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Sector</b></td>
                   
							<td style="width:70%;"><?php
							
							echo $sector_name[0]['sector'];
							?></td>
						
                </tr>
                <?php $sub_sectorname = $this->Sector_model->getSectorNameByID($inv_user[0]['sub_sector']); ?>
				
                <tr>
                    <td style="width:30%;"><b>Sub Sector</b></td>
                    <td style="width:70%;"><?php echo $sub_sectorname; ?></td>
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
                                    <td style="width:30%;"><b>Organization </b></td>
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
              
                <tr>
                    <td style="width:30%;"><b>Registered form of your entity</b></td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['develop_product']; ?></td>
                </tr>
				  <tr>
                    <td style="width:30%;"><b>Will your social enterprise be based in India</b></td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['stage_product']; ?></td>
                </tr> 
				<tr>
                    <td style="width:30%;"><b>At what stage is your product/service</b></td>
                    <td style="width:70%;"><?php echo $add_info[0]['business_model']; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>At what stage is your enterprise</b></td>
                     <td style="width:70%;"><?php
                    echo $add_info[0]['hear_abt'];
                    ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Provide a brief description of your product or service</b></td>
                     <td style="width:70%;"><?php
                    echo $inv_ent_info[0]['inv_problem'];
                    ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Who will be the beneficiaries of your product/service</b></td>
                     <td style="width:70%;"><?php
                    echo $inv_ent_info[0]['proposal_desc'];
                    ?></td>
                </tr>
				
				<tr>
                    <td style="width:30%;"><b> What type of impact will your product/service have on the BoP/poor</b></td>
                     <td style="width:70%;"><?php
                    echo $inv_ent_info[0]['inv_risks'];
                    ?></td>
                </tr>
				
				<tr>
                    <td style="width:30%;"><b>In which states are you operating/plan to operate</b></td>
                     <td style="width:70%;"><?php
                    echo $inv_ent_info[0]['org_short_desc'];
                    ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Amount of Debt Required</b></td>
                     <td style="width:70%;"><?php
                    echo $add_info[0]['inno_prob'];
                    ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Purpose/proposed use of funds raised through this program</b></td>
                     <td style="width:70%;"><?php
                    echo $inv_ent_info[0]['pilots'];
                    ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Have you previously accessed credit from any financial institution</b></td>
                     <td style="width:70%;"><?php
                    echo $add_info[0]['robot_efficient'];
                    ?></td>
                </tr>
				<?php if($add_info[0]['robot_efficient'] =='Yes'){ ?>
					<tr>
						<td style="width:30%;"><b>If yes, please mention the names of the financial institutions</b></td>
						 <td style="width:70%;"><?php
						echo $add_info[0]['avail_alter'];
						?></td>
					</tr>
				<?php  } ?>
				<tr>
                    <td style="width:30%;"><b>Have you been incubated, funded, or participated in an accelerator program with another organization</b></td>
                     <td style="width:70%;"><?php
                    echo $add_info[0]['prop_model'];
                    ?></td>
                </tr>
				<?php if($add_info[0]['prop_model'] =='Yes'){ ?>
					<tr>
						<td style="width:30%;"><b>If yes please mention the details</b></td>
						 <td style="width:70%;"><?php
						echo $add_info[0]['ident_risk'];
						?></td>
					</tr>
				<?php  } ?>
				
				
				
		</table>
		
		<div class="page_break"></div>
            <h1>More Information about the Startups</h1>
		<table>
			
				<tr>
                    <td style="width:30%;"><b>Does the company have an intentional focus on creating impact on underserved populations(rural, women, economically underprivileged) or the environment</b></td>
                     <td style="width:70%;"><?php
                    echo $add_info[0]['from_villgro'];
                    ?></td>
                </tr>
				
				<tr>
                    <td style="width:30%;"><b>Do the promoters and/or key managerial persons of the company have a minimum of 3 years of relevant past experience</b></td>
                     <td style="width:70%;"><?php echo $add_info[0]['support_name'];?></td>
                </tr>
				
				<tr>
                    <td style="width:30%;"><b>Does the company have at least one set of audited financials without any qualified opinions from the auditors, with operating revenues for 12 months</b></td>
                     <td style="width:70%;"><?php echo $add_info[0]['inv_idea_ent'];?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Is the company's monthly revenue at least INR 5 lakhs</b></td>
                     <td style="width:70%;"><?php echo $add_info[0]['referal_name'];?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>If yes, has your startup defaulted on any due loan repayments</b></td>
                     <td style="width:70%;"><?php echo $add_info[0]['central_state'];?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Does the company require funding to scale up operations and manage the working capital cycle</b></td>
                     <td style="width:70%;"><?php echo $add_info[0]['video_url'];?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Has the business raised equity funding in the past 2 years</b></td>
                     <td style="width:70%;"><?php echo $add_info[0]['won_competition'];?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Does the Company have a positive net worth (Net worth = Share capital + Accumulated</b></td>
                     <td style="width:70%;"><?php echo $add_info[0]['ant_org'];?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>In case the business is incurring losses on a monthly basis, does the company have a
minimum of 9 months' cash reserves to fund business operations and service the debt financing</b></td>
                     <td style="width:70%;"><?php echo $add_info[0]['ant_org_name'];?></td>
                </tr>
				
				<tr>
                    <td style="width:30%;"><b>Has the company/enterprise received confirmed orders from reputed client(s) and requires
funding for the purchase of raw materials or inventory</b></td>
                     <td style="width:70%;"><?php echo $add_info[0]['inc_cert'];?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>The company has no current overdues or past default write-offs and good repayment history
in the credit bureau report</b></td>
                     <td style="width:70%;"><?php echo $add_info[0]['competition_name'];?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Do all founders have a CIBIL score >650</b></td>
                     <td style="width:70%;"><?php echo $add_info[0]['other_funding'];?></td>
                </tr>
				
				<tr>
                    <td style="width:30%;"><b>Does the company have the ability to share MIS projections for at least 18 months, covering
details of revenues, expenses, and receivables</b></td>
                     <td style="width:70%;"><?php echo $add_info[0]['current_product'];?></td>
                </tr>
				<tr>
					<td class="bold-text">Upload Business plan/ Pitch Deck </td>
					<td style="width:70%;"><?php echo $add_info[0]['business_plan']; ?></td>
				</tr>
				<tr>
					<td class="bold-text">Upload Additional Information (Video URL/Youtube, additional information) </td>
					<td style="width:70%;"><?php echo $add_info[0]['add_info']; ?></td>
				</tr>

		
				
				
				
				
			
		</table>
		 <?php } ?>
		
    </body>
    </html>
