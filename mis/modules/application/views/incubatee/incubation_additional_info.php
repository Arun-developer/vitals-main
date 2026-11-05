<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $additional_information[0]['name_of_enterprise'] . ' - Additional Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $additional_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $additional_information[0]['name_of_enterprise'], 'app_stage' => $additional_information[0]['stage'], 'program' => $additional_information[0]['program'], 'doc1' => $additional_information[0]['doc1'], 'doc2' => $additional_information[0]['doc2'], 'doc3' => $additional_information[0]['doc3'])); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                 <?php /* <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">Enterprise</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">Impact</a></li>
								<?php if($additional_information[0]['program'] == '14') { ?>
								<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/about_business/' . $application_id; ?>">Business</a></li>
									<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/support_info/' . $application_id; ?>">Support</a></li>
								 <?php } ?>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
								*/ ?>
								<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">
								
								<?php if($additional_information[0]['program'] == '21' || $additional_information[0]['program'] == '22'){
									echo "Team information";  
									}else{
										echo "Team";
									}  
								?>
								</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">
								<?php if($additional_information[0]['program'] == '21' || $additional_information[0]['program'] == '22'){
									echo "About the Enterprise";  
									}else if($enterprise_information[0]['program'] == '31'){
										echo "Enterprise &Innovation challenge";
									}else{
										echo "Enterprise";
									}  
								?>
								</a></li>
								<?php  if ($additional_information[0]['program'] != '28' && $additional_information[0]['program'] != '31'){ ?>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">
								<?php if($additional_information[0]['program'] == '21' || $additional_information[0]['program'] == '22'){
									echo "About the Business model";  
									}else if($additional_information[0]['program'] == '23'){
										echo "Funding details & Support";
									}else{
										echo "Impact";
									}  
								?>
								
								</a></li>
								<?php } ?>
								
								<?php if($additional_information[0]['program'] == '21' && date('Y-m-d', strtotime($additional_information[0]['created_date']))  >= date('2024-01-01')){ ?>
									
									<?php }else{ ?>
									
									<?php if($additional_information[0]['program'] == '14' || $additional_information[0]['program'] == '21' || $additional_information[0]['program'] == '22') { ?>
									<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/about_business/' . $application_id; ?>">
									<?php if($additional_information[0]['program'] == '21' || $additional_information[0]['program'] == '22'){
										echo "Impact of the business";  
										}else{
											echo "Business";
										}  
									?>
									</a></li>
									<?php } ?>
								<?php } ?>
								<?php  if ($additional_information[0]['program'] != '3'  && $additional_information[0]['program'] != '0'  && $additional_information[0]['program'] != '28' && $additional_information[0]['program'] != '31' && $additional_information[0]['program'] != '21' && $additional_information[0]['program'] != '22' && $additional_information[0]['program'] != '23' && $additional_information[0]['program'] != '24' && $additional_information[0]['program'] != '25' && $additional_information[0]['program'] != '34'  && $additional_information[0]['program'] != '27') {  ?>
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/support_info/' . $application_id; ?>">Support</a></li>
								<?php } ?>
								<?php  if ($additional_information[0]['program'] == 25 || $additional_information[0]['program'] == 34 || $additional_information[0]['program'] == 40 ) {  ?>
									<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/gmt_info/' . $application_id; ?>">GTM related information </a></li>
								<?php } ?>
								
								
								<li role="presentation"  class=" active"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
				<?php ///echo $additional_information[0]['program']; ?>
                  <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="additionalForm" action="<?php echo base_url() . 'index.php/application/add_additional_details'; ?>" enctype="multipart/form-data" autocomplete="off">
                                    <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                    <input type="hidden" name="inv_user_id" value="<?= $additional_information[0]['inv_user_id']; ?>">
									
									<?php 
									
									//Pragati Application
									if ($additional_information[0]['program'] == '21') { ?>
									
										 <div class="row">
													<div class="col-12 col-lg-6 col-md-6">
														<div class="form-group">
															 <label>Why do you want to participate in this training programme<span>*</span></label>
																<?php $investment_lookingArr = explode(",", $additional_information[0]['investment_looking']); 
																	#echo'<pre>';print_r($additional_information);die;
																
																?>
																<select class="form-control fieldDisable" id="abt_vill" disabled multiple="multiple" name="abt_vill[]" onchange="about_value();">
																	<option value="To enhance concept of business development" <?php if (in_array('To enhance concept of business development', $investment_lookingArr)) echo "selected"; ?>>To enhance concept of business development</option>
																	<option value="To learn tools for Digital Transformation" <?php if (in_array('To learn tools for Digital Transformation', $investment_lookingArr)) echo "selected"; ?>>Online</option>
																	<option value="Networking" <?php if (in_array('Networking', $investment_lookingArr)) echo "selected"; ?>>Networking</option>
																	<option value="Other" <?php if (in_array('Other', $investment_lookingArr)) echo "selected"; ?>>Other</option>
																</select>
														</div>
													</div>
													<?php //if ($additional_information[0]['ant_org'] == 'Yes'){ ?> 
														 <div class="col-12 col-lg-4 col-md-4">
															<div class="form-group">
																<label>Other training programme<span></span></label>
																<input type="text" class="form-control" value="<?= $additional_information[0]['target_beneficiary']; ?>" disabled />
																<label for="with_other_org" class="error"></label>
															</div>
														</div>
													</div>
									 <div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>The programme is scheduled to conduct a virtual demo day and make other networking opportunities available to participating women entrepreneurs. Would you like to be considered for these opportunities?</label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['from_villgro']; ?>" disabled />
                                                </div>
                                            </div>
											
											
											<?php if ($additional_information[0]['impact_of_product'] == ''){ ?>
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<?php 
															$product_stage_text='';
															if($additional_information[0]['product_stage'] =='Yes'){
																$product_stage_text = "checked";
															}
														?>
														<div>
														<label>This training program will consist of approximately 10-15 hours of training in English medium and networking spread across 1 month. Please confirm your ability to make time for the same?<span>*</span></label>
														<input disabled type="checkbox" <?php echo $product_stage_text; ?> class="" value="<?= $product_stage_text; ?>"  />  I confirm 
														</div>
													</div>
												</div>
											<?php }else {   ?>
											<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<div>
														<label>This training program will consist of 15 hours of training and networking spread across 1 month. Please confirm your ability to make time for the same<span>*</span></label>
														<input type="text" class="form-control" value="<?= $additional_information[0]['product_stage']; ?>" disabled /></div>
													</div>
												</div>
											
											<?php } ?>
											
                                        </div>
										<?php 
										
										//echo'<pre>';print_r($additional_information);die;
										
										if ($additional_information[0]['impact_of_product'] == '1'){ ?>
										
										<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                   <div>
														 <label>
														 <?php if($additional_information[0]['program'] == '21'  && date('Y-m-d', strtotime($additional_information[0]['created_date'])) >= date('2024-01-01')){ ?>
															One session will be scheduled every week starting from January 25th to February 28th  2024 from 4 to 5:30 pm.Please confirm your availability for the same
														 <?php }else{ ?>
														  One session will be scheduled every week starting from November 30th, 2023 to January 11, 2024 from 4 to 5:30 pm .Please confirm your availability for the same.
														 <?php } ?>
														 
														
														 
														 <span>*</span></label>
                                                   
															<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="avail_alter" id="avail_alter" value="Yes" <?php if ($additional_information[0]['avail_alter'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="avail_alter" id="avail_alter" value="No" <?php if ($additional_information[0]['avail_alter'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
												</div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
													<div>
														<label>Please confirm if you are comfortable with attending the sessions in English </label>
															<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="prop_model"  value="Yes" <?php if ($additional_information[0]['prop_model'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="prop_model"  value="No" <?php if ($additional_information[0]['prop_model'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
												</div>
                                            </div>
                                        </div>
										
										 <?php if ($additional_information[0]['prop_model'] == 'No') { ?>
											<div class="row">
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
													   <div>
															<label>Please mention the language you would like to attend the training in<span></span></label>
															<input type="text" class="form-control" value="<?= $additional_information[0]['business_category']; ?>" disabled />
														</div>
													</div>
												</div>
											</div>
										<?php } ?>
										
										<?php } ?>
									
										
										
										<div class="row">
											<?php if ($additional_information[0]['impact_of_product'] != '1') { ?>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Which months of the year suit you best for attending a virtual training programme? Please select all that apply.<span>*</span></label>
                                                    <select class="form-control fieldDisable" id="abt_vill" disabled multiple="multiple" name="month[]" onchange="about_value();">
													<?php
													$funding_details_selected = explode(',',$additional_information[0]['funding_details']);
													
													
													$months = array(
													  'January',
													  'February',
													  'March',
													  'April',
													  'May',
													  'June',
													  'July',
													  'August',
													  'September',
													  'October',
													  'November',
													  'December'
													);
													
													foreach ($months as $month){ ?>
														<option value="<?php echo $month; ?>" <?php if (in_array($month, $funding_details_selected)) echo "selected"; ?>><?php echo $month; ?></option>
													<?php } ?>
													</select>
                                                </div>
                                            </div>
											<?php } ?>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
													<div>
                                                    <label>Add your website link or links to any other additional information </label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['geographic']; ?>" disabled />
													</div>
												</div>
                                            </div>
                                        </div>
										
										
										<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>
													<?php 
														if ($additional_information[0]['impact_of_product'] == '1') {
															echo "How did you hear about the 'EMPOWER Her Journey' program?";
														}else{
															echo "How did you hear about the EMPOWER program?";
														}

													?>
													<span>*</span></label>
													 <?php
                                                    $aboutvill = explode(',', $additional_information[0]['hear_abt']);

                                                    foreach ($aboutvill as $key => $value) {
                                                        if ($aboutvill[$key] == 'Other Mailers/Newsletter/Social media' && $additional_information[0]['from_villgro'] != '') {
                                                            $aboutvill[$key] = 'Other Mailers/Newsletter/Social media (' . trim($additional_information[0]['from_villgro']) . ')';
                                                        } else if ($aboutvill[$key] == 'Referral' && $additional_information[0]['referal_name'] != '') {
                                                            $aboutvill[$key] = 'Referral (' . trim($additional_information[0]['referal_name']) . ')';
                                                        }
                                                    }
                                                    $abtVill = implode(', ', $aboutvill);
                                                    ?>
													
                                                    <input type="text" class="form-control" value="<?= $abtVill; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
													<div>
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['referal_name']; ?>" disabled />
													</div>
												</div>
                                            </div>

                                        </div>
										
							
									<div class="row">
										<div class="col-12 col-lg-6 col-md-6">
											<div class="form-group">
												<label>Have you been incubated, funded or participated in any virtual training programme with another organization<span>*</span></label>
												<div class="form-check form-check-inline">
													<input class="form-check-input fieldDisable" disabled type="radio" name="with_other_org" id="with_other_org1" value="Yes" <?php if ($additional_information[0]['ant_org'] == 'Yes') echo "checked=checked"; ?>  >
													<label class="form-check-label" for="with_other_org1">Yes</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input fieldDisable" disabled type="radio" name="with_other_org" id="with_other_org2" value="No" <?php if ($additional_information[0]['ant_org'] == 'No') echo "checked=checked"; ?> ">
													<label class="form-check-label" for="with_other_org2">No</label>
												</div>
												<label for="with_other_org" class="error"></label>
											</div>
										</div>
										<?php //if ($additional_information[0]['ant_org'] == 'Yes'){ ?> 
											 <div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>Name of organization(s)</label>
													<input type="text" class="form-control" value="<?= $additional_information[0]['ant_org_name']; ?>" disabled />
												</div>
											</div>
										</div>
										<?php //} ?>
													
										
										
									
                                    <?php } else if ($additional_information[0]['program'] == '40') { ?>
                                        <div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Have you been incubated, funded or participated in an accelerator program with another organization<span>*</span></label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="with_other_org" id="with_other_org1" value="Yes" <?php if ($additional_information[0]['ant_org'] == 'Yes') echo "checked=checked"; ?>  >
                                                        <label class="form-check-label" for="with_other_org1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="with_other_org" id="with_other_org2" value="No" <?php if ($additional_information[0]['ant_org'] == 'No') echo "checked=checked"; ?> >
                                                        <label class="form-check-label" for="with_other_org2">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Name of organization(s)</label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['ant_org_name']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $hear_abt = explode(",", $additional_information[0]['hear_abt']);
                                        if (in_array('Referral', $hear_abt) || in_array('Past incubatee', $hear_abt) || in_array('Villgro staff', $hear_abt)) {
                                        ?>
                                        <div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['referal_name']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php if ($additional_information[0]['won_competition'] == 'Yes') { ?>
                                        <div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Name of business plan competition(s)</label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['competition_name']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="text-right">
                                            <span class="clr-red">*</span>Supports only doc,docx,ppt,pptx,pdf files
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group clearfix">
                                                    <label>Business plan's</label>
                                                    <div class="fileUpload blue-btn btn width100">
                                                        <?php
                                                        if (isset($additional_information[0]['doc1']) && !empty($additional_information[0]['doc1'])) {
                                                            $business_truncate = strlen($additional_information[0]['doc1']) > 20 ? "..." . substr($additional_information[0]['doc1'], -20) : $additional_information[0]['doc1'];
                                                            ?>
                                                            <span><?= $business_truncate; ?></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span><i class="fas fa-upload"></i> Upload</span>
                                                        <?php } ?>
                                                        <input type="file" class="uploadlogo" name="business_file" id="business_file" />
                                                        <input type="hidden" name="old_business_file" id="old_business_file" value="<?php echo isset($additional_information[0]['doc1']) ? $additional_information[0]['doc1'] : ''; ?>" />
                                                    </div>
                                                    <?php if (isset($additional_information[0]['doc1']) && !empty($additional_information[0]['doc1'])) { ?>
                                                        <span class="download-btn"><a href="<?php echo host_url() . 'villgro-cfa/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                    <?php } ?>
                                                    <label class="sow_msg error" id="business_file_error"></label>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Additional Information</label>
                                                    <div class="fileUpload clearfix blue-btn btn width100">
                                                        <?php
                                                        if (isset($additional_information[0]['doc2']) && !empty($additional_information[0]['doc2'])) {
                                                            $info_truncate = strlen($additional_information[0]['doc2']) > 20 ? "..." . substr($additional_information[0]['doc2'], -20) : $additional_information[0]['doc2'];
                                                            ?>
                                                            <span><?= $info_truncate; ?></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span><i class="fas fa-upload"></i> Upload</span>
                                                        <?php } ?>
                                                        <input type="file" class="uploadlogo" name="info_file" id="info_file" />
                                                        <input type="hidden" name="old_info_file" id="old_info_file" value="<?php echo isset($additional_information[0]['doc2']) ? $additional_information[0]['doc2'] : ''; ?>" />
                                                    </div>
                                                    <?php if (isset($additional_information[0]['doc2']) && !empty($additional_information[0]['doc2'])) { ?>
                                                        <span class="download-btn"><a href="<?php echo host_url() . 'villgro-cfa/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
                                                    <?php } ?>
                                                    <label class="sow_msg error" id="info_file_error"></label>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else{ ?>
                                    <?php if ($additional_information[0]['program'] == '12') { ?>
                                        <div class="row" style="padding-bottom: 15px;">
                                            <div class="col-12 col-lg-3 col-md-3">
                                                <div class="form-group">
                                                    <label>How did you hear about us?</label>
                                                    <?php
                                                    $aboutvill = explode(',', $additional_information[0]['hear_abt']);

                                                    foreach ($aboutvill as $key => $value) {
                                                        if ($aboutvill[$key] == 'Other Mailers/Newsletter/Social media' && $additional_information[0]['from_villgro'] != '') {
                                                            $aboutvill[$key] = 'Other Mailers/Newsletter/Social media (' . trim($additional_information[0]['from_villgro']) . ')';
                                                        } else if ($aboutvill[$key] == 'Referral' && $additional_information[0]['referal_name'] != '') {
                                                            $aboutvill[$key] = 'Referral (' . trim($additional_information[0]['referal_name']) . ')';
                                                        }
                                                    }
                                                    $abtVill = implode(', ', $aboutvill);
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-7 col-md-7">
                                                <input type="text" class="form-control" value="<?= $abtVill; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-3 col-md-3">
                                                <div class="form-group">
                                                    <label>Uploaded Document</label>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-7 col-md-7">
                                                <?php if ($additional_information[0]['doc1'] != '') { ?>
                                                    <a href="<?php echo host_url() . 'jhpiego/uploads/' . $additional_information[0]['doc1']; ?>"
                                                       target="_blank"><?php echo $additional_information[0]['doc1']; ?></a>
                                                   <?php } ?>
                                            </div>
                                        </div>
                                        <br>
										
										<?php if ($additional_information[0]['program'] != '12') { ?>
                                        <div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Are you interested to respond to this section?</label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['future_growth']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>What is the % proportion of women employees in your company?</label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['current_product']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Does your solution directly impact women & girls?</label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['video_url']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>What proportion of your existing customers are women?</label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['other_support_name']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Do you have any existing partnership with organizations led by women</label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['other_support_name_ref']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Please provide details</label>
                                                    <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['ant_org_name']; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
										
										<?php } ?>
										
										
                                    <?php } else { ?>
									<?php if($additional_information[0]['program'] == '22'){ ?>
									 <div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Amount of debt requirement (INR)</label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['geographic']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Purpose of the loan</label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['funding_details']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
									<?php } ?>
									
									<?php if( $additional_information[0]['program'] == '23'  || $additional_information[0]['program'] == '31' ){ ?>
									
									 <div class="text-right">
                                            <span class="clr-red">*</span>Supports only doc,docx,ppt,pptx,pdf files
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group clearfix">
                                                    <label>Upload your latest pitch deck</label>
                                                    <div class="fileUpload blue-btn btn width100">
                                                        <?php
                                                        if (isset($additional_information[0]['doc1']) && !empty($additional_information[0]['doc1'])) {
                                                            $business_truncate = strlen($additional_information[0]['doc1']) > 20 ? "..." . substr($additional_information[0]['doc1'], -20) : $additional_information[0]['doc1'];
                                                            ?>
                                                            <span><?= $business_truncate; ?></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span><i class="fas fa-upload"></i> Upload</span>
                                                        <?php } ?>
                                                        <input type="file" class="uploadlogo" name="business_file" id="business_file" />
                                                        <input type="hidden" name="old_business_file" id="old_business_file" value="<?php echo isset($additional_information[0]['doc1']) ? $additional_information[0]['doc1'] : ''; ?>" />
                                                    </div>
                                                    <?php if (isset($additional_information[0]['doc1']) && !empty($additional_information[0]['doc1'])) { ?>
														
														<?php if( $additional_information[0]['program'] == '31'){ ?>
														<span class="download-btn"><a href="<?php echo host_url() . 'mobilityservice/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														
														 <?php }else{ ?>
														 <span class="download-btn"><a href="<?php echo host_url() . 'shelterTech/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														
														 <?php } ?>
														
                                                    <?php } ?>
                                                    <label class="sow_msg error" id="business_file_error"></label>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
											
									<?php } ?>
									
									<?php if($additional_information[0]['program'] == '38'){ ?>
									
									<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                   <div>
														 	<label>Explain the project/scaling opportunity for which you are applying and mention: Project Description, Geography, Timelines, Funding amount required, Partnerships associated (Government, Urban Local Body, Corporate, etc.), Expected impact description<span>*</span></label>
												 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['tanseed_program']; ?></textarea>
                                            
													</div>
												</div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
													<label>Please indicate the support you would like from us<span>*</span></label>
                                                    <?php $vill_support = explode(",", $additional_information[0]['funding_details']); ?>
                                                    <select class="form-control fieldDisable" id="vill_support" disabled multiple="multiple" name="vill_support[]" onchange="support_value();">
                                                       <option value="Access to mentors / sector experts" <?php if (in_array('Access to mentors / sector experts', $vill_support)) echo "selected"; ?>>Access to mentors / sector experts</option>

														<option value="Capacity building to access financing" <?php if (in_array('Capacity building to access financing', $vill_support)) echo "selected"; ?>>Capacity building to access financing</option>

														<option value="Building team's capacity for market-entry / market-expansion" <?php if (in_array("Building team's capacity for market-entry / market-expansion", $vill_support)) echo "selected"; ?>>Building team's capacity for market-entry / market-expansion</option>

														<option value="Customer introductions / Networks" <?php if (in_array('Customer introductions / Networks', $vill_support)) echo "selected"; ?>>Customer introductions / Networks</option>

														<option value="Introduction to Investors & Financier Networks" <?php if (in_array('Introduction to Investors & Financier Networks', $vill_support)) echo "selected"; ?>>Introduction to Investors & Financier Networks</option>

														<option value="Capacity building / Training / on go-to-market strategies" <?php if (in_array('Capacity building / Training / on go-to-market strategies', $vill_support)) echo "selected"; ?>>Capacity building / Training / on go-to-market strategies</option>

														<option value="Access to Market Insights & Customer Data" <?php if (in_array('Access to Market Insights & Customer Data', $vill_support)) echo "selected"; ?>>Access to Market Insights & Customer Data</option>

														<option value="Support on conducting pilots / trials" <?php if (in_array('Support on conducting pilots / trials', $vill_support)) echo "selected"; ?>>Support on conducting pilots / trials</option>

														<option value="Testing and strengthening technology" <?php if (in_array('Testing and strengthening technology', $vill_support)) echo "selected"; ?>>Testing and strengthening technology</option>

														<option value="Business Model validation" <?php if (in_array('Business Model validation', $vill_support)) echo "selected"; ?>>Business Model validation</option>

														<option value="Certifications etc" <?php if (in_array('Certifications etc', $vill_support)) echo "selected"; ?>>Certifications etc</option>

														<option value="Board formation" <?php if (in_array('Board formation', $vill_support)) echo "selected"; ?>>Board formation</option>

														<option value="Others" <?php if (in_array('Others', $vill_support)) echo "selected"; ?>>Others</option>
                                                      
													  </select>
												</div>
                                            </div>
                                        </div>
										
										  <div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group " >
                                                    <label>Please Mention Support<span></span></label>
                                                    <input type="text" disabled name="otr_support" class="form-control fieldDisable" value="<?php echo $additional_information[0]['support_name']; ?>"/>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
														<label>Selected enterprises will undergo due diligence in the form of physical site visits and requests on relevant information on the enterprise. Do you give your consent for the same<span>*</span></label>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="vill_support_visits" id="vill_support_visits1" value="Yes" <?php if ($additional_information[0]['product_stage'] == 'Yes') echo "checked=checked"; ?> onclick="show_compet(this.value);">
															<label class="form-check-label" for="vill_support1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="vill_support_visits" id="vill_support_visits2" value="No" <?php if ($additional_information[0]['product_stage'] == 'No') echo "checked=checked"; ?> onclick="show_compet(this.value);">
															<label class="form-check-label" for="vill_support2">No</label> 
														</div>
														<label for="competition" class="error"></label>
													</div>
                                            </div>
                                        </div>
										
										<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                	<div class="form-group">
												
												
												 <?php $hear_abtss = explode(',',$additional_information[0]['hear_abt']); ?>
												<label>How did you hear about our program<span>*</span></label>
												<select  disabled class="form-control fieldDisable" id="abt_vill" name="abt_vill[]" multiple="multiple">
													<option value="Referral" <?php echo (in_array('Referral', $hear_abtss)) ? 'selected' : ''; ?>>Referral</option>
													<option value="Online" <?php echo (in_array('Online', $hear_abtss)) ? 'selected' : ''; ?>>Online</option>
													<option value="Newspaper" <?php echo (in_array('Newspaper', $hear_abtss)) ? 'selected' : ''; ?>>Newspaper</option>
													<option value="Past incubatee" <?php echo (in_array('Past incubatee', $hear_abtss)) ? 'selected' : ''; ?>>Past incubatee</option>
													<option value="Villgro staff" <?php echo (in_array('Villgro staff', $hear_abtss)) ? 'selected' : ''; ?>>Our staff</option>
													<option value="Other" <?php echo (in_array('Other', $hear_abtss)) ? 'selected' : ''; ?>>Other</option>
												</select>
												<label class="error" for="abt_vill[]"></label>
											
											</div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group" >
                                                    <label>Please Mention Name<span></span></label>
                                                    <input type="text" disabled name="ref_name" class="form-control fieldDisable" value="<?php echo $additional_information[0]['referal_name']; ?>"/>
                                                </div>
                                            </div>
                                        </div>
										
										<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                 <div class="form-group" >
                                                    <label>Mention source<span></span></label>
                                                    <input type="text" disabled name="ref_name" class="form-control fieldDisable" value="<?php echo $additional_information[0]['best_describe_other']; ?>"/>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group" >
												  <label>What amount of funding support have you received in the past (grant/equity/debt)<span>*</span></label>
                                                    <input type="text" disabled name="ref_name" class="form-control fieldDisable" value="<?php echo $additional_information[0]['best_describe']; ?>"/>
                                               
                                                   </div>
                                            </div>
                                        </div>
										
										
										
										<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                 <div class="form-group">
														<label>Have you been incubated, funded or participated in an accelerator program with another organization<span>*</span></label>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="vill_support_organization" id="vill_supportorganization1" value="Yes" <?php if ($additional_information[0]['ant_org'] == 'Yes') echo "checked=checked"; ?> onclick="show_compet(this.value);">
															<label class="form-check-label" for="vill_support1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="vill_support_organization" id="vill_supportorganization2" value="No" <?php if ($additional_information[0]['ant_org'] == 'No') echo "checked=checked"; ?> onclick="show_compet(this.value);">
															<label class="form-check-label" for="vill_support2">No</label> 
														</div>
														<label for="competition" class="error"></label>
													</div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group" >
                                                    <label>Name of organization<span></span></label>
                                                    <input type="text" disabled name="ref_name" class="form-control fieldDisable" value="<?php echo $additional_information[0]['ant_org_name']; ?>"/>
                                                </div>
                                            </div>
                                        </div>
										
										
										<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                  <div class="form-group">
														<label>Have you participated in or won any business plan competitions<span>*</span></label>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="vill_support" id="vill_support1" value="Yes" <?php if ($additional_information[0]['won_competition'] == 'Yes') echo "checked=checked"; ?> onclick="show_compet(this.value);">
															<label class="form-check-label" for="vill_support1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="vill_support" id="vill_support2" value="No" <?php if ($additional_information[0]['won_competition'] == 'No') echo "checked=checked"; ?> onclick="show_compet(this.value);">
															<label class="form-check-label" for="vill_support2">No</label> 
														</div>
														<label for="competition" class="error"></label>
													</div>
                                            </div>
                                        </div>
										
										
										
										
										
										
										
									
									
									<?php } ?>

									
									
									<?php if($additional_information[0]['program'] != '22' && $additional_information[0]['program'] != '23' && $additional_information[0]['program'] != '31' ){ ?>
                                        <div class="text-right">
                                            <span class="clr-red">*</span>Supports only doc,docx,ppt,pptx,pdf files
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group clearfix">
                                                    <label>Business plan (if available) <?php if($additional_information[0]['program']==25 || $additional_information[0]['program']==34|| $additional_information[0]['program']==27 ){ echo '<span>*<span>'; }?> 
													
													
													<?php if($additional_information[0]['program'] == '30'){   ?>
															<span>*</span>
															<?php } ?>
															
															
															</label>
                                                    <div class="fileUpload blue-btn btn width100">
                                                        <?php
                                                        if (isset($additional_information[0]['doc1']) && !empty($additional_information[0]['doc1'])) {
                                                            $business_truncate = strlen($additional_information[0]['doc1']) > 20 ? "..." . substr($additional_information[0]['doc1'], -20) : $additional_information[0]['doc1'];
                                                            ?>
                                                            <span><?= $business_truncate; ?></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span><i class="fas fa-upload"></i> Upload</span>
                                                        <?php } ?>
                                                        <input type="file" class="uploadlogo" name="business_file" id="business_file" />
                                                        <input type="hidden" name="old_business_file" id="old_business_file" value="<?php echo isset($additional_information[0]['doc1']) ? $additional_information[0]['doc1'] : ''; ?>" />
                                                    </div>
                                                    <?php if (isset($additional_information[0]['doc1']) && !empty($additional_information[0]['doc1'])) { ?>
														<?php if ($additional_information[0]['program'] == '14') { ?>
                                                        <span class="download-btn"><a href="<?php echo host_url() . 'cisco/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														
														<?php } else if ($additional_information[0]['program'] == '27') { ?>
                                                    <span class="download-btn"><a href="<?php echo host_url() . 'Thrive/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php } else if ($additional_information[0]['program'] == '25') { ?>
														 <span class="download-btn"><a href="<?php echo host_url() . 'MAPHealth/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
													<?php } else if ($additional_information[0]['program'] == '34') { ?>
														 <span class="download-btn"><a href="<?php echo host_url() . 'maphealthcap/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
													
														<?php }else if ($additional_information[0]['program'] == '26') { ?>
														 <span class="download-btn"><a href="<?php echo host_url() . 'poweringlivelihoodsphase/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
													
														<?php }else if ($additional_information[0]['program'] == '29') { ?>
														 <span class="download-btn"><a href="<?php echo host_url() . 'RAIIn/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php }elseif ($additional_information[0]['program'] == '28') {  ?>
														<span class="download-btn"><a href="<?php echo host_url() . 'innovators-for-bharat-climate-resilient-agricultural-livelihoods/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php }elseif ($additional_information[0]['program'] == '24') {  ?>
														<span class="download-btn"><a href="<?php echo host_url() . 'sustainablemobility/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php }elseif ($additional_information[0]['program'] == '30') {  ?>
														<span class="download-btn"><a href="<?php echo host_url() . 'tvaran/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php }elseif ($additional_information[0]['program'] == '33') {  ?>
														<span class="download-btn"><a href="<?php echo host_url() . 'climate_tech_incubator/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php }elseif ($additional_information[0]['program'] == '37') {  ?>
														<span class="download-btn"><a href="<?php echo host_url() . 'water_lab/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php }elseif ($additional_information[0]['program'] == '38') {  ?>
														<span class="download-btn"><a href="<?php echo host_url() . 'tvaran-accelerator/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														
														<?php }else{ ?>
														 <span class="download-btn"><a href="<?php echo host_url() . 'IncubationForm/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php } ?>
                                                    <?php } ?>
                                                    <label class="sow_msg error" id="business_file_error"></label>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label><?php  if($additional_information[0]['program'] == '25' || $additional_information[0]['program'] == '34') { echo "Upload GTM plan"; }else { echo "Additional Information"; } if($additional_information[0]["best_describe"]=='Yes, I have a GTM model in place'){ echo '<span>*<span>';} ?></label>
                                                    <div class="fileUpload clearfix blue-btn btn width100">
                                                        <?php
                                                        if (isset($additional_information[0]['doc2']) && !empty($additional_information[0]['doc2'])) {
                                                            $info_truncate = strlen($additional_information[0]['doc2']) > 20 ? "..." . substr($additional_information[0]['doc2'], -20) : $additional_information[0]['doc2'];
                                                            ?>
                                                            <span><?= $info_truncate; ?></span>
                                                            <?php
                                                        } else {
															
                                                            ?>
                                                            <span><i class="fas fa-upload"></i> Upload</span>
                                                        <?php } ?>
                                                        <input type="file" class="uploadlogo" name="info_file" id="info_file" />
                                                        <input type="hidden" name="old_info_file" id="old_info_file" value="<?php echo isset($additional_information[0]['doc2']) ? $additional_information[0]['doc2'] : ''; ?>" />
                                                    </div>
                                                    <?php if (isset($additional_information[0]['doc2']) && !empty($additional_information[0]['doc2'])) { ?>
													<?php if ($additional_information[0]['program'] == '14') { ?>
                                                        <span class="download-btn"><a href="<?php echo host_url() . 'cisco/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php } else if ($additional_information[0]['program'] == '27') { ?>
													
														
														<span class="download-btn"><a href="<?php echo host_url() . 'Thrive/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														
														<?php } else if ($additional_information[0]['program'] == '25') { ?>
															 <span class="download-btn"><a href="<?php echo host_url() . 'MAPHealth/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php } else if ($additional_information[0]['program'] == '34') { ?>
															 <span class="download-btn"><a href="<?php echo host_url() . 'maphealthcap/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php } else if ($additional_information[0]['program'] == '29') { ?>
															 <span class="download-btn"><a href="<?php echo host_url() . 'RAIIn/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
													
														<?php }elseif ($additional_information[0]['program'] == '28') {  ?>
														 <span class="download-btn"><a href="<?php echo host_url() . 'innovators-for-bharat-climate-resilient-agricultural-livelihoods/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php }elseif ($additional_information[0]['program'] == '24') {  ?>
														 <span class="download-btn"><a href="<?php echo host_url() . 'sustainablemobility/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php }elseif ($additional_information[0]['program'] == '30') {  ?>
														 <span class="download-btn"><a href="<?php echo host_url() . 'tvaran/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php }elseif ($additional_information[0]['program'] == '33') {  ?>
														<span class="download-btn"><a href="<?php echo host_url() . 'climate_tech_incubator/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php }elseif ($additional_information[0]['program'] == '37') {  ?>
														<span class="download-btn"><a href="<?php echo host_url() . 'water_lab/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php }elseif ($additional_information[0]['program'] == '38') {  ?>
														<span class="download-btn"><a href="<?php echo host_url() . 'tvaran-accelerator/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														
														<?php }else{ ?>
														 <span class="download-btn"><a href="<?php echo host_url() . 'IncubationForm/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php } ?>
                                                    <?php } ?>
                                                    <label class="sow_msg error" id="info_file_error"></label>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
											
											<div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>
													<?php if($additional_information[0]['program'] == '37') {?>
														Upload any existing Partnerships Agreement Contract or Letter of Intent you have with Public Sector Entities
										
													<?php }else if($additional_information[0]['program'] == '38') {?>
														Upload any existing MOU/Partnerships
													<?php }else { ?>
														Upload Additional Information
													<?php } ?>
													
													<div class="fileUpload clearfix blue-btn btn width100">
													 <?php
														if($additional_information[0]['program'] == '38'){ 
                                                        if (isset($additional_information[0]['teb_located']) && !empty($additional_information[0]['teb_located'])) {
                                                            $info_truncate = strlen($additional_information[0]['teb_located']) > 20 ? "..." . substr($additional_information[0]['teb_located'], -20) : $additional_information[0]['teb_located'];
                                                            ?>
                                                            <span style="color: #2e8751 !important;"><?= $info_truncate; ?></span>
                                                            <?php
                                                        } else {
															
                                                            ?>
                                                            <span ><i class="fas fa-upload"></i> Upload</span>
                                                        <?php 
														
														} }else{ ?>
														      <i class="fas fa-upload"></i>  Upload
														<?php }  ?>
														

                                                        <input type="file" class="uploadlogo" name="info_file" id="info_file" />
                                                        <input type="hidden" name="old_info_file" id="old_info_file" value="<?php echo isset($additional_information[0]['part_org']) ? $additional_information[0]['part_org'] : ''; ?>" />
                                                    </div>
													<?php if($additional_information[0]['part_org']!=''){ ?>
                                                     <span class="download-btn"><a href="<?php echo host_url() . 'water_lab/uploads/' . $additional_information[0]['part_org']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														<?php  }  ?>
														
															<?php if($additional_information[0]['program'] == '38'){ ?>
                                                   <span class="download-btn"><a href="<?php echo host_url() . 'tvaran-accelerator/uploads/' . $additional_information[0]['teb_located']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														
														<?php  }  ?>
                                                    <label class="sow_msg error" id="info_file_error"></label>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
											
											<?php if($additional_information[0]['program'] == '38'){ ?>
											<div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label> Upload Financial Statements
													<div class="fileUpload clearfix blue-btn btn width100">
                                                         <i class="fas fa-upload"></i> 
														 <?php
														if($additional_information[0]['program'] == '38'){ 
                                                        if (isset($additional_information[0]['teb_other']) && !empty($additional_information[0]['teb_other'])) {
                                                            $info_truncate = strlen($additional_information[0]['teb_other']) > 20 ? "..." . substr($additional_information[0]['teb_other'], -20) : $additional_information[0]['teb_other'];
                                                            ?>
                                                            <span style="color: #2e8751 !important;"><?= $info_truncate; ?></span>
                                                            <?php
                                                        } else {
															
                                                            ?>
                                                            <span ><i class="fas fa-upload"></i> Upload</span>
                                                        <?php 
														
														} }else{ ?>
														      <i class="fas fa-upload"></i>  Upload
														<?php }  ?>
														
														
														
                                                        <input type="file" class="uploadlogo" name="info_file" id="info_file" />
                                                        <input type="hidden" name="old_info_file" id="old_info_file" value="<?php echo isset($additional_information[0]['part_org']) ? $additional_information[0]['part_org'] : ''; ?>" />
                                                    </div>
                                                   <span class="download-btn"><a href="<?php echo host_url() . 'tvaran-accelerator/uploads/' . $additional_information[0]['teb_other']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
													<label class="sow_msg error" id="info_file_error"></label>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
											
											<?php  }  ?>
											
											
											
											
                                        </div>
										<?php } ?>
										
										<?php if($additional_information[0]['program'] == '37') {?>
											 <div class="row">
									  <div class="col-12 col-lg-6 col-md-6">
											<div class="form-group">
												<label>How will this funding amount of INR 25 Lakhs support the growth of your organization<span>*</span></label>
												 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $additional_information[0]['doc3']; ?></textarea>
                                            </div>
										</div>
										<div class="col-12 col-lg-6 col-md-6">
											<div class="form-group">
												<label>Selected enterprises will undergo due diligence in the form of physical site visits and requests on relevant information on the enterprise. Do you give your consent for the same
												 <span>*</span></label>
												<br> <input disabled type="radio" class="check" size="40" id="company_description" name="company_description" class="input-text" <?php echo ($additional_information[0]["company_description"]=="Yes")?"checked":"";?> value="Yes" />Yes<br/>
												<input disabled type="radio" class="check" size="40" id="company_description" name="company_description" class="input-text" <?php echo ($additional_information[0]["company_description"]=="No")?"checked":"";?> value="No" />No<br/>
			
											</div>
										</div>
									</div>
									 <div class="row">
									  <div class="col-12 col-lg-6 col-md-6">
											<div class="form-group">
												 <?php $hear_abt = explode(',',$additional_information[0]['central_state']); ?>
												<label>Please indicate the priority areas of support you would like from us<span>*</span></label>
												 <select class="form-control fieldDisable" id="abt_vill" disabled multiple="multiple" name="abt_vill[]" onchange="about_value();">
													<option value="Access to mentors / sector experts" <?php if (in_array('Access to mentors / sector experts', $hear_abt)) echo "selected"; ?>>Access to mentors / sector experts</option>
													<option value="Capacity building to access financing" <?php if (in_array('Capacity building to access financing', $hear_abt)) echo "selected"; ?>>Capacity building to access financing</option>
													<option value="Building team’s capacity for market-entry / market-expansion" <?php if (in_array('Building team’s capacity for market-entry / market-expansion', $hear_abt)) echo "selected"; ?>>Building team’s capacity for market-entry / market-expansion</option>
													<option value="Customer introductions / Networks" <?php if (in_array('Customer introductions / Networks', $hear_abt)) echo "selected"; ?>>Customer introductions / Networks</option>
													<option value="Introduction to Investors & Financier Networks" <?php if (in_array('Introduction to Investors & Financier Networks', $hear_abt)) echo "selected"; ?>>Introduction to Investors & Financier Networks</option>
													<option value="Capacity building / Training / on go-to-market strategies" <?php if (in_array('Capacity building / Training / on go-to-market strategies', $hear_abt)) echo "selected"; ?>>Capacity building / Training / on go-to-market strategies</option>
													<option value="Access to Market Insights & Customer Data" <?php if (in_array('Access to Market Insights & Customer Data', $hear_abt)) echo "selected"; ?>>Access to Market Insights & Customer Data</option>
													<option value="Support on conducting pilots / trials" <?php if (in_array('Support on conducting pilots / trials', $hear_abt)) echo "selected"; ?>>Support on conducting pilots / trials</option>
													<option value="Testing and strengthening technology" <?php if (in_array('Testing and strengthening technology', $hear_abt)) echo "selected"; ?>>Testing and strengthening technology</option>
													<option value="Business Model validation" <?php if (in_array('Business Model validation', $hear_abt)) echo "selected"; ?>>Business Model validation</option>
													<option value="Certifications etc" <?php if (in_array('Certifications etc', $hear_abt)) echo "selected"; ?>>Certifications etc</option>
													<option value="Other" <?php if (in_array('Other', $hear_abt)) echo "selected"; ?>></option>
										
												</select>
                                            </div>
										</div>
										<div class="col-12 col-lg-6 col-md-6">
											<div class="form-group">
												<label><span>*</span></label>
												
												 <?php $hear_abtss = explode(',',$additional_information[0]['hear_abt']); ?>
												<label>How did you hear about our program<span>*</span></label>
												<select  disabled class="form-control fieldDisable" id="abt_vill" name="abt_vill[]" multiple="multiple">
													<option value="Referral" <?php echo (in_array('Referral', $hear_abtss)) ? 'selected' : ''; ?>>Referral</option>
													<option value="Online" <?php echo (in_array('Online', $hear_abtss)) ? 'selected' : ''; ?>>Online</option>
													<option value="Newspaper" <?php echo (in_array('Newspaper', $hear_abtss)) ? 'selected' : ''; ?>>Newspaper</option>
													<option value="Past incubatee" <?php echo (in_array('Past incubatee', $hear_abtss)) ? 'selected' : ''; ?>>Past incubatee</option>
													<option value="Villgro staff" <?php echo (in_array('Villgro staff', $hear_abtss)) ? 'selected' : ''; ?>>Our staff</option>
													<option value="Other" <?php echo (in_array('Other', $hear_abtss)) ? 'selected' : ''; ?>>Other</option>
												</select>
												<label class="error" for="abt_vill[]"></label>
											
											</div>
										</div>
									</div>
									
									  <div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group " >
                                                    <label>Please Mention Support<span></span></label>
                                                    <input type="text" disabled name="otr_support" class="form-control fieldDisable" value="<?php echo $additional_information[0]['support_name']; ?>"/>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group" >
                                                    <label>Please Mention Name<span></span></label>
                                                    <input type="text" disabled name="ref_name" class="form-control fieldDisable" value="<?php echo $additional_information[0]['referal_name']; ?>"/>
                                                </div>
                                            </div>
                                        </div>
									
									  <div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group " >
                                                    <label>What amount of funding support have you received in the past<span>*</span></label>
														<br> 
														 <input disabled type="radio" class="check" size="40" id="competition" name="competition" class="input-text" <?php echo ($additional_information[0]["won_competition"]=="grant")?"checked":"";?> value="grant"  />grant<br/>
														<input disabled type="radio" class="check" size="40" id="competition" name="competition" class="input-text" <?php echo ($additional_information[0]["won_competition"]=="No")?"checked":"";?> value="equity" />equity<br/>
														<input disabled type="radio" class="check" size="40" id="competition" name="competition" class="input-text" <?php echo ($additional_information[0]["won_competition"]=="No")?"checked":"";?> value="debt" />debt<br/>
													   
												</div>
                                            </div>
                                        </div>
										<?php } ?>
										
										
                                        <div class="row">
										<?php if ($additional_information[0]['program'] == '14') { ?>
                                            <div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>Selected enterprises will undergo due diligence in the form of physical site visits and requests on relevant information on the enterprise. Do you give your consent for the same<span>*</span></label>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="vill_support" id="vill_support1" value="Yes" <?php if ($additional_information[0]['product_stage'] == 'Yes') echo "checked=checked"; ?> onclick="show_compet(this.value);">
															<label class="form-check-label" for="vill_support1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="vill_support" id="vill_support2" value="No" <?php if ($additional_information[0]['product_stage'] == 'No') echo "checked=checked"; ?> onclick="show_compet(this.value);">
															<label class="form-check-label" for="vill_support2">No</label> 
														</div>
														<label for="competition" class="error"></label>
													</div>
												</div>
											<?php  } ?>
											 <?php if ($additional_information[0]['program'] != '37' && $additional_information[0]['program'] != '38' &&  $additional_information[0]['program'] != '31' && $additional_information[0]['program'] != '30' && $additional_information[0]['program'] != '27' && $additional_information[0]['program'] != '28' && $additional_information[0]['program'] != '14' && $additional_information[0]['program'] != '22' && $additional_information[0]['program'] != '23') { ?>
                                            <div class="col-12 col-lg-4 col-md-4" id="multiple_support">
                                                <div class="form-group">
                                                    <label>Please indicate the support you would like from us<span>*</span></label>
                                                    <?php $vill_support = explode(",", $additional_information[0]['from_villgro']); ?>
                                                    <select class="form-control fieldDisable" id="vill_support" disabled multiple="multiple" name="vill_support[]" onchange="support_value();">
                                                        <option value="Board formation" <?php if (in_array('Board formation', $vill_support)) echo "selected"; ?>>Board formation</option>
                                                        <option value="Capacity building" <?php if (in_array('Capacity building', $vill_support)) echo "selected"; ?>>Capacity building</option>
                                                        <option value="Funding" <?php if (in_array('Funding', $vill_support)) echo "selected"; ?>>Funding</option>
                                                        <option value="Mentoring" <?php if (in_array('Mentoring', $vill_support)) echo "selected"; ?>>Mentoring</option>
                                                        <option value="Networks" <?php if (in_array('Networks', $vill_support)) echo "selected"; ?>>Networks</option>
                                                        <?php if ($additional_information[0]['program'] == '29'){ ?>
															<option value="Market Access/Commercialisation" <?php if (in_array('Market Access/Commercialisation', $vill_support)) echo "selected"; ?>>Market Access/Commercialisation</option>
														<?php } ?>
														<option value="Other" <?php if (in_array('Other', $vill_support)) echo "selected"; ?>>Other</option>
                                                        <option value="Talent" <?php if (in_array('Talent', $vill_support)) echo "selected"; ?>>Talent</option>
                                                        <option value="Technology transfer" <?php if (in_array('Technology transfer', $vill_support)) echo "selected"; ?>>Technology transfer</option>
                                                        <option value="Training" <?php if (in_array('Training', $vill_support)) echo "selected"; ?>>Training</option>
                                                    </select>
                                                </div>
                                                <div id="support_err"></div>
                                            </div>
											 <?php  } ?>
											  <?php if ($additional_information[0]['program'] == '30'){ ?>
												 <div class="col-12 col-lg-4 col-md-4" id="multiple_support">
													<div class="form-group">
														<label>Selected enterprises will undergo due diligence in the form of physical site visits and requests on relevant information on the enterprise. Do you give your consent for the same<span>*</span></label>
														
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="product_stage" id="product_stage" value="Yes" <?php if ($additional_information[0]['product_stage'] == 'Yes') echo "checked=checked"; ?>  onclick="show_org(this.value);">
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="product_stage" id="product_stage" value="No" <?php if ($additional_information[0]['product_stage'] == 'No') echo "checked=checked"; ?>  onclick="show_org(this.value);">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
													<div id="support_err"></div>
												</div>
											
											 <?php  } ?>
                                           
                                        </div>
										
											<!-- Innovators for bharat !-->
										
										<div class="row">
										<?php if ($additional_information[0]['program'] == '28' ) { ?>
                                            <div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>Do you need to raise debt<span>*</span></label>
														 <select class="form-control fieldDisable" id="vill_support" disabled multiple="multiple" name="vill_support[]" onchange="support_value();">
															<option value="Upto INR 40L" <?php echo ($additional_information[0]["from_villgro"]=="Upto INR 40L")?"selected":"";?>>Upto INR 40L</option>
															<option value="Upto INR 1 Cr" <?php echo ($additional_information[0]["from_villgro"]=="Upto INR 1 Cr")?"selected":"";?>>Upto INR 1 Cr</option>
														</select>
													</div>
												</div>
											 <div class="col-12 col-lg-4 col-md-4" id="multiple_support">
                                                <div class="form-group">
                                                    <label>Purpose / proposed use of funds raised through this program<span>*</span></label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['support_name']; ?>" disabled />
                                               
                                                </div>
                                                <div id="support_err"></div>
                                            </div>
											
											<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>Have  you previously accessed credit from any financial institution<span>*</span></label>
														 <select class="form-control fieldDisable" id="vill_support" disabled multiple="multiple" name="vill_support[]" onchange="support_value();">
															<option value="Yes" <?php echo ($additional_information[0]["hear_abt"]=="Yes")?"selected":"";?>>Yes</option>
																<option value="No" <?php echo ($additional_information[0]["hear_abt"]=="No")?"selected":"";?>>No</option>
														</select>
													</div>
												</div>
												<?php if($additional_information[0]["hear_abt"]=="Yes") { ?>
											 <div class="col-12 col-lg-4 col-md-4" id="multiple_support">
                                                <div class="form-group">
                                                    <label>If yes, please mention the names of the financial institutions<span></span></label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['support_name']; ?>" disabled />
												</div>
                                                <div id="support_err"></div>
                                            </div>
											<?php  } ?>
											<div class="col-12 col-lg-6 col-md-6">
												<div class="form-group">
													<label>If yes, has your startup defaulted on any due loan repayments<span>*</span></label>
													<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="prop_model" id="prop_model" value="Yes" <?php if ($additional_information[0]['prop_model'] == 'Yes') echo "checked=checked"; ?>  onclick="show_org(this.value);">
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="prop_model" id="prop_model" value="No" <?php if ($additional_information[0]['prop_model'] == 'No') echo "checked=checked"; ?>  onclick="show_org(this.value);">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
												</div>
											</div>
											 <div class="col-12 col-lg-4 col-md-4" id="multiple_support">
                                                <div class="form-group">
                                                    <label>If yes, please mention<span></span></label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['video_url']; ?>" disabled />
												</div>
                                                <div id="support_err"></div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
												<div class="form-group">
													<label>Is the company's net worth in last 2 year positive<span>*</span></label>
													<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="with_other_orgss" id="with_other_org11" value="Yes" <?php if ($additional_information[0]['won_competition'] == 'Yes') echo "checked=checked"; ?>  onclick="show_org(this.value);">
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="with_other_orgss" id="with_other_org21" value="No" <?php if ($additional_information[0]['won_competition'] == 'No') echo "checked=checked"; ?>  onclick="show_org(this.value);">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
												</div>
											</div>
											 <div class="col-12 col-lg-4 col-md-4" id="multiple_support">
                                                <div class="form-group">
                                                    <label>What is the current runway in months <span>*</span></label>
                                                   <input type="text" class="form-control" value="<?= $additional_information[0]['doc3']; ?>" disabled />
													
												</div>
                                                <div id="support_err"></div>
                                            </div>
											
											<div class="col-12 col-lg-4 col-md-4" id="multiple_support">
                                                <div class="form-group">
                                                    <label>Current monthly cash burn (INR) <span>*</span></label>
                                                    <input type="text" class="form-control" value="<?= $additional_information[0]['competition_name']; ?>" disabled />
												</div>
                                                <div id="support_err"></div>
                                            </div>
											
										<?php  } ?>
                                        </div>
										
											<?php if($additional_information[0]['program'] == '28') { ?>
												
												<div class="row">
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>Have you been incubated, funded or participated in any virtual training programme with another organization<span>*</span></label>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="with_other_org" id="with_other_org1" value="Yes" <?php if ($additional_information[0]['ant_org'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="with_other_org" id="with_other_org2" value="No" <?php if ($additional_information[0]['ant_org'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
														<label for="with_other_org" class="error"></label>
													</div>
												</div>
												<?php //if ($additional_information[0]['ant_org'] == 'Yes'){ ?> 
													 <div class="col-12 col-lg-4 col-md-4">
														<div class="form-group">
															<label>Name of organization(s)</label>
															<input type="text" class="form-control" value="<?= $additional_information[0]['ant_org_name']; ?>" disabled />
														</div>
													</div>
												</div>
												<?php //} ?>
										
										<?php } ?>
										
										
										
										 <?php if ($additional_information[0]['program'] == '33' || $additional_information[0]['program'] == '30' || $additional_information[0]['program'] == '29' ||$additional_information[0]['program'] == '0' || $additional_information[0]['program'] == '14' || $additional_information[0]['program'] == '25'  || $additional_information[0]['program'] == '34' || $additional_information[0]['program'] == '26' || $additional_information[0]['program'] == '27') { ?>
										 
										 <div class="row">
													<div class="col-12 col-lg-6 col-md-6">
														<div class="form-group">
															 <label>How did you hear about our program<span>*</span></label>
																<?php $hear_abt = explode(",", $additional_information[0]['hear_abt']); ?>
																<select class="form-control fieldDisable" id="abt_vill" disabled multiple="multiple" name="abt_vill[]" onchange="about_value();">
																	<?php if($additional_information[0]['program'] == '30' ){ ?>
																		<option value="Linkedin" <?php if (in_array('Linkedin', $hear_abt)) echo "selected"; ?>>Linkedin</option>
																		<option value="Villgro website" <?php if (in_array('Villgro website', $hear_abt)) echo "selected"; ?>>Villgro website</option>
																		<option value="Emailer" <?php if (in_array('Emailer', $hear_abt)) echo "selected"; ?>>Emailer</option>
																		<option value="Digital media" <?php if (in_array('Digital media', $hear_abt)) echo "selected"; ?>>Digital media</option>
																		<option value="Referral" <?php if (in_array('Referral', $hear_abt)) echo "selected"; ?>>Referral</option>
																		<option value="Past incubatee" <?php if (in_array('Past incubatee', $hear_abt)) echo "selected"; ?>>Past incubatee</option>
																		<option value="Our staff" <?php if (in_array('Our staff', $hear_abt)) echo "selected"; ?>>Past incubatee</option>
																		<option value="Other" <?php if (in_array('Other', $hear_abt)) echo "selected"; ?>>Other</option>
																	<?php }else{ ?>
																	<option value="Referral" <?php if (in_array('Referral', $hear_abt)) echo "selected"; ?>>Referral</option>
																	<option value="Online" <?php if (in_array('Online', $hear_abt)) echo "selected"; ?>>Online</option>
																	<option value="Newspaper" <?php if (in_array('Newspaper', $hear_abt)) echo "selected"; ?>>Newspaper</option>
																	<option value="Past incubatee" <?php if (in_array('Past incubatee', $hear_abt)) echo "selected"; ?>>Past incubatee</option>
																	<option value="Our staff" <?php if (in_array('Our staff', $hear_abt)) echo "selected"; ?>>Villgro staff</option>
																	<option value="Other" <?php if (in_array('Other', $hear_abt)) echo "selected"; ?>>Other</option>
																	<?php } ?></select>
														</div>
													</div>
													
													
													<?php 
													
													$villsupportss = explode(',',$additional_information[0]['from_villgro']);
													
													if ($additional_information[0]['program'] == '0'){
															if ($additional_information[0]['referal_name']!=''){
														?> 
														 <div class="col-12 col-lg-4 col-md-4">
															<div class="form-group">
																<label>Name<span>*</span></label>
																<input type="text" class="form-control" value="<?= $additional_information[0]['referal_name']; ?>" disabled />
																<label for="with_other_org" class="error"></label>
															</div>
														</div>
													
													<?php } 
													
													}else { ?> 
														<div class="col-12 col-lg-4 col-md-4">
																<div class="form-group">
																	<label>Name<span>*</span></label>
																	<input type="text" class="form-control" value="<?= $additional_information[0]['referal_name']; ?>" disabled />
																	<label for="with_other_org" class="error"></label>
																</div>
															</div>
														</div>
													<?php } ?>
													
													</div>
													
										 
												<div class="row">
													<div class="col-12 col-lg-6 col-md-6">
														<div class="form-group">
															<label>
															<?php 
															
															
															if($additional_information[0]['program'] == '25' || $additional_information[0]['program'] == '3'){
																	echo"Have you been incubated, funded or participated in an accelerator program with another organization";
															}else {
																echo"Have you been incubated, funded or participated in an accelerator program with another organisation";
																
															}

																?>		
															
															
															<span>*</span></label>
															<div class="form-check form-check-inline">
																<input class="form-check-input fieldDisable" disabled type="radio" name="with_other_org" id="with_other_org1" value="Yes" <?php if ($additional_information[0]['ant_org'] == 'Yes') echo "checked=checked"; ?>  >
																<label class="form-check-label" for="with_other_org1">Yes</label>
															</div>
															<div class="form-check form-check-inline">
																<input class="form-check-input fieldDisable" disabled type="radio" name="with_other_org" id="with_other_org2" value="No" <?php if ($additional_information[0]['ant_org'] == 'No') echo "checked=checked"; ?> ">
																<label class="form-check-label" for="with_other_org2">No</label>
															</div>
															<label for="with_other_org" class="error"></label>
														</div>
													</div>
													<?php //if ($additional_information[0]['ant_org'] == 'Yes'){ ?> 
														 <div class="col-12 col-lg-4 col-md-4">
															<div class="form-group">
																<label>Name of organization(s)</label>
																<input type="text" class="form-control" value="<?= $additional_information[0]['ant_org_name']; ?>" disabled />
															</div>
														</div>
													</div>
													<?php //} ?>
												
											<?php if($additional_information[0]['program'] != '26' && $additional_information[0]['program'] != '27' && $additional_information[0]['program'] != '29'){ ?>												
												<div class="row">
													<div class="col-12 col-lg-6 col-md-6">
														<div class="form-group">
															<label>
															<?php 
															
															
															if($additional_information[0]['program'] == '25' || $additional_information[0]['program'] == '34' || $additional_information[0]['program'] == '0'){
																	echo"Have you participated in or won any business plan competitions";
															}else {
																echo"Have you won any CISCO grant in the past";
																
															}

																?>	
																
															 <span>*</span></label>
															<div class="form-check form-check-inline">
																<input class="form-check-input fieldDisable" disabled type="radio" name="won_competition" id="with_other_org1" value="Yes" <?php if ($additional_information[0]['won_competition'] == 'Yes') echo "checked=checked"; ?>  onclick="show_org(this.value);">
																<label class="form-check-label" for="with_other_org1">Yes</label>
															</div>
															<div class="form-check form-check-inline">
																<input class="form-check-input fieldDisable" disabled type="radio" name="won_competition" id="with_other_org2" value="No" <?php if ($additional_information[0]['won_competition'] == 'No') echo "checked=checked"; ?>  onclick="show_org(this.value);">
																<label class="form-check-label" for="with_other_org2">No</label>
															</div>
															<label for="with_other_org" class="error"></label>
														</div>
													</div>
													
														 <div class="col-12 col-lg-4 col-md-4">
															<div class="form-group">
																<label>
																 <?php  
																 
																 if($additional_information[0]['program'] == '25' || $additional_information[0]['program'] == '34' || $additional_information[0]['program'] == '0' ){ 
																		echo"Name of business plan competition(s)";
																 }else{
																		echo"Name of the grant";
																 }	


																 ?>	
																 
																</label>
																<input type="text" class="form-control" value="<?= $additional_information[0]['competition_name']; ?>" disabled />
															</div>
														</div>
												
												</div>
												<?php } ?>
												
												<?php if($innovationDetails[0]['program'] != '30' &&  $additional_information[0]['program'] != '0' && $additional_information[0]['program'] != '33' && $additional_information[0]['program'] != '26' && $additional_information[0]['program'] != '27' && $additional_information[0]['program'] != '25' && $additional_information[0]['program'] != '34'   && $additional_information[0]['program'] != '29' ){ ?>	
												<div class="row">
													<div class="col-12 col-lg-6 col-md-6">
														<div class="form-group">
															<label>The Program is scheduled to conduct the following physical events (tentative dates) :</label>
															<div>
															<ul>
																<li>Program Launch: A 1-day event to be scheduled in the week of Jan 16, 2023 to Jan 23, 2023, in Banglore </li>
																<li>Program Closing: A 1-day event to be scheduled in the week of Aug 1 2023 to Aug 8, 2023,in Delhi </li>
															<ul>
															</div>
															
															<label>
															As these events are a critical aspect of the program, will you be available to attend the event in person<span>*</span></label>
															<div>
															</br>
															
															<div class="form-check form-check-inline">
																<input class="form-check-input fieldDisable" disabled type="radio" name="from_villgro" id="with_other_org1" value="Yes" <?php if ($additional_information[0]['from_villgro'] == 'Yes') echo "checked=checked"; ?>  onclick="show_org(this.value);">
																<label class="form-check-label" for="with_other_org1">Yes</label>
															</div>
															<div class="form-check form-check-inline">
																<input class="form-check-input fieldDisable" disabled type="radio" name="from_villgro" id="with_other_org2" value="No" <?php if ($additional_information[0]['from_villgro'] == 'No') echo "checked=checked"; ?>  onclick="show_org(this.value);">
																<label class="form-check-label" for="with_other_org2">No</label>
															</div>
															<label for="with_other_org" class="error"></label>
														</div>
													</div>
												</div>
												<?php } ?>
										 
										 <?php } ?>
										 <?php if ($additional_information[0]['program'] != '14' && $additional_information[0]['program'] != '38') { ?>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group clearfix" id="villgro_other">
                                                    <label>Please Mention Support<span>*</span></label>
                                                    <input type="text" disabled name="otr_support" class="form-control fieldDisable" value="<?php echo $additional_information[0]['support_name']; ?>"/>
                                                </div>
                                            </div>
											<?php if($additional_information[0]['program'] != '27' && $additional_information[0]['program'] != '30'){ ?>		
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group" id="about_other">
                                                    <label>Please Mention Name<span>*</span></label>
                                                    <input type="text" disabled name="ref_name" class="form-control fieldDisable" value="<?php echo $additional_information[0]['referal_name']; ?>"/>
                                                </div>
                                            </div>
											<?php } ?>
                                        </div>
										<?php } ?>
                                    <?php } ?>
									
										
									
									 <?php if ($additional_information[0]['program'] == '25' || $additional_information[0]['program'] == '34' ) { ?>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group clearfix" >
                                                    <label>Do you have a GTM model in place, or do you require assistance in building a model? If you have a GTM model in place, please upload it under "Additional Information" tab of the application<span>*</span></label>
                                                    <br>
													<input type="radio" disabled class="check best_describe" size="40" id="best_describe" name="best_describe" class="input-text" <?php echo ($additional_information[0]["best_describe"]=="Yes, I have a GTM model in place")?"checked":"";?> value="Yes, I have a GTM model in place" />Yes, I have a GTM model in place<br/>
													<input type="radio" disabled class="check best_describe" size="40" id="best_describe" name="best_describe" class="input-text" <?php echo ($additional_information[0]["best_describe"]=="No, I require assistance in building a GTM model")?"checked":"";?> value="No, I require assistance in building a GTM model" />No, I require assistance in building a GTM model<br/>
            
												
												</div>
                                            </div>
                                        </div>
									<?php } ?>
										
										
									<?php if($additional_information[0]['program'] == '27' ){ ?>		
									  <div class="row">
										<div class="col-12 col-lg-6 col-md-6">
											<div class="form-group">
												<label>Selected enterprises will undergo due diligence in the form of physical site visits and requests on relevant information on the enterprise. Do you give your consent for the same <?php if($additional_information[0]['program']==27 ){ echo '<span>*<span>'; }?></label>
												<input type="text" class="form-control" value="<?= $additional_information[0]['product_stage']; ?>" disabled />
											</div>
										</div>
										</div>
								
								    <?php } ?>
										
                                    <div class="row ">
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView display-hide">
                                                    <li><input type="submit" value="Save" id="saveForm" class="vital_yellow_btn wdt_100"></li>
                                                    <li><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
									
									
									<?php } ?>
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


<?php $this->load->view('vitals_footer.php', array('load_application' => 'application', 'multi_select' => 'multiselect')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#vill_support, #abt_vill').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });

        support_value();
        about_value();
    });

    $(document).on('click', '#saveForm', function (e) {
        var support_len = $('#multiple_support .multiselect-selected-text').html();
        var about_len = $('#multiple_about .multiselect-selected-text').html();
        $("#support_err, #about_err").html('');
        if (support_len == 'Select an Option') {
            $("#additionalForm").valid();
            e.preventDefault();
            $("#support_err").html('<label for="vill_support" class="error">Select type</label>');
        }
        if (about_len == 'Select an Option') {
            $("#additionalForm").valid();
            e.preventDefault();
            $("#about_err").html('<label for="abt_vill" class="error">Select type</label>');
        }
    });

    function support_value() {
        var myArray = [];
        $('#vill_support option:selected').each(function () {
            myArray.push($(this).val());
        });

        if ($.inArray("Other", myArray) !== -1) {
            $('#villgro_other').show();
        } else {
            $('#villgro_other').hide();
        }
    }

    function about_value() {
        var myArray = [];
        $('#abt_vill option:selected').each(function () {
            myArray.push($(this).val());
        });
        if ($.inArray("Other", myArray) !== -1) {
            $('#about_other').show();
        } else {
            $('#about_other').hide();
        }
    }

    $(document).ready(function () {
        $('input[type="file"]').css("pointer-events", "none");
    });

    $('.summaryEdit').click(function () {
        $('input[type="file"]').css("pointer-events", "");
        $(".fieldDisable").attr("disabled", false);
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').addClass("display-show");
        $('.saveLinkView').removeClass("display-hide");
    });

    $('#additionalForm').validate({
        rules: {
            "otr_support": "required",
            "ref_name": "required",
        },
        messages: {
            "otr_support": "Enter name",
            "ref_name": "Enter name",
        }
    });

    $(document).on('change', '.uploadlogo', function () {
        var filename = readURL(this);
        var result = filename.split('|*|');
        $(this).parent().children('span').html(result[0]);
        if (result[1] != '1') {
            $(this).parent().parent().children('.sow_msg').show();
            $(this).parent().parent().children('.sow_msg').text(result[1]);
        } else {
            $(this).parent().parent().children('.sow_msg').text('');
            $(this).parent().parent().children('.sow_msg').hide();
        }
    });

    function readURL(input) {
        var url = input.value;
        var path, filename;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        var bsize = (input.files.length && input.files[0].size) || '';
        if (bsize != '') {
            var fsize = Math.round(bsize / 1024);
            if (fsize <= 10000) {
                if (input.files && input.files[0] && (ext == "pdf" || ext == "doc" || ext == "docx" || ext == "ppt" || ext == "pptx")) {
                    path = $(input).val();
                    filename = path.replace(/^.*\\/, "");
                    return filename + '|*|1';
                } else {
                    filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file';
                    return filename;
                }
            } else {
                filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file size';
                return filename;
            }
        }
    }

    $(document).on('submit', '#additionalForm', function (e) {
        $('#additionalForm').valid();
        var result = validateForm();
        if (result == 1) {
            return false;
        } else {
            $('#saveForm').css('pointer-events', 'none');
            return true;
        }
    });

    function validateForm() {
        var err = 0;

        $(".uploadlogo").each(function () {
            var filename = readURL(this);
            if (filename) {
                var result = filename.split('|*|');
                $(this).parent().children('span').html(result[0]);
                if (result[1] != '1') {
                    $(this).parent().parent().children('.sow_msg').show();
                    $(this).parent().parent().children('.sow_msg').text(result[1]);
                    err = 1;
                } else {
                    $(this).parent().parent().children('.sow_msg').text('');
                    $(this).parent().parent().children('.sow_msg').hide();
                }
            }
        });
        return err;
    }
</script>

</body>
</html>
