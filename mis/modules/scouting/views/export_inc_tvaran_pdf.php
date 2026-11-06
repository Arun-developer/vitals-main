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
    <?php if (php72_cmp($inv_user[0]['application_type']) == 30 ) {  ?>
        <div>
             <p class="title_text">Tvaran 2.0</p>
			 
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
                    <td class="bold-text">Gender</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['gender']; ?></td>
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
                    <td class="bold-text">Designation</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['website']; ?></td>
                </tr>
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">Type of registration</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['india_based']; ?></td>
                </tr>
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">Website Url</td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['website_url']; ?></td>
                </tr>
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">Registered Address</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['address1']; ?></td>
                </tr>
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">City</td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['city']; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>States</b></td>
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
				 <?php $country = $this->Minnovation->getCountryName($inv_user[0]['country']); ?>
                <tr>
                    <td class="bold-text">Country</td>
                    <td style="width:70%;"><?php echo $country[0]; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Sector</b></td>
                   
							<td style="width:70%;"><?php
							
							if($sector_name[0]['sector'] =='Education & Employability'){
								echo 'Agri or Agri allied'; 
							}if($sector_name[0]['sector'] =='Agri-business'){
								echo 'Dairy'; 
							}else if($sector_name[0]['sector'] =='Climate Action'){
								echo 'Textile'; 
							}else if($sector_name[0]['sector'] =='Health'){
								echo 'Art & Crafts'; 
							}else if($sector_name[0]['sector'] =='Others'){
								echo 'Others or Multi-sector'; 
							}
							?></td>
						
                </tr>
                <?php $sub_sectorname = $this->Sector_model->getSectorNameByID($inv_user[0]['sub_sector']); ?>
				
                <tr>
                    <td style="width:30%;"><b>Sub Sector</b></td>
                    <td style="width:70%;"><?php echo $sub_sectorname; ?></td>
                </tr>
				
				
				<tr>
                    <td class="bold-text">Short description of your organisation</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['mobile']; ?></td>
                </tr>
				
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">Short description of your organisation</td>
                    <td style="width:70%;"><?php echo $inv_user[0]['address2']; ?></td>
                </tr>
				<tr bgcolor="#f9f9f9">
                    <td class="bold-text">CIN number</td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['cin']; ?></td>
                </tr>
                <tr bgcolor="#f9f9f9">
                    <td class="bold-text">DPIIT Number</td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['primary_point']; ?></td>
                </tr>
				
				<tr>
                    <td style="width:30%;"><b>Geographies of Operation</b></td>
                    <td style="width:70%;"><?php
                    if ($inv_ent_info[0]['startup_challenge'] != '') {
                        $states = explode(',', $inv_ent_info[0]['startup_challenge']);
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
                              <!--   <tr>
                                    <td style="width:30%;"><b>Organization</b></td>
                                    <td style="width:70%;"><?php echo $member['mem_org']; ?></td>
                                </tr> -->
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
                    <td style="width:30%;"><b>Select the category of your application</b></td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['social_media']; ?></td>
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
                    <td style="width:30%;"><b>How long have you been in operation</b></td>
                     <td style="width:70%;"><?php
                    echo $inv_ent_info[0]['in_operation'];
                    ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Do you have Women in your founding team</b></td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['reco_no']; ?></td>
                </tr>
				 <?php if($inv_ent_info[0]['reco_no']=='Yes'){ ?>
				 <tr>
                    <td style="width:30%;"><b>Please mention their name, and position in the company</b></td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['entity_specify']; ?></td>
                </tr>
			 <?php } ?>
					
				<tr>
                    <td style="width:30%;"><b>Provide a brief description of your innovation</b></td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['inv_risks']; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Describe the technology in your solution</b></td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['inv_problem']; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>How is the need addressed without your innovation? What are the available alternatives</b></td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['proposal_desc']; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Describe your business model</b></td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['pilots']; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>What challenges / risks have you identified in the business?</b></td>
                    <td style="width:70%;"><?php echo $inv_ent_info[0]['org_short_desc']; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>Who are the key partners of your organisation? List them here</b></td>
                    <td style="width:70%;"><?php echo $add_info[0]['geographic']; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>How do you aim to scale-up?</b></td>
                    <td style="width:70%;"><?php echo $add_info[0]['robot_efficient']; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>What is the social impact created by your solution?</b></td>
                    <td style="width:70%;"><?php echo $inv_impact[0]['research_cus_seg']; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>How do you quantitatively and qualitatively measure the environmental impact of your activity?</b></td>
                    <td style="width:70%;"><?php echo $inv_impact[0]['others_benefit']; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>What amount of funding support have you received in the past (grant/equity/debt)</b></td>
                    <td style="width:70%;"><?php echo $add_info[0]['estimate_qua']; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>How will this program support you in your future growth</b></td>
                    <td style="width:70%;"><?php echo $add_info[0]['tanseed_program']; ?></td>
                </tr>
				
				<tr>
                    <td style="width:30%;"><b>The program aims to provide the below listed support. Please indicate the Top 3 areas of support you would like from us</b></td>
                    <td style="width:70%;"><?php echo $add_info[0]['business_model']; ?></td>
                </tr>
				<tr>
                    <td style="width:30%;"><b>If the acceleration program provides grant support of 30L, how do you plan to utilise this?</b></td>
                    <td style="width:70%;"><?php echo $add_info[0]['company_description']; ?></td>
                </tr>
				
				<tr>
                    <td style="width:30%;"><b>The program will provide access to CISCO’s technical experts & mentors. Briefly explain how you would be interested to engage with them during the program</b></td>
                    <td style="width:70%;"><?php echo $add_info[0]['part_org']; ?></td>
                </tr>
				
				<tr>
						<td class="bold-text">Have you won any CISCO grant in the past</td>
						<td style="width:70%;"><?php echo $add_info[0]['won_competition']; ?></td>
					</tr>
					<tr>

				<td class="bold-text">
					How did you hear about our program

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
			 <tr>
                            <td style="width:30%;"><b>Other Name</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['referal_name']; ?></td>
                        </tr>
						
						 <tr>
                            <td style="width:30%;"><b>Have you been incubated, funded or participated in an accelerator program with another organisation?</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['ant_org']; ?></td>
                        </tr> 
						
						<tr>
                            <td style="width:30%;"><b>Name of organization(s)</b></td>
                            <td style="width:70%;"><?php echo $add_info[0]['ant_org_name']; ?></td>
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
