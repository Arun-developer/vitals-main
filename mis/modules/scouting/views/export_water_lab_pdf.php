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
    <?php  if ($inv_user[0]['application_type'] == 37) {  ?>
        
		<div>
             <p class="title_text">Water Lab Application</p>
            <h1>Account Information</h1>
            <table width="100%">
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">Partner</td>
                    <td style="width:70%;"><?php echo ucfirst($innovationDetails[0]['branch_name']); ?></td>
                </tr>
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">
					 <?php
						 if($innovationDetails[0]['program'] == '21') { 
							echo"Name of Enterprise";
						 }else{
							echo "Name of Incubatee";
						 }
					 ?>
					</td>
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
                    <td class="bold-text">Registered Address</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['address1']; ?></td>
                </tr>
                <?php $country = $this->Minnovation->getCountryName($inv_user[0]['country']); ?>
                <tr>
                    <td class="bold-text">Country</td>
                    <td style="width:70%;"><?php echo $country[0]; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>State</b></td>
                    <td style="width:70%;"><?php
                    if ($inv_ent_info[0]['tech_challege'] != '') {
                        $states = explode(',', $inv_ent_info[0]['tech_challege']);
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
                    <td class="bold-text">Website url</td>
                      <td style="width:70%;"><?php echo $inv_ent_info[0]['website_url']; ?></td>
                </tr>
				<tr>
                    <td class="bold-text"> Is your enterprise a </td>
                    <td style="width:70%;"><?php echo $inv_user[0]['ent_type']; ?></td>
                </tr>
				<tr>
                    <td class="bold-text"> CIN Number </td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['cin']; ?></td>
                </tr>
				<tr>
                    <td class="bold-text"> DPIIT Number </td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['primary_point']; ?></td>
                </tr>
				<tr>
                    <td class="bold-text"> Will your social enterprise be based in India </td>
                    <td style="width:70%;"><?php echo $inv_user[0]['india_based']; ?></td>
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
					<td style="width:70%;"><?php echo php72_implode(', ', $benificary); ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>What type of impact will your product / service have on the BoP / poor?</b></td>
					<td style="width:70%;"><?php 
					
					$ben2 = unserialize($inv_user[0]['impact_of_product']); $k = 0; $word2=''; foreach($ben2 as $b) { if($k) $word2 .= ', '.$b; else $word2.= $b; $k++;}
				
					echo $word2;
					
				?></td>
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
                    <td style="width:30%;"><b>Geographies of Operation	</b></td>
                    <td style="width:70%;"> 
						<?php 
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
				   	<?php 
						$active_location = '';
						if($inv_ent_info[0]["startup_challenge"]!=''){
								$active_location = php72_implode(',', unserialize($inv_ent_info[0]["startup_challenge"]));
						}
					?>
                    <td style="width:30%;"><b>Please select if your solution is currently active in any of the following location</b></td>
                    <td style="width:70%;"><?php echo $active_location; ?></td>
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
				   	<?php 
						$org_short_desc = '';
						if($inv_ent_info[0]["org_short_desc"]!=''){
								$org_short_desc = php72_implode(',', unserialize($inv_ent_info[0]["org_short_desc"]));
						}
					?>
                    <td style="width:30%;"><b>Which solutions does your project align with</b></td>
                    <td style="width:70%;"><?php echo $org_short_desc; ?></td>
                </tr>
				<tr>
				   	<?php 
						$type_prod = '';
						if($inv_ent_info[0]["type_prod"]!=''){
								$type_prod = php72_implode(',', unserialize($inv_ent_info[0]["type_prod"]));
						}
					?>
                    <td style="width:30%;"><b>Which stages of the water value chain does your enterprise operate in</b></td>
                    <td style="width:70%;"><?php echo $type_prod; ?></td>
                </tr>
				<tr>
					<td style="width:30%;"><b>What problem does your innovation address</b></td>
					<td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['inv_problem']); ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>What is the role of technology in your innovation</b></td>
					<td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['inv_desc']); ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>How is the need addressed without your innovation? What are the available alternatives</b></td>
					<td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['inv_alternatives']); ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>Describe your proposed / current business and revenue model</b></td>
					<td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['proposal_desc']); ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>Do you have any patents or IPs:</b></td>
					<td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['reco_no']); ?></td>
				</tr>
				<?php  if($inv_ent_info[0]['reco_no']=='Yes'){ ?>
				<tr>
					<td style="width:30%;"><b>If yes, please provide information</b></td>
					<td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['pilots']); ?></td>
				</tr>
				<?php  } ?>
				<tr>
					<td style="width:30%;"><b>What challenges / risks have you identified in the business</b></td>
					<td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['inv_risks']); ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>Do you currently have any formal engagements with public sector entities</b></td>
					<?php 
						$social_media ='';
						if($inv_ent_info[0]['social_media']!=''){
							$social_media = php72_implode(',',unserialize($inv_ent_info[0]["social_media"]));
						}

					?>
					<td style="width:70%;"><?php echo $social_media; ?></td>
				</tr>
				
				<tr>
					<td style="width:30%;"><b>Have you conducted research on your customer segments / run pilots</b></td>
					<td style="width:70%;"><?php echo nl2br($inv_impact[0]['research_cus_seg']); ?></td>
				</tr>
				<?php if ($impC['research_cus_seg'] == 'yes') { ?>
					<tr>
						<td style="width:30%;"><b>What is the demographic profile of the primary beneficiary groups</b></td>
						<td style="width:70%;"><?php echo nl2br($inv_impact[0]['demographic_profie']); ?></td>
					</tr>
				<?php } ?>
				<tr>
					<td style="width:30%;"><b>What type of impact will your product / service have on the BoP (base of pyramid) / poor</b></td>
					<td style="width:70%;"><?php echo nl2br($inv_impact[0]['piloted_solutions']); ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>How do you quantitatively and qualitatively measure the Environmental Impact (and water saving measures) of your activity</b></td>
					<td style="width:70%;"><?php echo nl2br($inv_impact[0]['primary_benifi']); ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>How do you quantitatively and qualitatively measure the Social Impact of your activity</b></td>
					<td style="width:70%;"><?php echo nl2br($inv_impact[0]['avg_monthly']); ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>Will your product or service benefit other beneficiary groups? Describe these groups briefly</b></td>
					<td style="width:70%;"><?php echo nl2br($inv_impact[0]['inv_impact']); ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>Outline your expected impact in short term, medium term and long term</b></td>
					<td style="width:70%;"><?php echo nl2br($inv_impact[0]['others_benefit']); ?></td>
				</tr>
				
				<tr>
					<td style="width:30%;"><b>How will this funding amount of INR 25 Lakhs support the growth of your organization</b></td>
					<td style="width:70%;"><?php echo nl2br($add_info[0]['inc_cert']); ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>Selected enterprises will undergo due diligence in the form of physical site visits and requests on relevant information on the enterprise. Do you give your consent for the same</b></td>
					<td style="width:70%;"><?php echo nl2br($add_info[0]['company_description']); ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>Mention support</b></td>
						<td style="width:70%;"><?php echo $add_info[0]['support_name']; ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>Please indicate the priority areas of support you would like from us</b></td>
					<td style="width:70%;"><?php echo str_replace(',', ', ', $add_info[0]['from_villgro']); ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>How did you hear about our program</b></td>
					 <td style="width:70%;"><?php echo $add_info[0]['hear_abt']; ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>Name</b></td>
					 <td style="width:70%;"><?php echo $add_info[0]['referal_name']; ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>Have you been incubated, funded or participated in an accelerator program with another organization</b></td>
					 <td style="width:70%;"><?php echo $add_info[0]['ant_org']; ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>Name of organization(s)</b></td>
					 <td style="width:70%;"><?php echo $add_info[0]['ant_org_name']; ?></td>
				</tr>
				 <tr>
					<td style="width:30%;"><b>What amount of funding support have you received in the past</b></td>
					<td style="width:70%;"><?php echo $add_info[0]['won_competition']; ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>Business plan/ Pitch Deck</b></td>
					<td style="width:70%;"><?php echo $add_info[0]['business_plan']; ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>Upload any existing Partnerships Agreement Contract or Letter of Intent you have with Public Sector Entities</b></td>
					<td style="width:70%;"><?php echo $add_info[0]['add_info']; ?></td>
				</tr>
				<tr>
					<td style="width:30%;"><b>Upload Additional Information (Video URL/Youtube, additional information)</b></td>
					<td style="width:70%;"><?php echo $add_info[0]['part_org']; ?></td>
				</tr>
			
		</table>
		 <?php } ?>
		
    </body>
    </html>
