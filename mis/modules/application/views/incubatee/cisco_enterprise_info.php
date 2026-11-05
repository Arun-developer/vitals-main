<?php 


$this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $enterprise_information[0]['name_of_enterprise'] . ' - Enterprise Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $enterprise_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $enterprise_information[0]['name_of_enterprise'], 'app_stage' => $enterprise_information[0]['stage'], 'program' => $enterprise_information[0]['program'], 'doc1' => $enterprise_information[0]['doc1'], 'doc2' => $enterprise_information[0]['doc2'], 'doc3' => $enterprise_information[0]['doc3'])); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <?php /* <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">Enterprise</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">Impact</a></li>
								<?php if($enterprise_information[0]['program'] == '14') { ?>
								<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/about_business/' . $application_id; ?>">Business</a></li>
									<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/support_info/' . $application_id; ?>">Support</a></li>
								 <?php } ?>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
								 */?>
								 <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">
								<?php if($enterprise_information[0]['program'] == '21' || $enterprise_information[0]['program'] == '22'){
									echo "Team information";  
									}else{
										echo "Team";
									}  
								?></a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">
								<?php if($enterprise_information[0]['program'] == '21' || $enterprise_information[0]['program'] == '22'){
									echo "About the Enterprise";  
									}else if($enterprise_information[0]['program'] == '31'){
										echo "Enterprise &Innovation challenge";
									}else{
										echo "Enterprise";
									}  
								?></a></li>
								<?php if($enterprise_information[0]['program'] != '31'){ ?>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">
								<?php if($enterprise_information[0]['program'] == '21' || $enterprise_information[0]['program'] == '22'){
									echo "About the Business model";  
									}else if($enterprise_information[0]['program'] == '23'){
										echo "Funding details & Support";
									}else{
										echo "Impact";
									}  
								?></a></li>
								
								<?php }?>
								
								
								<?php if($enterprise_information[0]['program'] == '21' && date('Y-m-d', strtotime($enterprise_information[0]['created_date']))  >= date('2024-01-01')){ ?>
									
								<?php }else{ ?>
								
								<?php if($enterprise_information[0]['program'] == '14' || $enterprise_information[0]['program'] == '21' || $enterprise_information[0]['program'] == '22') { ?>
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/about_business/' . $application_id; ?>">
								<?php if($enterprise_information[0]['program'] == '21' || $enterprise_information[0]['program'] == '22'){
									echo "Impact of the business";  
									}else{
										echo "Business";
									}  
								?></a></li>
								<?php } ?>
								<?php } ?>
								
								
								
								<?php  if ($enterprise_information[0]['program'] != 21 && $enterprise_information[0]['program'] !=34  && $enterprise_information[0]['program'] != 22 && $enterprise_information[0]['program'] != 31 && $enterprise_information[0]['program'] != 23 && $enterprise_information[0]['program'] != 26 && $enterprise_information[0]['program'] != 27 && $enterprise_information[0]['program'] != 25 && $enterprise_information[0]['program'] != 34) {  ?>
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/support_info/' . $application_id; ?>">Support</a></li>
								<?php } ?>
								<?php  if ($enterprise_information[0]['program'] == 25 || $enterprise_information[0]['program'] == 34) {  ?>
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/gmt_info/' . $application_id; ?>">GTM related information </a></li>
								<?php } ?>
								
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
								
                            </ul>
                        </div>
                    </div>
                </div>
                 <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane userActiveSetupNew active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="enterpriseForm" action="<?php echo base_url() . 'index.php/application/add_enterprise_details'; ?>" autocomplete="off">
                                    <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                    <input type="hidden" name="inv_user_id" value="<?= $enterprise_information[0]['inv_user_id']; ?>">
                                    <?php if($enterprise_information[0]['program'] == '12') { ?>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Year of incorporation</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['reco_no']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Headquarter State/UT</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['state_name']; ?>" disabled />
                                                </div>
                                            </div>
                                            <?php 
												$city_name ='';
												if(isset($enterprise_information[0]['city']) && $enterprise_information[0]['city']!=''){
													$city_name = $this->Minnovation->getCityName($enterprise_information[0]['city']);
												}
											?>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Headquarter City</label>
                                                    <input type="text" class="form-control" value="<?= $city_name; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Is your company registered under the Ministry of Corporate Affairs?</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['org_short_desc']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>CIN Number</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['cin']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Stage of Operation</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['robot_efficient']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>   
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>What would best describe your solution?</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['best_describe']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>If others, specify</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['best_describe_other']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>What Target Group are you looking at?</label>
                                                    <input type="text" class="form-control" value="<?= ucfirst($enterprise_information[0]['support_name']); ?>" disabled />
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Does your company have a website?</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['proposal_desc']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>What would best describe the nature of your solution?</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['geographic']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>If others, specify</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['investment_looking']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Who are your target end beneficiaries?</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['teb_located']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Where are your target end beneficiaries located?</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['target_beneficiary']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>If others, specify</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['teb_other']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Is Your Enterprise a</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['entity']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Who are your end users?</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['scaleup']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>If others, specify</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['end_user_other']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>How would you categorize your business model / revenue channel?</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['business_model']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>If others, specify</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['won_competition']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
									<?php if($enterprise_information[0]['program'] == '14' || $enterprise_information[0]['program'] == '25' || $enterprise_information[0]['program'] == '34' || $enterprise_information[0]['program'] == '26' || $enterprise_information[0]['program'] == '21' || $enterprise_information[0]['program'] == '22' || $enterprise_information[0]['program'] == '27') { ?>
											<div class="row">
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>Name of enterprise<span>*</span></label>
														<input type="text" class="form-control" value="<?= $enterprise_information[0]['ent_name_info']; ?>" disabled />
													</div>
												</div>
												<div class="col-12 col-lg-6 col-md-6 leaveLabel">
													<div class="form-group">
														<label>Are you developing a<span>*</span></label>
														<?php $operation_val = $enterprise_information[0]['in_operation']; ?>
														<select class="form-control fieldDisable" disabled id="in_operation" name="in_operation">
															<option value="">--Select--</option>
															<option value="0to6" <?php
															if ($enterprise_information[0]['develop_product'] == 'Product') {
																echo 'selected';
															}
															?>>Product</option>
															<option value="6to12" <?php
															if ($enterprise_information[0]['develop_product'] == 'Service') {
																echo 'selected';
															}
															?>>Service</option>
															<option value="1" <?php
															if ($enterprise_information[0]['develop_product'] == 'Both') {
																echo 'selected';
															}
															?>>Both</option>
														</select>
													</div>
													<div id="state_err"></div>
												</div>
											</div>
										<?php } ?>
										<?php  if ($enterprise_information[0]['program'] == 23 || $enterprise_information[0]['program'] == 31) {  ?>
										
										  <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Are you developing a</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['develop_product']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>What stage is your company in</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['hear_abt']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Do you have Women in your founding team? If yes, please mention their name, and position in the compan</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['business_model']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
										
										<div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>
													<?php 
													
														if ($enterprise_information[0]['program'] != 31){
															echo "Do you already have a tech-based mobility solution";
														}else{
															echo "Is your solution aligned with the Green construction or affordable housing industry";
														}
													?>
													
													
													</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['stage_product']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Provide a brief description of your innovation (product or service)</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['inv_problem']; ?>" disabled />
                                                </div>
                                            </div>
											<?php if ($enterprise_information[0]['program'] != 31){ ?>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>What green construction/affordable housing problem does your innovation address</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['inv_alternatives']; ?>" disabled />
                                                </div>
                                            </div>
											<?php  } ?>
                                        </div>
										<div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>
													<?php 
													
															if ($enterprise_information[0]['program'] == 31){
																echo "Describe your proposed solution for the Enroute: A Mobility as a Service Challenge.";
															}else{
																echo "If you are involved in the development of green building materials, kindly indicate the certifications you have obtained, are currently pursuing, or intend
to pursue? (GreenPro, GRIHA, BMTPC PACs, LCA, EPD, etc)";
															}

														?>
													
													
													
													</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['pilots']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>How is the need addressed without your innovation? What are the available alternatives</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['proposal_desc']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Describe your proposed / current business model</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['inv_risks']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
										
										<div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>What challenges / risks have you identified in the business</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['org_short_desc']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Who is the intended primary beneficiary of your product / service</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['inno_prob']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>
													
													<?php 
													
															if ($enterprise_information[0]['program'] == 31){
																echo "Why do you want to participate in this challenge";
															}else{
																echo "What will be the operational model? How do you make your operations robust and efficient";
															}

														?>
														
													
													</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['avail_alter']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
										
										
										<div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>
													<?php 
													
															if ($enterprise_information[0]['program'] == 31){
																echo "What makes your team uniquely qualified to address the challenge";
															}else{
																echo "How much was your turnover (financial report) in the last 2 financial years? If your organisation is less than a year old, please answer";
															}

														?>
														
														
													</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['prop_model']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>
													
													<?php 
													
															if ($enterprise_information[0]['program'] == 31){
																echo "Any additional information you would like to provide";
															}else{
																echo "What is the market size of the opportunity";
															}

														?>
														
														
														
													</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['ident_risk']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>
													
													<?php 
													
															if ($enterprise_information[0]['program'] == 31){
																echo "Are you willing to develop a solution and pilot the same with metro and bus services in Bangalore city";
															}else{
																echo "How do you aim to scale-up";
															}

														?>
														
														
													
													</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['robot_efficient']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
										<?php if($enterprise_information[0]['program'] != '31'){ ?>
										<div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Estimate quantitatively and qualitatively the social and/or environmental impact of your activity? Any insight into the impact indicators, the method of
calculation and the data collection will be preferable
</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['market_size']; ?>" disabled />
                                                </div>
                                            </div>
											
											<?php if ($enterprise_information[0]['program'] != 31){ ?>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>
													
													Who are the key partners of your organisation? Mention all relevant stakeholders
</label>
                                                    <input type="text" class="form-control" value="<?= $enterprise_information[0]['geographic']; ?>" disabled />
                                                </div>
                                            </div>
											<?php } ?>
											
                                        </div>
										<?php } ?>
										
										
										<?php }else{ ?>
										
										
                                        <div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>How long have you been in operation<span>*</span></label>
                                                    <?php $operation_val = $enterprise_information[0]['in_operation']; ?>
                                                    <select class="form-control fieldDisable" disabled id="in_operation" name="in_operation">
                                                        
														<option value="">--Select--</option>
														
														<?php if($enterprise_information[0]['program'] == '27'){ ?>
														<option value="0to6" <?php
															if ($enterprise_information[0]['in_operation'] == '0 – 6 months') {
																echo 'selected';
															}
															?>>0 – 6 months</option>
															<option value="6 – 12 months" <?php
															if ($enterprise_information[0]['in_operation'] == '6 – 12 months') {
																echo 'selected';
															}
															?>>6 – 12 months</option>
															<option value="1 year" <?php
															if ($enterprise_information[0]['in_operation'] == '1 year') {
																echo 'selected';
															}
															?>>1 year </option>
															<option value="2 years" <?php
															if ($enterprise_information[0]['in_operation'] == '2 years') {
																echo 'selected';
															}
															?>>2 years </option>
															<option value="2-5 years" <?php
															if ($enterprise_information[0]['in_operation'] == '2-5 years') {
																echo 'selected';
															}
															?>>2-5 years </option>
															<option value=">5 years" <?php
															if ($enterprise_information[0]['in_operation'] == '>5 years') {
																echo 'selected';
															}
															?>>>5 years</option>
														<?php } else{ ?>
															<option value="0to6" <?php
															if ($enterprise_information[0]['in_operation'] == '0to6') {
																echo 'selected';
															}
															?>>0 – 6 months</option>
															<option value="6to12" <?php
															if ($enterprise_information[0]['in_operation'] == '6to12') {
																echo 'selected';
															}
															?>>6 – 12 months</option>
															<option value="1" <?php
															if ($enterprise_information[0]['in_operation'] == '1') {
																echo 'selected';
															}
															?>>1 year </option>
															<option value="2" <?php
															if ($enterprise_information[0]['in_operation'] == '2') {
																echo 'selected';
															}
															?>>2 years </option>
															<option value="2-5 years" <?php
															if ($enterprise_information[0]['in_operation'] == '2-5 years') {
																echo 'selected';
															}
															?>>2-5 years </option>
															<option value=">5 years" <?php
															if ($enterprise_information[0]['in_operation'] == '>5 years') {
																echo 'selected';
															}
															?>>>5 years</option>
														<?php } ?>
														
														
                                                    </select>
                                                </div>
                                            </div>
											<?php if($enterprise_information[0]['program'] != '14' &&  ($enterprise_information[0]['program'] == '21' && trim($enterprise_information[0]['impact_of_product']) != '1')){ ?>
												
												<div class="col-12 col-lg-6 col-md-6 leaveLabel">
													<div class="form-group">
														<label>
														
														<?php if($enterprise_information[0]['program'] == '14'){ 
															echo "In which states are you operating / plan to operate"; 
														}else if($enterprise_information[0]['program'] == '21' || $enterprise_information[0]['program'] == '22'){
															echo "In which states does the enterprise operate";  

														}  ?>
														
														<span>*</span></label>
														<?php
														if ($enterprise_information[0]['operate_on_state'] != '') {
															$states = explode(',', $enterprise_information[0]['operate_on_state']);
															$state_list = '';
															foreach ($states as $state) {
																if ($state_list != '')
																	$state_list = $state_list . ', ' . $this->Minnovation->getStateName($state);
																else
																	$state_list = $this->Minnovation->getStateName($state);
															}
														}
														?>
														<select id="select_state" class="multiselect" multiple="multiple" name="select_state[]" ></select>
														<!--<select class="form-control" multiple name="select_state[]" id="select_state" ></select>-->
													</div>
													<div id="state_err"></div>
												</div>
											<?php } ?>
											
											<?php if($enterprise_information[0]['program'] == '14' || $enterprise_information[0]['program'] == '25' || $enterprise_information[0]['program'] == '34' || $enterprise_information[0]['program'] == '26') { ?>
												<div class="col-12 col-lg-6 col-md-6 leaveLabel">
													<div class="form-group">
														<label>In which states are you operating / plan to operate<span>*</span></label>
														<?php
														if ($enterprise_information[0]['operate_on_state'] != '') {
															$states = explode(',', $enterprise_information[0]['operate_on_state']);
															$state_list = '';
															foreach ($states as $state) {
																if ($state_list != '')
																	$state_list = $state_list . ', ' . $this->Minnovation->getStateName($state);
																else
																	$state_list = $this->Minnovation->getStateName($state);
															}
														}
														?>
														<select id="select_state" class="multiselect" multiple="multiple" name="select_state[]" ></select>
														<!--<select class="form-control" multiple name="select_state[]" id="select_state" ></select>-->
													</div>
													<div id="state_err"></div>
												</div>
											<?php } ?>
                                        </div>
										
										<?php } ?>
										<?php if($enterprise_information[0]['program'] != '14' && $enterprise_information[0]['program'] != '31'&& $enterprise_information[0]['program'] != '25' && $enterprise_information[0]['program'] != '26' && $enterprise_information[0]['program'] != '27' && $enterprise_information[0]['program'] != '21' && $enterprise_information[0]['program'] != '23') { ?>
                                        <div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Have you been incubated, funded or participated in an accelerator program with another organization?<span>*</span></label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="with_other_org" id="with_other_org1" value="Yes" <?php if ($enterprise_information[0]['ant_org'] == 'Yes') echo "checked=checked"; ?>  onclick="show_org(this.value);">
                                                        <label class="form-check-label" for="with_other_org1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="with_other_org" id="with_other_org2" value="No" <?php if ($enterprise_information[0]['ant_org'] == 'No') echo "checked=checked"; ?>  onclick="show_org(this.value);">
                                                        <label class="form-check-label" for="with_other_org2">No</label>
                                                    </div>
                                                    <label for="with_other_org" class="error"></label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Have you participated in or won any business plan competitions?<span>*</span></label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="competition" id="competition1" value="Yes" <?php if ($enterprise_information[0]['won_competition'] == 'Yes') echo "checked=checked"; ?> onclick="show_compet(this.value);">
                                                        <label class="form-check-label" for="competition1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="competition" id="competition2" value="No" <?php if ($enterprise_information[0]['won_competition'] == 'No') echo "checked=checked"; ?> onclick="show_compet(this.value);">
                                                        <label class="form-check-label" for="competition2">No</label>
                                                    </div>
                                                    <label for="competition" class="error"></label>
                                                </div>
                                            </div>
                                        </div> <?php } ?>
										
										<?php if($enterprise_information[0]['program'] == '14' || $enterprise_information[0]['program'] == '25' || $enterprise_information[0]['program'] == '34' || $enterprise_information[0]['program'] == '26' || $enterprise_information[0]['program'] == '21' || $enterprise_information[0]['program'] == '22' || $enterprise_information[0]['program'] == '27') { ?>
										 <div class="row">
                                            
											<?php if($enterprise_information[0]['program'] != '26' && $enterprise_information[0]['program'] != '25' &&  $enterprise_information[0]['program'] != '34'){ ?>
											<div class="col-12 col-lg-6 col-md-6">
                                               <div class="form-group" id="other_org" <?= $org_display_field; ?>>
													<label>
													<?php if($innovationDetails[0]['program'] == '14' ||  $innovationDetails[0]['program'] == '27'){ 
														echo "Provide Company CIN. If you don’t have one, write NA"; 
													}else if($innovationDetails[0]['program'] == '21'){
														echo "Provide your Company CIN. If you don’t have one, please write NA";  

													}  ?>
													
													<span>*</span></label>
													<input type="text" disabled name="other_org_name" class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['cin_number']; ?>"/>
												</div>
                                            </div>
										<?php } ?>
                                            <!--<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Have you participated in or won any business plan competitions?<span>*</span></label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="competition" id="competition1" value="Yes" <?php if ($enterprise_information[0]['won_competition'] == 'Yes') echo "checked=checked"; ?> onclick="show_compet(this.value);">
                                                        <label class="form-check-label" for="competition1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="competition" id="competition2" value="No" <?php if ($enterprise_information[0]['won_competition'] == 'No') echo "checked=checked"; ?> onclick="show_compet(this.value);">
                                                        <label class="form-check-label" for="competition2">No</label>
                                                    </div>
                                                    <label for="competition" class="error"></label>
                                                </div>
                                            </div> -->
											<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>At what stage is your product / service<span>*</span></label>
														 <select class="form-control fieldDisable" disabled id="stage_prod" name="stage_prod">
													
														 
														 <?php if($enterprise_information[0]['program'] == '25' || $enterprise_information[0]['program'] == '34'){  ?>
															<option value="Idea" <?php echo ($enterprise_information[0]["stage_product"]=="Idea")?"selected":"";?>>Idea</option>
															<option value="Proof of concept" <?php echo ($enterprise_information[0]["stage_product"]=="Proof of concept")?"selected":"";?>>Proof of concept</option>
															<option value="Prototype development" <?php echo ($enterprise_information[0]["stage_product"]=="Prototype development")?"selected":"";?>>Prototype development</option>
															<option value="Prototype testing" <?php echo ($enterprise_information[0]["stage_product"]=="Prototype testing")?"selected":"";?>>Prototype testing</option>
															<option value="Technical pilot" <?php echo ($enterprise_information[0]["stage_product"]=="Technical pilot")?"selected":"";?>>Technical pilot</option>
															<option value="Commercial pilot" <?php echo ($enterprise_information[0]["stage_product"]=="Commercial pilot")?"selected":"";?>>Commercial pilot</option>
															<option value="Production" <?php echo ($enterprise_information[0]["stage_product"]=="Production")?"selected":"";?>>Production</option>
															<option value="Growth" <?php echo ($enterprise_information[0]["stage_product"]=="Growth")?"selected":"";?>>Growth</option>
															<option value="Scaling" <?php echo ($enterprise_information[0]["stage_product"]=="Scaling")?"selected":"";?>>Scaling</option>
														<?php }else { ?>
														
															<option value="">-Select</option>
															<option value="Proof of concept" <?php echo ($enterprise_information[0]['stage_product']=="Proof of concept")?"selected":"";?>>Proof of concept</option>
															<option value="Prototype development" <?php echo ($enterprise_information[0]['stage_product']=="Prototype development")?"selected":"";?>>Prototype development</option>
															<option value="Prototype testing" <?php echo ($enterprise_information[0]['stage_product']=="Prototype testing")?"selected":"";?>>Prototype testing</option>
															<option value="Technical pilot" <?php echo ($enterprise_information[0]['stage_product']=="Technical pilot")?"selected":"";?>>Technical pilot</option>
															<option value="Commercial pilot" <?php echo ($enterprise_information[0]['stage_product']=="Commercial pilot")?"selected":"";?>>Commercial pilot</option>
															<option value="Early sales / Production" <?php echo ($enterprise_information[0]['stage_product']=="Early sales / Production")?"selected":"";?>>Early sales / Production</option>
															<option value="Consistent sales / Growth" <?php echo ($enterprise_information[0]['stage_product']=="Consistent sales / Growth")?"selected":"";?>>Consistent sales / Growth</option>
															<option value="Scaling" <?php echo ($enterprise_information[0]['stage_product']=="Scaling")?"selected":"";?>>Scaling</option>
														<?php } ?>
														
														</select>
														
														
													</div>
												</div>
                                        </div>
										<?php } ?>
										
										<?php if($enterprise_information[0]['program'] != '14' && $enterprise_information[0]['program'] != '25' &&  $enterprise_information[0]['program'] == '34' && $enterprise_information[0]['program'] != '26' && $enterprise_information[0]['program'] != '27'  && $enterprise_information[0]['program'] != '21') { ?>
											<?php
											$org_display_field = 'style="display:none"';
											$com_display_field = 'style="display:none"';
											if ($enterprise_information[0]['ant_org'] == 'Yes') {
												$org_display_field = 'style="display:block"';
											}
											if ($enterprise_information[0]['won_competition'] == 'Yes') {
												$com_display_field = 'style="display:block"';
											}
											?>
											<div class="row">
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group" id="other_org" <?= $org_display_field; ?>>
														<label>Name of organization(s)<span>*</span></label>
														<input type="text" disabled name="other_org_name" class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['ant_org_name']; ?>"/>
													</div>
												</div>
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group" id="bus_compet" <?= $com_display_field; ?>>
														<label>Name of business plan competition(s)<span>*</span></label>
														<input type="text" disabled name="business_compet" class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['competition_name']; ?>"/>
													</div>
												</div>
											</div>
										<?php } ?>
										
										<?php if($enterprise_information[0]['program'] == '21' || $enterprise_information[0]['program'] == '22'  || $enterprise_information[0]['program'] == '27' ) { ?>
										
										 <div class="row">
												<div class="col-12 col-lg-6 col-md-6 leaveLabel">
													<div class="form-group">
														<label>What is your team size<span>*</span></label>
														 <input type="text" class="form-control" value="<?= $enterprise_information[0]['team_size']; ?>" disabled />
													</div>
													<div id="state_err"></div>
												</div>
											</div>
										<?php } ?>
										<?php if($enterprise_information[0]['program'] == '14' || $enterprise_information[0]['program'] == '27'  ) { ?>
											 <div class="row">
												<div class="col-12 col-lg-6 col-md-6 leaveLabel">
													<div class="form-group">
														<label>What is your team size<span>*</span></label>
														 <input type="text" class="form-control" value="<?= $enterprise_information[0]['team_size']; ?>" disabled />
													</div>
													<div id="state_err"></div>
												</div>
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<div class="form-group">
														<label>Number of full time employees<span>*</span></label>
														 <input type="text" class="form-control" value="<?= $enterprise_information[0]['startup_challenge']; ?>" disabled />
													</div>
													<div id="state_err"></div>
													</div>
												</div>
											</div>
											<div class="row">
												
												<div class="col-12 col-lg-6 col-md-6 leaveLabel">
													<div class="form-group">
														<label>Percentage of women in the team<span>*</span></label>
														 <input type="text" class="form-control" value="<?= $enterprise_information[0]['support_name_ent']; ?>" disabled />
													</div>
													<div id="state_err"></div>
												</div>
											
											</div>
											
											<?php if($enterprise_information[0]['program'] != '27') { ?>
										<div class="row">
											
												<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Is your enterprise women led - owned and controlled by a woman or a group of women having a minimum financial interest of 50% of capital in the startup<span>*</span></label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="gender" id="gender" value="yes" <?php if ($enterprise_information[0]['gender'] == 'yes') echo "checked=checked"; ?>  onclick="show_org(this.value);">
                                                        <label class="form-check-label" for="with_other_org1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="gender" id="gender" value="no" <?php if ($enterprise_information[0]['gender'] == 'no') echo "checked=checked"; ?>  onclick="show_org(this.value);">
                                                        <label class="form-check-label" for="with_other_org2">No</label>
                                                    </div>
                                                    <label for="gender" class="error"></label>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
												<div class="text-right">
													<span class="clr-red">*</span>Supports only jpeg,png,pdf	
												</div>
                                                <div class="form-group">
                                                    <label></label>
                                                    <div class="fileUpload clearfix blue-btn btn width100">
                                                        <?php
                                                        if (isset($enterprise_information[0]['supporting_doc']) && !empty($enterprise_information[0]['supporting_doc'])) {
                                                            $info_truncate = strlen($enterprise_information[0]['supporting_doc']) > 20 ? "..." . substr($enterprise_information[0]['supporting_doc'], -20) : $enterprise_information[0]['supporting_doc'];
                                                            ?>
                                                            <span><?= $info_truncate; ?></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span><i class="fas fa-upload"></i> Upload</span>
                                                        <?php } ?>
                                                        <input disabled type="file" class="uploadlogo" name="info_file" id="info_file" />
                                                        <input disabled type="hidden" name="old_info_file" id="old_info_file" value="<?php echo isset($enterprise_information[0]['supporting_doc']) ? $enterprise_information[0]['supporting_doc'] : ''; ?>" />
                                                    </div>
                                                    <?php if (isset($enterprise_information[0]['supporting_doc']) && !empty($enterprise_information[0]['supporting_doc'])) { ?>
                                                        <span class="download-btn"><a href="<?php echo host_url() . 'cisco/uploads/' . $enterprise_information[0]['supporting_doc']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                    <?php } ?>
                                                    <label class="sow_msg error" id="info_file_error"></label>
                                                    <div class="clearfix"></div>
                                                  
                                                    <label for="competition" class="error"></label>
                                                </div>
                                            </div>
										</div>
										<?php } ?>
											
											
										<?php } ?>
                                    <?php } ?>
                                    <div class="row ">
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView display-hide">
                                                    <li><input type="submit" value="Save" id="saveForm" class="vital_yellow_btn wdt_100"></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </main>
                    </div>
                </div>
           </main>
        </div>
    </div>
</div>
</div>
</div>

<style type="text/css">
    .ui-multiselect.ui-helper-clearfix.ui-widget {
        width: 100% !important;
    }
  
    .ui-multiselect.ui-helper-clearfix.ui-widget .selected .selected.connected-list.ui-sortable,.ui-multiselect.ui-helper-clearfix.ui-widget .available .available.connected-list{
        width: 100% !important;
    }
	.userActiveSetupNew .ui-multiselect {
    border: 1px solid #ffffff !important;
}
	.available{
		display:none;
	}
	.ui-icon-minus{
		display:none!important;
	} 
	 .ui-multiselect.ui-helper-clearfix.ui-widget .selected,.ui-multiselect.ui-helper-clearfix.ui-widget .available{
        width: 70% !important;
    }
	
	
</style>

<?php $this->load->view('vitals_footer.php', array('load_application' => 'application', 'page_load' => 'drag_multiselect')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        get_userLists();

        $(".ui-multiselect").width(550);
        $(".ui-multiselect > .available").width(274);
        $('.leaveLabel').css("cursor", "not-allowed");
        $('.leaveLabel').css("pointer-events", "none");

    });

    function show_org(value) {
        if (value == 'Yes') {
            $("#other_org").css('display', 'block');
        } else {
            $("#other_org").css('display', 'none');
        }
    }

    function show_compet(value) {
        if (value == 'Yes') {
            $("#bus_compet").css('display', 'block');
        } else {
            $("#bus_compet").css('display', 'none');
        }
    }

    $('.summaryEdit').click(function () {
        $(".fieldDisable").attr("disabled", false);
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').addClass("display-show");
        $('.saveLinkView').removeClass("display-hide");
        $(".multiselect").attr("disabled", false);
        $('.leaveLabel').css("cursor", "pointer");
        $('.leaveLabel').css("pointer-events", "");
    });

    function get_userLists() {
        var inv_user_id = "<?= $enterprise_information[0]['inv_user_id']; ?>";
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('application/load_state_list_cisco'); ?>",
            data: {'inv_user_id': inv_user_id},
            success: function (response) {
                var options = '';
                if (response.all_states == '' && response.ext_state == null) {
                    options = '<option value=""> Select </option>';
                    $("#select_state").html('');
                    $('#select_state').multiselect('destroy');
                    $("#select_state").multiselect();
                } else if (response.all_states != '' || response.ext_state != null) {
                    '<option value="">Select </option>';
                    for (var i = 0; i < response.all_states.length; i++) {
                        options += '<option value="' + response.all_states[i].id + '">' + response.all_states[i].state_name + '</option>';
                    }
                    $('#select_state').multiselect('destroy');
                    $("#select_state").html(options);
                    if (response.ext_state != null) {
                        for (var i = 0; i < response.all_states.length; i++) {
                            if ($.inArray(response.all_states[i].id, response.ext_state.user_state) != -1) {
                                $("#select_state").find("option[value=" + response.all_states[i].id + "]").prop("selected", "selected");
                            }
                        }
                    }
                    $('#select_state').multiselect();
                    $("#select_state").multiselect("refresh");
                }
            }
        });
    }

    $(document).on('click', '#saveForm', function (e) {
        var myArray = [];
        $("#select_state option:selected").each(function () {
            myArray.push($(this).val());
        });

        $("#state_err").html('');
        if (myArray.length == 0) {
            $("#enterpriseForm").valid();
            e.preventDefault();
            $("#state_err").html('<label for="select_state" class="error">Select state</label>');
        }

    });

    $('#enterpriseForm').validate({
        rules: {
            "in_operation": "required",
            "with_other_org": "required",
            "competition": "required",
            "other_org_name": {
                required: function (element) {
                    return $("#with_other_org").val() == "Yes";
                }
            },
            "business_compet": {
                required: function (element) {
                    return $("#competition").val() == "Yes";
                }
            }
        },
        messages: {
            "in_operation": "Select type",
            "with_other_org": "Select type",
            "competition": "Select type",
            "other_org_name": 'Enter organization',
            "business_compet": 'Enter plan'
        }
    });

</script>

<script src="<?= base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
<script src="<?= base_url() . 'source/portfolio_assets/js/jquery.toaster.js'; ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.toast').toast('show');
    });
</script>

</body>
</html>