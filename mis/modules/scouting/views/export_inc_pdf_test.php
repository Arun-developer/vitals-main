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
    <?php if (php72_cmp($inv_user[0]['application_type']) == 1 || php72_cmp($inv_user[0]['application_type']) == 24 || php72_cmp($inv_user[0]['application_type']) == 25 || php72_cmp($inv_user[0]['application_type']) == 26 || php72_cmp($inv_user[0]['application_type']) == 27 || $innovationDetails[0]['program'] == '21') {  ?>
        <div>
             <?php if($innovationDetails[0]['program'] == '11') { ?>
                <p class="title_text">SISFS Application</p>
            <?php }else if($innovationDetails[0]['program'] == '24') { ?>
                <p class="title_text">Sustainable Mobility Application</p>
			 <?php }else if($innovationDetails[0]['program'] == '25') { ?>
                <p class="title_text">MAPHealth (Market Access Partners for Healthcare) </p>
			 <?php }else if($innovationDetails[0]['program'] == '26') { ?>
                <p class="title_text">Powering Livelihoods </p>
			 <?php }else if($innovationDetails[0]['program'] == '21') { ?>
			 <p class="title_text">Empower </p>
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
				
				 <?php  if($innovationDetails[0]['program'] != '21'  && $innovationDetails[0]['program'] != '27' ){  ?>
					<?php $benificary = unserialize($inv_user[0]['benificiary']); ?>
					<tr>
						<td style="width:30%;"><b>Who will be the beneficiaries of your product / service?</b></td>
						<td style="width:70%;"><?php echo php72_implode(', ', $benificary); ?></td>
					</tr>
				<?php } ?>
				
				<?php if($innovationDetails[0]['program'] != '27' ){ ?>
					<tr>
						<td style="width:30%;"><b>What type of impact will your product / service have on the BoP / poor?</b></td>
						<td style="width:70%;"><?php echo $inv_user[0]['impact_of_product']; ?></td>
					</tr>
				<?php } ?>
                <tr>
                    <td style="width:30%;"><b>How long have you been in operation</b></td>
                    <td style="width:70%;">
					<?php
					  if($innovationDetails[0]['program'] == '27') { 
						switch ($inv_ent_info[0]['in_operation']) {
							case '0 – 6 months':
							echo "0 - 6 months";
							break;
							case '6 – 12 months':
							echo "6 - 12 months";
							break;
							case '1 year':
							echo "1 year";
							break;
							case '2 years':
							echo "2 years";
							break;
							case '2-5 years':
							echo "2-5 years";
							break;
							case '>5 years':
							echo ">5 years";
							break;
						}
						
					}else{
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
					}
					
					
                    ?>
					
					
					</td>
                </tr>
				
				<?php 
				#echo'<pre>';print_r($inv_user);die;

				if($innovationDetails[0]['program'] == '21' && php72_cmp($inv_user[0]['impact_of_product']) == 1  ){  ?>
					 <tr>
						<td style="width:30%;"><b>Provide your Company CIN. If you don’t have one, please write NA</b></td>
						<td style="width:70%;"><?php echo $inv_user[0]['cin_number'];  ?></td>
					</tr>
					
				<tr>
					<td class="bold-text">What is your team size</td>
					<td style="width:70%;"><?php echo $inv_ent_info[0]['team_size']; ?></td>
				</tr>
				  <?php  }  ?>
				 
				<?php  if($innovationDetails[0]['program'] != '21' && $innovationDetails[0]['program'] != '27'){  ?>
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
				
				<?php  } ?>
				
                <tr>
                    <td style="width:30%;"><b>Are you developing a</b></td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['develop_product']; ?></td>
                </tr>
                <tr>
                    <td style="width:30%;"><b>At what stage is your product / service</b></td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['stage_product']; ?></td>
                </tr>
				
				<?php  if($innovationDetails[0]['program'] == '27'){  ?>
					<tr>
						<td style="width:30%;"><b>What is your team size?</b></td>
						<td style="width:70%;"><?php echo $inv_ent_info[0]['team_size']; ?></td>
					</tr>
					<tr>
						<td class="bold-text">Number of full time employees</td>
						<td style="width:70%;"><?php echo $inv_ent_info[0]['startup_challenge']; ?></td>
					</tr>
					<tr>
						<td class="bold-text">Percentage of women in the team</td>
						<td style="width:70%;"><?php echo $inv_ent_info[0]['support_name']; ?></td>
					</tr>
				<?php  } ?>
				
				
                <tr>
                    <td style="width:30%;"><b>
					<?php  
						if($innovationDetails[0]['program'] != '21' && $innovationDetails[0]['impact_of_product'] != '1'  ){ 
							echo "Provide a brief description of your product or service";
						}else if($innovationDetails[0]['program'] == '27'){ 
							echo "Provide a brief description of your innovation (product or service)";
						}else{
						  echo"Provide a brief description of your innovation (product or service)";
						}


					?>
					
					</b></td>
                    <td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['inv_desc']); ?></td>
                </tr>
				
				
                <tr>
                    <td style="width:30%;"><b>
					<?php  
						if($innovationDetails[0]['program'] == '21' && $inv_user[0]['impact_of_product'] == '1'  ){ 
							echo "What was the motivation for you to start your business or why is this enterprise important to you";
						}else if($innovationDetails[0]['program'] == '27'){ 
							echo "What climate change problem does your innovation address?How does your solution mitigate this problem";
						}else{
						  echo"What problem does your innovation address?";
						}

					?></b></td>
                    <td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['inv_problem']); ?></td>
                </tr>
				
				
				<?php  if($innovationDetails[0]['program'] != '21' && $innovationDetails[0]['impact_of_product'] != '1'  ){  ?>
                <?php // if ($pitch_org[0]['fund'] == 'yes') { ?>
                    <tr>
                        <td style="width:30%;"><b>
						<?php  
						 if($innovationDetails[0]['program'] == '27'){ 
							echo "What are the available alternatives";
						}else{
						  echo"How is the need addressed without your innovation? What are the available alternatives?";
						}

					?>
						
						</b></td>
                        <td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['inv_alternatives']); ?></td>
                    </tr>
                    <?php // } ?>
                    <tr>
                        <td style="width:30%;"><b>
						<?php  
							if($innovationDetails[0]['program'] == '27'){  
								echo"Describe your business model";
							}else{
								echo"Describe your proposed / current business model";
							}
						?>

						</b></td>
                        <td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['proposal_desc']); ?></td>
                    </tr>
					<?php  } ?>
					
					
                    <tr>
                        <td style="width:30%;"><b>
						<?php  
						if($innovationDetails[0]['program'] == '21' && $inv_user[0]['impact_of_product'] == '1'  ){ 
							echo "What challenges have you identified in the business?";
						}else if($innovationDetails[0]['program'] == '27'){ 
						 echo"Do you have any customers";
						}else{
						  echo"What challenges / risks have you identified in the business?";
						}

					?>
						
						</b></td>
                        <td style="width:70%;"><?php echo nl2br($inv_ent_info[0]['inv_risks']); ?></td>
                    </tr>
					
					<?php  if($innovationDetails[0]['program'] == '27'){  ?>
					<tr>
						<td class="bold-text">How do you aim to scale up </td>
						<td style="width:70%;"><?php echo $inv_ent_info[0]['primary_point']; ?></td>
					</tr>

					<?php  } ?>
					
					 <?php  if($innovationDetails[0]['program'] != '21' && $innovationDetails[0]['impact_of_product'] != '1'  ){  ?>
                    <tr>
                        <td style="width:30%;"><b>
						<?php  
							if($innovationDetails[0]['program'] == '27'){ 
								echo"Who is the primary beneficiary of your product / service?";
							}else{
								echo"Who is the intended primary beneficiary of your product / service?";
							}
						?>
						
						</b></td>
                        <td style="width:70%;"><?php echo nl2br($inv_impact[0]['primary_benifi']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>
						<?php  
							 if($innovationDetails[0]['program'] == '27' ){ 
								echo "How do you quantitatively and qualitatively measure the social impact of your activity?";
							}else{
							  echo"Have you conducted research on your customer segments / run pilots?";
							}
						?>
						</b></td>
                        <td style="width:70%;"><?php echo ucfirst($inv_impact[0]['research_cus_seg']); ?></td>
                    </tr>
					<?php } ?>
					
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
					 <?php  if($innovationDetails[0]['program'] != '27' && $innovationDetails[0]['program'] != '21' && $innovationDetails[0]['impact_of_product'] != '1'  ){  ?>
                    <tr>
                        <td style="width:30%;"><b>How many people do you expect to impact through your innovation?</b></td>
                        <td style="width:70%;"><?php echo nl2br($inv_impact[0]['inv_impact']); ?></td>
                    </tr>
					 <?php } ?>
                    <tr>
                        <td style="width:30%;"><b>
						<?php  
						if($innovationDetails[0]['program'] == '21' && $inv_user[0]['impact_of_product'] == '1'  ){ 
							echo "How do you measure the qualitative and quantitative impact of your business?";
						}else if($innovationDetails[0]['program'] == '27' ){ 
							echo "How do you quantitatively and qualitatively measure the environmental impact of your activity?";
						}else{
						  echo"Will your product or service benefit other beneficiary groups? Describe these groups briefly.";
						}

					?>
					
					
						</b></td>
                        <td style="width:70%;"><?php echo nl2br($inv_impact[0]['others_benefit']); ?></td>
                    </tr>
					
					
					<?php  if($innovationDetails[0]['program'] == '27'){  ?>
					 <tr>
                        <td style="width:30%;"><b>Through the program, What areas of support do you require? Please indicate the Top 3 areas of support you would like from us:</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['business_model']; ?></td>
                    </tr>
					
					 <tr>
                        <td style="width:30%;"><b>If the acceleration program provides financial assistance support of 35L, how do you plan to utilise this?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['geographic']; ?></td>
                    </tr> 
					
					<tr>
                        <td style="width:30%;"><b>Selected enterprises will undergo due diligence in the form of physical site visits and requests on relevant information on the enterprise. Do you give your consent for the same?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['product_stage']; ?></td>
                    </tr>
					
					
					 <?php } ?>
					
					
					 <?php  if($innovationDetails[0]['program'] == '21' && $inv_user[0]['impact_of_product'] == '1'  ){  ?>
							<tr>
								<td style="width:30%;"><b>Why do you want to participate in this training programme? (Mark all that apply)</b></td>
								<td style="width:70%;"><?php echo $add_info[0]['investment_looking']; ?></td>
							</tr>
							<tr>
								<td style="width:30%;"><b>Others training programme</b></td>
								<td style="width:70%;"><?php echo $add_info[0]['target_beneficiary']; ?></td>
							</tr>
							
					 <?php  } ?>
					 
					 <?php if($innovationDetails[0]['program'] != '27'){ ?>
						<tr>
							<td style="width:30%;"><b>
							
							<?php  
								if( $innovationDetails[0]['program'] == '21' && $inv_user[0]['impact_of_product'] == '1'  ){ 
									echo "The programme is scheduled to conduct a virtual demo day and make other networking opportunities available to participating women entrepreneurs. Would you like to be considered for these opportunities";
								
								}else{
									echo "Please indicate the support you would like from us";
								}
							?></b></td>
							<td style="width:70%;"><?php echo str_replace(',', ', ', $add_info[0]['from_villgro']); ?></td>
						</tr>
					<?php  } ?>
					 <?php  if($innovationDetails[0]['program'] == '21' && $inv_user[0]['impact_of_product'] == '1'  ){  ?>
						 <tr>
							<td style="width:30%;"><b>This training program will consist of 15 hours of training and networking spread across 1 month. Please confirm your ability to make time for the same</b></td>
							<td style="width:70%;"><?php echo $add_info[0]['product_stage']; ?></td>
						</tr> 
						<tr>
							<td style="width:30%;"><b>One session will be scheduled every week starting from November 30th, 2023 to January 11, 2024 from 4 to 5:30 pm .Please confirm your availability for the same</b></td>
							<td style="width:70%;"><?php echo $add_info[0]['avail_alter']; ?></td>
						</tr>
						<tr>
							<td style="width:30%;"><b>Please confirm if you are comfortable with attending the sessions in English</b></td>
							<td style="width:70%;"><?php echo $add_info[0]['prop_model']; ?></td>
						</tr>
						
						
					<?php  } ?>
							
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
                        <td style="width:30%;"><b>
						<?php  
							if($innovationDetails[0]['program'] == '21' && $inv_user[0]['impact_of_product'] == '1'  ){ 
								echo "How did you hear about the 'EMPOWER Her Journey' program?";
							}else{
								echo "How did you come to know about us?";
							}
						?>
						
						</b></td>
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
					
					
					<?php  if($innovationDetails[0]['program'] == '21' && $inv_user[0]['impact_of_product'] == '1'  ){  ?>
						<tr>
							<td style="width:30%;"><b>Add your website link or links to any other additional information (Video URL/Youtube etc.)</b></td>
							<td style="width:70%;"><?php echo $add_info[0]['geographic']; ?></td>
						</tr>
						<?php  } ?>
					 <?php  if($innovationDetails[0]['program'] != '27' && $innovationDetails[0]['program'] != '21' && $innovationDetails[0]['impact_of_product'] != '1'  ){  ?>
                    <tr>
                        <td style="width:30%;"><b>Have you participated in or won any business plan competitions?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['won_competition']; ?></td>
                    </tr>
					 <?php } ?>
                    <?php if ($add_info[0]['won_competition'] == 'Yes') { ?>
                        <tr>
                            <td style="width:30%;"><b>Name of business plan competition(s)</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['competition_name']; ?></td>
                        </tr>
                    <?php } ?>
					 <?php  if($innovationDetails[0]['program'] != '21' && $innovationDetails[0]['impact_of_product'] != '1'  ){  ?>
                    <tr>
                        <td style="width:30%;" valign='middle'><b>Business plan's</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['business_plan']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Additional Information</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['add_info']; ?></td>
                    </tr>
					<?php } ?>
                </table>
            </div>
        <?php } else if (php72_cmp($inv_user[0]['application_type']) == 2) { ?>
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
        <?php } else if (php72_cmp($inv_user[0]['application_type']) == 3) { ?>
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
        <?php } else if (php72_cmp($inv_user[0]['application_type']) == 4) { ?>
            <div>
                <p class="title_text">YASH Application</p>
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
                        <td class="bold-text">Designation of the Applicant</td>
                        <td style="width:70%;"><?php echo $inv_user[0]['sub_sector_other']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Email</td>
                        <td style="width:70%;"><?php echo $inv_user[0]['email']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Mobile</td>
                        <td
                        style="width:70%;"><?php echo $inv_user[0]['mobile']; ?></td>
                    </tr>
                    <tr bgcolor="#f9f9f9">
                        <td class="bold-text">Alternate Mobile</td>
                        <td style="width:70%;"><?php echo $innovationDetails[0]['phone_no']; ?></td>
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
                                        <td style="width:30%;" valign='middle'><b>Gender</b></td>
                                        <td style="width:70%;"><?php echo ucfirst($member['mem_gender']); ?></td>
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
                                        <td style="width:30%;"><b>Linkedin Profile</b></td>
                                        <td style="width:70%;"><?php echo $member['linkedin_profile']; ?></td>
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
                        <td style="width:30%;"><b>Is your enterprise a</b></td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['entity']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Is your company registered under the Ministry of Corporate Affairs?</b></td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['org_short_desc']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>CIN Number</b></td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['cin']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Year of incorporation</b></td>
                        <td style="width:70%;"><?php echo $inv_ent_info[0]['reco_no']; ?></td>
                    </tr>
                    <?php 
                    $state_name = $this->Minnovation->getStateName($inv_ent_info[0]['operate_on_state']); 
                    $city_name = $this->Minnovation->getCityName($inv_ent_info[0]['city']);
                    ?>
                    <tr>
                        <td style="width:30%;"><b>Headquarter State/UT</b></td>
                        <td style="width:70%;"><?php echo $state_name; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Headquarter City</b></td>
                        <td style="width:70%;"><?php echo $city_name; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Sector</b></td>
                        <td style="width:70%;"><?php echo $sector_name[0]['sector']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Under which focus area are you applying?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['business_category']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Stage of Operation</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['robot_efficient']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>What would best describe your solution?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['best_describe']; ?></td>
                    </tr>
                    <?php if ($add_info[0]['best_describe_other'] != '') { ?>
                        <tr>
                            <td style="width:30%;"><b>If others, specify</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['best_describe_other']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="width:30%;"><b>What would best describe the nature of your solution?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['geographic']; ?></td>
                    </tr>
                    <?php if ($add_info[0]['investment_looking'] != '') { ?>
                        <tr>
                            <td style="width:30%;"><b>If others, specify</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['investment_looking']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="width:30%;"><b>Who are your target end beneficiaries?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['teb_located']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Where are your target end beneficiaries located?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['target_beneficiary']; ?></td>
                    </tr>
                    <?php if ($add_info[0]['teb_other'] != '') { ?>
                        <tr>
                            <td style="width:30%;"><b>If others, specify</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['teb_other']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="width:30%;"><b>
						<?php 
							if($innovationDetails[0]['program'] == '12') {
								echo "In which settings are your target end beneficiaries located?";
							}else{
								echo "What target group are you looking at?";
							}
						?>
						</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['support_name']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Who are your end users?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['scaleup']); ?></td>
                    </tr>
                    <?php if ($add_info[0]['end_user_other'] != '') { ?>
                        <tr>
                            <td style="width:30%;"><b>If others, specify</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['end_user_other']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="width:30%;"><b>How would you categorize your business model / revenue channel?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['business_model']); ?></td>
                    </tr>
                    <?php if ($add_info[0]['won_competition'] != '') { ?>
                        <tr>
                            <td style="width:30%;"><b>If others, specify</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['won_competition']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="width:30%;"><b>Briefly explain the problem that you are addressing</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['inno_desc']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>How is the problem currently being addressed?</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['inno_prob']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Describe how your solution addresses the problem</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['avail_alter']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Do you have a prototype?</b></td>
                        <td style="width:70%;"><?php echo ucfirst($add_info[0]['estimate_qua']); ?></td>
                    </tr>
                    <?php if ($add_info[0]['estimate_qua'] == 'Yes') { ?>
                        <tr>
                            <td style="width:30%;"><b>What is your existing solution?</b></td>
                            <td style="width:70%;"><?php echo nl2br($add_info[0]['part_org']); ?></td>
                        </tr>
                    <?php } ?>
					
					<?php if($innovationDetails[0]['program'] != '12') { ?>
						<tr>
							<td style="width:30%;"><b>How much time would you require to develop your prototype?</b></td>
							<td style="width:70%;"><?php echo nl2br($add_info[0]['about_ip']); ?></td>
						</tr>
					<?php } ?>
                    <tr>
                        <td style="width:30%;"><b>Revenue generated in last Financial Year</b></td>
                        <td style="width:70%;"><?php echo nl2br($add_info[0]['competition_name']); ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>Have you raised any funds?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['central_state']; ?></td>
                    </tr>
                    <?php if ($add_info[0]['central_state'] == 'Yes') { ?>
                        <tr>
                            <td style="width:30%;"><b>
							<?php 
								if($innovationDetails[0]['program'] == '12') {
									echo "Mention the amount raised with the split across grant, equity and debt";
								}else{
									echo "Mention the split in grant, equity and debt";
								}
							?>
							
							</b></td>
                            <td style="width:70%;"><?php echo nl2br($add_info[0]['ident_risk']); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="width:30%;"><b>Have you won a prize, recognition or award for your solution?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['add_info']; ?></td>
                    </tr>
                    <?php if ($add_info[0]['add_info'] == 'Yes') { ?>
                        <tr>
                            <td style="width:30%;"><b>Specify the details</b></td>
                            <td style="width:70%;"><?php echo nl2br($add_info[0]['other_funding']); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="width:30%;"><b>Would you like us to know any other information about your solution/ team?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['market_size']; ?></td>
                    </tr>
                    <tr>
                        <td style="width:30%;"><b>How did you come to know about us?</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['hear_abt']; ?></td>
                    </tr>
                    <?php
                    $hear_abt = explode(",", $add_info[0]['hear_abt']);
                    if (in_array('Other Mailers/Newsletter/Social media', $hear_abt)) {
                        ?>
                        <tr>
                            <td style="width:30%;"><b>Name of organisation</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['from_villgro']; ?></td>
                        </tr>
                    <?php } 
                    if (in_array('Referral', $hear_abt)) {
                        ?>
                        <tr>
                            <td style="width:30%;"><b>Name</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['referal_name']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td style="width:30%;" valign='middle'><b>
						<?php 
								if($innovationDetails[0]['program'] == '12') {
									echo"Document";
								}else{
									echo"Business plan's";
								}
						?>
						
						
						</b></td>
                        <td style="width:70%;"><?php echo $add_info[0]['business_plan']; ?></td>
                    </tr>
					
					<?php if($innovationDetails[0]['program'] != '12') { ?>
						<tr>
							<td style="width:30%;"><b>Are you interested to respond to this section?</b></td>
							<td style="width:70%;"><?php echo $add_info[0]['future_growth']; ?></td>
						</tr>
						<tr>
							<td style="width:30%;"><b>What is the % proportion of women employees in your company?</b></td>
							<td style="width:70%;"><?php echo $add_info[0]['current_product']; ?></td>
						</tr>
						<tr>
							<td style="width:30%;"><b>Does your solution directly impact women & girls?</b></td>
							<td style="width:70%;"><?php echo $add_info[0]['video_url']; ?></td>
						</tr>
						<tr>
							<td style="width:30%;"><b>What proportion (in %) of your existing customers are women?</b></td>
							<td style="width:70%;"><?php echo $add_info[0]['other_support_name']; ?></td>
						</tr>
						<tr>
							<td style="width:30%;"><b>Do you have any existing partnership with organizations led by women or who work with women (SHGs or FPOs)?</b></td>
							<td style="width:70%;"><?php echo $add_info[0]['other_support_name_ref']; ?></td>
						</tr>
					<?php } ?>
					
					
                    <?php if ($add_info[0]['other_support_name_ref'] == 'Yes') { ?>
                        <tr>
                            <td style="width:30%;"><b>Please provide details</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['ant_org_name']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        <?php }else if($innovationDetails[0]['program'] == '14' || $innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22' || $innovationDetails[0]['program'] == '23' ) { ?>
                  <p class="title_text"><?php if($innovationDetails[0]['program'] == '14'){ echo "Tvaran Application"; }else if($innovationDetails[0]['program'] == '21' ){ echo "Pragati Application";  }else if( $innovationDetails[0]['program'] == '22'){ echo  "Working Capital Loans for Social Enterprises"; }  ?></p>
               <?php if($innovationDetails[0]['program'] == '23') { ?>
					<p class="title_text">Shelter Tech </p> 
			  <?php } ?>
			<h1>Account Information</h1>
            <table width="100%">
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">Partner</td>
                    <td style="width:70%;"><?php echo ucfirst($innovationDetails[0]['branch_name']); ?></td>
                </tr>
				<?php if( $innovationDetails[0]['program'] == '23'){ ?>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">Innovation Id</td>
						<td style="width:70%;"><?php echo $inv_user[0]['inv_no']; ?></td>
					</tr>
				<?php } ?>
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text"><?php if( $innovationDetails[0]['program'] == '23'){ echo "Name of Enterprise"; }else { echo "Name of the organisation"; } ?></td>
                    <td style="width:70%;"><?php echo $inv_user[0]['ent_name']; ?></td>
                </tr>
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text"><?php if($innovationDetails[0]['program'] == '14'){ echo "Name of the woman founder/ co-founder"; }else if($innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22'){ echo "Name of the woman founder/ co-founder/ Senior executive";  }  ?> </td>
                    <td style="width:70%;"><?php echo $inv_user[0]['applicant_name']; ?></td>
                </tr>
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text"><?php if( $innovationDetails[0]['program'] == '23'){ echo "Qualification of the Entrepreneur";  }else { echo "Designation";  } ?> </td>
                    <td style="width:70%;"><?php echo $inv_user[0]['website']; ?></td>
                </tr>
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">Email</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['email']; ?></td>
                </tr>
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">Mobile</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['mobile']; ?></td>
                </tr>
				<?php if( $innovationDetails[0]['program'] == '23') { ?>
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">Registered Address</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['address1']; ?></td>
                </tr>
				
				<?php }else { ?>
				
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">Country</td>
					 <?php $country = $this->Minnovation->getCountryName($inv_user[0]['country']); ?>
                    <td style="width:70%;">
					<?php 
						if(!empty($country)){
							echo $country[0];
						}
					
					 ?></td>
                </tr> 
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">Address1</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['address2']; ?></td>
                </tr>
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">Address2</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['address2']; ?></td>
                </tr>
				<?php } ?>
				
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text"><?php if( $innovationDetails[0]['program'] == '23'){ echo  "Type of Organization"; }else { echo "Is your enterprise a"; } ?></td>
                    <td style="width:70%;"><?php echo $inv_user[0]['ent_type']; ?></td>
                </tr>
				<?php if( $innovationDetails[0]['program'] == '23') { ?>
					<tr bgcolor="#f9f9f9">
                    <td class="bold-text">Date of registration of your organisation </td>
                    <td style="width:70%;"><?php echo $dob_date = isset($inv_user[0]['dob']) && $inv_user[0]['dob'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($inv_user[0]['dob'])) : ''; ?></td>
                </tr>
				<?php }else { ?>

				<tr bgcolor="#f9f9f9">
                    <td class="bold-text"><?php if($innovationDetails[0]['program'] == '14'){ echo "Is your social enterprise headquartered in India"; }else if($innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22'){ echo "Is your enterprise headquartered in India";  }  ?></td>
                    <td style="width:70%;"><?php echo $inv_user[0]['india_based']; ?></td>
                </tr>
				<?php } ?>
				
				
				<?php if( $innovationDetails[0]['program'] == '23') { ?>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">Website URL  </td>
						<td style="width:70%;"><?php echo $inv_ent_info[0]['website_url'];  ?></td>
					</tr>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">PAN Number</td>
						<td style="width:70%;"><?php echo $inv_ent_info[0]['pan'];  ?></td>
					</tr>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">City</td>
						<td style="width:70%;"><?php echo $inv_ent_info[0]['city'];  ?></td>
					</tr>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">State</td>
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
					</tr>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">Pin code</td>
						<td style="width:70%;"><?php echo $inv_ent_info[0]['tech_challege'];  ?></td>
					</tr>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">Short description of your organisation</td>
						<td style="width:70%;"><?php echo $inv_ent_info[0]['startup_challenge'];  ?></td>
					</tr>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">Which geographies are you operational in</td>
						<td style="width:70%;"><?php echo $inv_ent_info[0]['support_name'];  ?></td>
					</tr>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">CIN number</td>
						<td style="width:70%;"><?php echo $inv_ent_info[0]['cin'];  ?></td>
					</tr>
					<tr bgcolor="#f9f9f9">
						<td class="bold-text">DPIIT Number</td>
						<td style="width:70%;"><?php echo $inv_ent_info[0]['primary_point'];  ?></td>
					</tr>
				<?php } ?>
				
				
				
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">Sector </td>
                    <td style="width:70%;"><?php echo $sector_name[0]['sector'];  ?></td>
                </tr>
				<tr bgcolor="#f9f9f9">
					<?php $sub_sectorname = $this->Sector_model->getSectorNameByID($inv_user[0]['sub_sector']); ?>
                    <td class="bold-text">Please select a Sub Sector </td>
                    <td style="width:70%;"><?php echo $sub_sectorname; ?></td>
                </tr>
				<?php if($innovationDetails[0]['program'] == '14'){ ?>  
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">Who will be the beneficiaries of your product / service </td>
                    <td style="width:70%;">
					 <?php $benificary = unserialize($inv_user[0]['benificiary']);
					 
							if(!empty($benificary)){
									echo php72_implode(', ',$benificary);
							}

					 ?></td>
                </tr>
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">Does your Product/Service impact the environment? </td>
                    <td style="width:70%;"><?php echo $inv_user[0]['product_service']; ?></td>
                </tr>
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">What type of impact will your product / service have on the environment</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['impact_product']; ?></td>
                </tr>
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">What type of impact will your product / service have on low-income populations</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['impact_of_product']; ?></td>
                </tr>
				
				<?php }?> 
				
               
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
            </table>
		
		 <div class="page_break"></div>
         <h1>
		 <?php if($innovationDetails[0]['program'] == '14'){ echo "Information about enterprise"; }else if($innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22'){ echo "About the Enterprise";  }else if($innovationDetails[0]['program'] == '23'){ echo "Enterprise Info"; }else { echo "About the Enterprise";  }  ?>  </h1>
		  <?php if( $innovationDetails[0]['program'] == '23') { ?>
		 <table width="100%">
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">Are you developing a</td>
				<td style="width:70%;"><?php echo ucfirst($inv_ent_info[0]['develop_product']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">What stage is your company in</td>
				<td style="width:70%;"><?php echo ucfirst($add_info[0]['hear_abt']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">Do you have Women in your founding team? If yes, please mention their name, and position in the company</td>
				<td style="width:70%;"><?php echo ucfirst($add_info[0]['business_model']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">Is your solution aligned with the Green construction or affordable housing industry</td>
				<td style="width:70%;"><?php echo ucfirst($inv_ent_info[0]['stage_product']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">Provide a brief description of your innovation (product or service)</td>
				<td style="width:70%;"><?php echo ucfirst($inv_ent_info[0]['inv_problem']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">What green construction/affordable housing problem does your innovation address</td>
				<td style="width:70%;"><?php echo ucfirst($inv_ent_info[0]['inv_alternatives']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">If you are involved in the development of green building materials, kindly indicate the certifications you have obtained, are currently pursuing, or intend to pursue? (GreenPro, GRIHA, BMTPC PACs, LCA, EPD, etc)</td>
				<td style="width:70%;"><?php echo ucfirst($inv_ent_info[0]['pilots']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">How is the need addressed without your innovation? What are the available alternatives</td>
				<td style="width:70%;"><?php echo ucfirst($inv_ent_info[0]['proposal_desc']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">Describe your proposed / current business model</td>
				<td style="width:70%;"><?php echo ucfirst($inv_ent_info[0]['inv_risks']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">What challenges / risks have you identified in the business</td>
				<td style="width:70%;"><?php echo ucfirst($inv_ent_info[0]['org_short_desc']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">Who is the intended primary beneficiary of your product / service</td>
				<td style="width:70%;"><?php echo ucfirst($add_info[0]['inno_prob']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">What will be the operational model? How do you make your operations robust and efficient</td>
				<td style="width:70%;"><?php echo ucfirst($add_info[0]['avail_alter']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">How much was your turnover (financial report) in the last 2 financial years? If your organisation is less than a year old, please answer</td>
				<td style="width:70%;"><?php echo ucfirst($add_info[0]['prop_model']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">What is the market size of the opportunity</td>
				<td style="width:70%;"><?php echo ucfirst($add_info[0]['ident_risk']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">How do you aim to scale-up</td>
				<td style="width:70%;"><?php echo ucfirst($add_info[0]['robot_efficient']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">Estimate quantitatively and qualitatively the social and/or environmental impact of your activity? Any insight into the impact indicators, the method of
calculation and the data collection will be preferable</td>
				<td style="width:70%;"><?php echo ucfirst($add_info[0]['market_size']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">Who are the key partners of your organisation? Mention all relevant stakeholders</td>
				<td style="width:70%;"><?php echo ucfirst($add_info[0]['geographic']); ?></td>
			</tr>
		 </table>

		<?php }else { ?>
		
		<?php if( $innovationDetails[0]['program'] == '23') { ?>

		<?php }else { ?>
		 
		 <table width="100%">
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">Name of enterprise</td>
				<td style="width:70%;"><?php echo ucfirst($inv_ent_info[0]['ent_name_info']); ?></td>
			</tr>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">How long have you been in operation</td>
				<td style="width:70%;"><?php echo $inv_ent_info[0]['in_operation']; ?></td>
			</tr>
		   
			<tr>
				<td class="bold-text">
				
					<?php if($innovationDetails[0]['program'] == '14'){ 
						echo "Provide Company CIN. If you don’t have one, write NA"; 
					}else if($innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22'){
						echo "Provide your Company CIN. If you don’t have one, please write NA";  

					}  ?>
				</td>
				<td style="width:70%;"><?php echo $inv_user[0]['cin_number']; ?></td>
			</tr>
			
			<tr>
				<td class="bold-text">
				<?php if($innovationDetails[0]['program'] == '14'){ 
						echo "In which states are you operating"; 
					}else if($innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22'){
						echo "In which states does the enterprise operate";  

					}  ?>
				
				</td>
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
				<td class="bold-text">Are you developing a</td>
				<td style="width:70%;"><?php echo $inv_ent_info[0]['develop_product']; ?></td>
			</tr><tr>
				<td class="bold-text">At what stage is your product / service</td>
				<td style="width:70%;"><?php echo $inv_ent_info[0]['stage_product']; ?></td>
			</tr>
			<tr>
				<td class="bold-text">What is your team size</td>
				<td style="width:70%;"><?php echo $inv_ent_info[0]['team_size']; ?></td>
			</tr>
			
			
			<?php if($innovationDetails[0]['program'] == '14'){ ?>  
				<tr>
					<td class="bold-text">Number of full time employees</td>
					<td style="width:70%;"><?php echo $inv_ent_info[0]['startup_challenge']; ?></td>
				</tr>
				<tr>
					<td class="bold-text">Percentage of women in the team</td>
					<td style="width:70%;"><?php echo $inv_ent_info[0]['support_name']; ?></td>
				</tr>
				<tr>
					<td class="bold-text">Is your enterprise women led - owned and controlled by a woman or a group of women having a minimum financial interest of 50% of capital in the startup</td>
					<td style="width:70%;"><?php echo $inv_user[0]['gender']; ?></td>
				</tr>
				<?php if ($inv_user[0]['gender'] == 'yes') {?>
					<tr>
						<td class="bold-text">Please upload supporting documents *(attach - jpeg,png,pdf)</td>
						<td style="width:70%;"><?php echo $inv_user[0]['supporting_doc']; ?></td>
					</tr>
				<?php } ?>
			<?php } ?>
			
		</table>
		
		
		<?php } ?>
		
		
		<?php } ?>

<?php if( $innovationDetails[0]['program'] != '23') { ?>   <div class="page_break"></div> <?php } ?>
		
			 <h1><?php if($innovationDetails[0]['program'] == '14'){ 
					echo "About the Business"; 
				}else if($innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22'){
					echo "About the Business model";  

				} else if($innovationDetails[0]['program'] == '23'){ 
						echo "Funding details";  
				}  ?>
		 </h1>
		 <?php if( $innovationDetails[0]['program'] == '23') { ?>
		 <table width="100%">
				<tr>
					<td class="bold-text">What amount of funding support have you received in the past (grant/equity/debt)</td>
					<td style="width:70%;"><?php echo $add_info[0]['company_description']; ?></td>
				</tr>
			</table>
		<?php }else { ?>
		
		
		 <table width="100%">
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">
				<?php if($innovationDetails[0]['program'] == '14'){ 
					echo "Provide a brief description of your innovation (product or service)s"; 
				}else if($innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22'){
					echo "Provide a brief description of your product or service";  

				}  ?>
				</td>
				<td style="width:70%;"><?php echo ucfirst($inv_ent_info[0]['inv_desc']); ?></td>
			</tr>
			<tr>
				<td class="bold-text">
				<?php if($innovationDetails[0]['program'] == '14'){ 
					echo "What climate change problem does your innovation address?How does your solution mitigate this problem"; 
				}else if($innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22'){
					echo "What was the motivation for you to start your business or why is this enterprise important to you";  

				}  ?>
				</td>
				<td style="width:70%;"><?php echo $inv_ent_info[0]['inv_problem']; ?></td>
			</tr>
			
			<?php if($innovationDetails[0]['program'] == '14'){ ?>  
			<tr>
				<td class="bold-text">What are the available alternatives</td>
				<td style="width:70%;"><?php echo $inv_ent_info[0]['inv_alternatives']; ?></td>
			</tr>
			<tr>
				<td class="bold-text">Describe your business model</td>
				<td style="width:70%;"><?php echo $inv_ent_info[0]['proposal_desc']; ?></td>
			</tr>
			<?php } ?>
			<tr>
				<td class="bold-text">
				<?php if($innovationDetails[0]['program'] == '14'){ 
					echo "What challenges / risks have you identified in the business"; 
				}else if($innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22'){
					echo "What challenges have you identified in the business";  

				}  ?>
				</td>
				<td style="width:70%;"><?php echo $inv_ent_info[0]['inv_risks']; ?></td>
			</tr>
			<?php if($innovationDetails[0]['program'] == '14'){ ?>  
				<tr>
					<td class="bold-text">Who are the key partners of your organisation? List them here</td>
					<td style="width:70%;"><?php echo $inv_ent_info[0]['vill_support']; ?></td>
				</tr>
			<?php } ?>
			<tr>
				<td class="bold-text"><?php if($innovationDetails[0]['program'] == '14'){ 
					echo "How do you aim to scale up"; 
				}else if($innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22'){
					echo "How do you aim to scale your business";  

				}  ?> </td>
				<td style="width:70%;"><?php echo $inv_ent_info[0]['primary_point']; ?></td>
			</tr>
		</table>
		 <?php } ?>
		 <?php if( $innovationDetails[0]['program'] != '23') { ?>
		 <div class="page_break"></div>
		 <?php } ?>
		<h1><?php if($innovationDetails[0]['program'] == '14'){ echo "Impact of innovation";  }else if($innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22'){ echo "Impact of the business";}else if($innovationDetails[0]['program'] == '23'){ echo "Support"; }  ?></h1>
		
		<?php if( $innovationDetails[0]['program'] == '23') { ?>
				 <table width="100%">
						<tr bgcolor="#f9f9f9">
							<td class="bold-text">How will this program support you in your future growth? What kind of support are you looking for from Villgro and Habitat for Humanity? (Market
partnerships, Follow-on-funding, etc)
</td>
							<td style="width:70%;"><?php echo ucfirst($add_info[0]['inv_idea_ent']); ?></td>
						</tr>
						<tr bgcolor="#f9f9f9">
							<td class="bold-text">What is your fund utilisation plan? Please also indicate a tentative timeline and budget for the same. (Eg: Product validation through necessary certification or on ground demonstration, business development, etc)</td>
							<td style="width:70%;"><?php echo ucfirst($add_info[0]['estimate_qua']); ?></td>
						</tr>
						
					</table>
		

				<?php }else { ?>
				
				
		<table width="100%">
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">
				<?php if($innovationDetails[0]['program'] == '14'){ 
					echo "Who is the primary beneficiary of your product / service"; 
				}else if($innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22'){
					echo "Who is the primary beneficiary of your product / service";  

				}  ?>
				</td>
				<td style="width:70%;"><?php echo ucfirst($inv_impact[0]['primary_benifi']); ?></td>
			</tr>
			<?php if($innovationDetails[0]['program'] == '14'){ ?>
			<tr>
				<td class="bold-text">Will your product or service benefit other beneficiary groups? Describe these groups briefly</td>
				<td style="width:70%;"><?php echo $inv_impact[0]['inv_impact']; ?></td>
			</tr>
			<?php }  ?>
			
			<tr>
				<td class="bold-text">
				<?php if($innovationDetails[0]['program'] == '14'){ 
					echo "How do you quantitatively and qualitatively measure the environmental impact of your activity"; 
				}else if($innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22'){
					echo "How do you measure the qualitative and quantitative impact of your business";  

				}  ?>
				</td>
				<td style="width:70%;"><?php echo $inv_impact[0]['others_benefit']; ?></td>
			</tr>
			<?php if($innovationDetails[0]['program'] == '14'){ ?>  
				<tr>
					<td class="bold-text">How do you quantitatively and qualitatively measure the social impact of your activity</td>
					<td style="width:70%;"><?php echo $inv_impact[0]['research_cus_seg']; ?></td>
				</tr>
			<?php }  ?>
			
		</table>
		 <?php } ?>
		
		<?php if($innovationDetails[0]['program'] == '14'){ ?>  
		<div class="page_break"></div>
         <h1>Support through the CISCO Acceleration Program</h1>
		 <table width="100%">
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">Why do you want to participate in the acceleration program</td>
				<td style="width:70%;"><?php echo ucfirst($add_info[0]['estimate_qua']); ?></td>
			</tr>
			<tr>
			<?php 
				  $villsupport = explode(',',$add_info[0]['business_model']);
				  $villsupport_txt ='';
				  if(!empty($villsupport)){
					$villsupport_txt = implode(', ',$villsupport);
				  }
			  ?>
			  
				<td class="bold-text">Through the program, Villgro aims to provide market access support to the enterprise. What areas of support do you require for market access? Please indicate the Top 3 areas of support you would like from us</td>
				<td style="width:70%;"><?php echo $villsupport_txt; ?></td>
			</tr><tr>
				<td class="bold-text">If the acceleration program provides grant support of 20L, how do you plan to utilise this</td>
				<td style="width:70%;"><?php echo $add_info[0]['geographic']; ?></td>
			</tr>
			<tr>
				<td class="bold-text">The program will provide access to CISCO’s technical experts & mentors. Briefly explain how you would be interested to engage with them during the program</td>
				<td style="width:70%;"><?php echo $add_info[0]['part_org']; ?></td>
			</tr>
		</table>
		<?php }  ?>
		
		<div class="page_break"></div>
         <h1>Additional Information</h1>
		 <table width="100%">
		 
		 <?php if( $innovationDetails[0]['program'] == '23') { ?>
			<tr>
				<td class="bold-text">Upload your latest pitch deck</td>
				<td style="width:70%;"><?php echo $add_info[0]['business_plan']; ?></td>
			</tr>
		<?php } ?>
		
		 
		 <?php if($innovationDetails[0]['program'] == '21'){?>  
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">
				Why do you want to participate in this training programme
				</td>
				<td style="width:70%;"><?php 
					$investment_looking_view = explode(',', $add_info[0]['investment_looking']);
					$k = 0;foreach ($investment_looking_view as $lists) {if ($k) {
						$listsValue = $lists;
						if($lists=='Other'){
							if($add_info[0]['target_beneficiary']!=''){
								 $listsValue = $listsValue."(".$add_info[0]['target_beneficiary'].")";
							}
						}
						echo ', ' .$listsValue;
					} else {
						echo $lists;
					}
					$k++; 
				}
	
			?></td>
			</tr>
		<?php }  ?>
			<?php if($innovationDetails[0]['program'] == '14' || $innovationDetails[0]['program'] == '21' ){  ?>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">
				<?php if($innovationDetails[0]['program'] == '14'){ 
					echo "The Program is scheduled to conduct the following physical events (tentative dates)* :
					Program Launch: A 1-day event to be scheduled in the week of Jan 16, 2023 to Jan 23, 2023, in Banglore
					Program Closing: A 1-day event to be scheduled in the week of Aug 1 2023 to Aug 8, 2023, in Delhi
					As these events are a critical aspect of the program, will you be available to attend the event in person"; 
				}else if($innovationDetails[0]['program'] == '21' || $innovationDetails[0]['program'] == '22'){
					echo "The programme is scheduled to conduct a virtual demo day and make other networking opportunities available to participating women entrepreneurs. Would you like to be considered for these opportunities";  

				}  ?>
				
				</td>
				<td style="width:70%;"><?php echo ucfirst($add_info[0]['from_villgro']); ?></td>
			</tr>
			<tr>
				<td class="bold-text">
				<?php if($innovationDetails[0]['program'] == '14'){ 
					echo "Selected enterprises will undergo due diligence in the form of physical site visits and requests on relevant information on the enterprise. Do you give your consent for the same"; 
				}else if($innovationDetails[0]['program'] == '21'){
					echo "This training program will consist of approximately 10-15 hours of training in English medium and networking spread across 1 month. Please confirm your ability to make time for the same";  

				}  ?>
				</td>
				<td style="width:70%;"><?php  
					if($innovationDetails[0]['program'] == '14'){ 
						echo ucfirst($add_info[0]['product_stage']); 
					}else if($innovationDetails[0]['program'] == '21'){
						if($add_info[0]['product_stage']){
							if($add_info[0]['product_stage'] =='Yes'){
								echo "I confirm";
							}
						}
					}
				
				?></td>
			</tr>
			<?php } ?>
			<?php if($innovationDetails[0]['program'] == '22'){  ?>
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">Amount of debt requirement (INR)
				</td>
				<td style="width:70%;"><?php echo ucfirst($add_info[0]['geographic']); ?></td>
			</tr>
			<tr>
				<td class="bold-text">Purpose of the loan
				</td>
				<td style="width:70%;"><?php echo ucfirst($add_info[0]['funding_details']); ?></td>
			</tr>
			
			<?php }  ?>
			
			<?php if($innovationDetails[0]['program'] == '21'){?>  
			<tr bgcolor="#f9f9f9">
				<td class="bold-text">
				Which months of the year suit you best for attending a virtual training programme? Please select all that apply
				</td>
				<td style="width:70%;"><?php 
					$funding_details_val = explode(',', $add_info[0]['funding_details']);
					$k = 0;foreach ($funding_details_val as $lists) {if ($k) {
						echo ', ' . $lists;
					} else {
						echo $lists;
					}
					$k++;}
	
			?></td>
			</tr>
		<?php }  ?>
		
			<?php if($innovationDetails[0]['program'] == '14' || $innovationDetails[0]['program'] == '21'){  ?>
			
			<tr>
				<td class="bold-text">
					<?php 
						if($innovationDetails[0]['program'] == '14'){ 
							echo "How did you hear about our program"; 
						}else if($innovationDetails[0]['program'] == '21'){
							echo "How did you hear about the EMPOWER program";  

						}  
					?>
				</td>
				<td style="width:70%;">
				<?php 
					$hearabout = explode(',', $add_info[0]['hear_abt']);
					$k = 0;foreach ($hearabout as $hear) {if ($k) {
						echo ', ' . $hear;
					} else {
						echo $hear;
					}
					$k++;}
				?>
				</td>
			</tr>
			<?php } ?>
			<?php if($innovationDetails[0]['program'] == '14' || $innovationDetails[0]['program'] == '21'){  ?>
			 <?php
				$hear_abt = explode(",", $add_info[0]['hear_abt']);
				if (in_array('Other', $hear_abt)) {
					?>
					<tr>
						<td style="width:30%;"><b>Name</b></td>
						<td style="width:70%;"><?php echo $add_info[0]['referal_name']; ?></td>
					</tr>
				<?php } ?>
			<tr>
				<td class="bold-text">
					<?php if($innovationDetails[0]['program'] == '14'){ 
						echo "Have you been incubated, funded or participated in an accelerator program with another organisation"; 
					}else if($innovationDetails[0]['program'] == '21'){
						echo "Have you been incubated, funded or participated in any virtual training programme with another organization";  

					}  ?>
				</td>
				<td style="width:70%;"><?php echo $add_info[0]['ant_org']; ?></td>
			</tr>
			<?php } ?>
			 <?php if ($add_info[0]['ant_org'] == 'Yes') {?>
			<tr>
				<td class="bold-text">Name of organization(s)</td>
				<td style="width:70%;"><?php echo $add_info[0]['ant_org_name']; ?></td>
			</tr>
			 <?php } ?>
			 
			 <?php if($innovationDetails[0]['program'] == '21'){ ?>  
				<tr>
					<td class="bold-text">Add your website link or links to any other additional information (Video URL/Youtube etc.)</td>
					<td style="width:70%;"><?php echo $add_info[0]['geographic']; ?></td>
				</tr>
			 <?php } ?>
			 <?php if($innovationDetails[0]['program'] == '14'){ ?>  
				<tr>
					<td class="bold-text">Have you won any CISCO grant in the past</td>
					<td style="width:70%;"><?php echo $add_info[0]['won_competition']; ?></td>
				</tr>
				<?php if ($add_info[0]['won_competition'] == 'Yes') {?>
				<tr>
					<td class="bold-text">Name of the grant</td>
					<td style="width:70%;"><?php echo $add_info[0]['competition_name']; ?></td>
				</tr>
				 <?php } ?>
				<tr>
					<td class="bold-text">Upload Business plan/ Pitch Deck </td>
					<td style="width:70%;"><?php echo $add_info[0]['business_plan']; ?></td>
				</tr>
				<tr>
					<td class="bold-text">Upload Additional Information (Video URL/Youtube, additional information) </td>
					<td style="width:70%;"><?php echo $add_info[0]['add_info']; ?></td>
				</tr>
			<?php } ?>
			
		</table>
		 <?php } ?>
		
    </body>
    </html>
