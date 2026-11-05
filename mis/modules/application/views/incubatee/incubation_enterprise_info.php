<style>
     @media only screen and (max-width : 1400px)and (max-height: 900px){ 
		.cin_cls{
			margin-top: 18px;
		}
	 }
</style>

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
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">Enterprise</a></li>
                                <?php if($enterprise_information[0]['program'] != 28){  ?>
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">Impact</a></li>
								<?php } ?>
								<?php if($enterprise_information[0]['program'] == '14') { ?>
								<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/about_business/' . $application_id; ?>">Business</a></li>
									<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/support_info/' . $application_id; ?>">Support</a></li>
								 <?php } ?>
								 
								 <?php if($enterprise_information[0]['program'] == '14' || $enterprise_information[0]['program'] == '30') { ?>
									<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/support_info/' . $application_id; ?>">Support</a></li>
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
                                                    <input type="text" class="form-control cin_cls" value="<?= $enterprise_information[0]['cin']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Stage of Operation</label>
                                                    <input type="text" class="form-control cin_cls" value="<?= $enterprise_information[0]['robot_efficient']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>   
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>What would best describe your solution?</label>
                                                    <input type="text" class="form-control cin_cls" value="<?= $enterprise_information[0]['best_describe']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>If others, specify</label>
                                                    <input type="text" class="form-control cin_cls" value="<?= $enterprise_information[0]['best_describe_other']; ?>" disabled />
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label><?php 
													if($enterprise_information[0]['program']=='12'){
														echo "In which settings are your target end beneficiaries located?";
													}else{
														if($get_langId!='' && $get_langId =='0'){ echo $lang['What_Target_Group']; }else{ echo "What Target Group are you looking at?"; } 
													}
													
													?></label>
                                                    <input type="text" class="form-control" value="<?= ucfirst($enterprise_information[0]['support_name']); ?>" disabled />
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Does your company have a website?</label>
                                                    <input type="text" class="form-control cin_cls" value="<?= $enterprise_information[0]['proposal_desc']; ?>" disabled />
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
                                                    <input type="text" class="form-control cin_cls" value="<?= $enterprise_information[0]['investment_looking']; ?>" disabled />
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
                                                    <input type="text" class="form-control cin_cls" value="<?= $enterprise_information[0]['won_competition']; ?>" disabled />
                                                </div>
                                            </div>
											 <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Do you consider yourself as a social enterprise?</label>
                                                    <input type="text" class="form-control cin_cls" value="<?= $enterprise_information[0]['social_media']; ?>" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
									<?php if($enterprise_information[0]['program'] == '14' || $enterprise_information[0]['program'] == '30' || $enterprise_information[0]['program'] == '38') {
											//echo'<pre>';print_r($enterprise_information);die;
										?>
											<div class="row">
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>Name of enterprise<span>*</span></label>
														
														<?php if($enterprise_information[0]['program'] == '30'){ ?>
														<input type="text" class="form-control" value="<?= $enterprise_information[0]['name_of_enterprise']; ?>" disabled />
														<?php }else { ?>
														<input type="text" class="form-control" value="<?= $enterprise_information[0]['ent_name_info']; ?>" disabled />
														
														<?php } ?>
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
															<option value="6to12" <?php
															if ($enterprise_information[0]['develop_product'] == 'Hybrid Solution') {
																echo 'selected';
															}
															?>>Hybrid Solution</option>
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
										
										
										
                                        <div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
											<?php if( $enterprise_information[0]['program'] == '28' || $enterprise_information[0]['program'] == '33' || $enterprise_information[0]['program'] == '30') { ?>
											  <?php if($enterprise_information[0]['program'] != '33') { ?>
											
											 <div class="form-group">
												<label>At what stage is your product / service <span>*</span></label>
												 <select class="form-control fieldDisable" disabled id="stage_prod" name="stage_prod">
													<option value="">-Select</option>
													
															<option value="">-Select</option>
															<option value="Proof of concept" <?php echo ($enterprise_information[0]['stage_product']=="Proof of concept")?"selected":"";?>>Proof of concept</option>
															<option value="Prototype development" <?php echo ($enterprise_information[0]['stage_product']=="Prototype development")?"selected":"";?>>Prototype development</option>
															<option value="Prototype testing" <?php echo ($enterprise_information[0]['stage_product']=="Prototype testing")?"selected":"";?>>Prototype testing</option>
															<option value="Technical pilot" <?php echo ($enterprise_information[0]['stage_product']=="Technical pilot")?"selected":"";?>>Technical pilot</option>
															<option value="Commercial pilot" <?php echo ($enterprise_information[0]['stage_product']=="Commercial pilot")?"selected":"";?>>Commercial pilot</option>
															<option value="Early sales / Production" <?php echo ($enterprise_information[0]['stage_product']=="Early sales / Production")?"selected":"";?>>Early sales / Production</option>
															<option value="Consistent sales / Growth" <?php echo ($enterprise_information[0]['stage_product']=="Consistent sales / Growth")?"selected":"";?>>Consistent sales / Growth</option>
															<option value="Scaling" <?php echo ($enterprise_information[0]['stage_product']=="Scaling")?"selected":"";?>>Scaling</option>
													</select>
											</div>
											<?php } ?>
											<?php } ?>
											<?php if($enterprise_information[0]['program'] == '33' || $enterprise_information[0]['program'] == '38') {  ?>
													 <div class="form-group">
														<label>At what stage is your product / service<span>*</span></label>
														<select class="form-control fieldDisable" disabled id="stage_prod_new" name="stage_prod_new">
															<option value="">--Select--</option>
															<option value="Idea" <?php if ($enterprise_information[0]['stage_product'] == "Idea") echo "selected"; ?>>Idea</option>
															<option value="Proof of concept" <?php if ($enterprise_information[0]['stage_product'] == "Proof of concept") echo "selected"; ?>>Proof of concept</option>
															<option value="Prototype development" <?php if ($enterprise_information[0]['stage_product'] == "Prototype development") echo "selected"; ?>>Prototype development</option>
															<option value="Prototype testing" <?php if ($enterprise_information[0]['stage_product'] == "Prototype testing") echo "selected"; ?>>Prototype testing</option>
															<option value="Technical pilot" <?php if ($enterprise_information[0]['stage_product'] == "Technical pilot") echo "selected"; ?>>Technical pilot</option>
															<option value="Commercial pilot" <?php if ($enterprise_information[0]['stage_product'] == "Commercial pilot") echo "selected"; ?>>Commercial pilot</option>
															<option value="Production" <?php if ($enterprise_information[0]['stage_product'] == "Production") echo "selected"; ?>>Production</option>
															<option value="Growth" <?php if ($enterprise_information[0]['stage_product'] == "Growth") echo "selected"; ?>>Growth</option>
															<option value="Scaling" <?php if ($enterprise_information[0]['stage_product'] == "Scaling") echo "selected"; ?>>Scaling</option>
														</select>
													</div>
											<?php } ?>
											
											
											<?php if($enterprise_information[0]['program'] != '28' && $enterprise_information[0]['program'] != '30') { ?>
                                                <div class="form-group">
                                                    <label>How long have you been in operation<span>*</span></label>
                                                    <?php $operation_val = $enterprise_information[0]['in_operation']; ?>
                                                    <select class="form-control fieldDisable" disabled id="in_operation" name="in_operation">
                                                        <option value="">--Select--</option>
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
														</option>
                                                        <option value=">2" <?php
                                                        if ($enterprise_information[0]['in_operation'] == '>2') {
                                                            echo 'selected';
                                                        }
                                                        ?>>>2 years </option>
                                                    </select>
                                                </div>
												<?php }else if($enterprise_information[0]['program'] == '30'){ ?>
												<div class="form-group">
                                                    <label>How long have you been in operation<span>*</span></label>
                                                    <?php $operation_val = $enterprise_information[0]['in_operation']; ?>
                                                    <select class="form-control fieldDisable" disabled id="in_operation" name="in_operation">
                                                        <option value="">--Select--</option>
                                                        <option value="0 – 6 months" <?php
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
														</option>
                                                        <option value="> 2 years" <?php
                                                        if ($enterprise_information[0]['in_operation'] == '> 2 years') {
                                                            echo 'selected';
                                                        }
                                                        ?>>>2 years </option>
														<option value="> 5 years" <?php
                                                        if ($enterprise_information[0]['in_operation'] == '> 5 years') {
                                                            echo 'selected';
                                                        }
                                                        ?>>>2 years </option>
                                                    </select>
                                                </div>
												<?php } ?>
                                            </div>
											<?php if($enterprise_information[0]['program'] != '14') { ?>
												<div class="col-12 col-lg-6 col-md-6 leaveLabel">
												<?php if($enterprise_information[0]['program'] == '33' ) {
											//echo'<pre>';print_r($enterprise_information);die;
										?>
											<div class="row">
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>Name of enterprise<span>*</span></label>
														
														<?php if($enterprise_information[0]['program'] == '30'){ ?>
														<input type="text" class="form-control" value="<?= $enterprise_information[0]['name_of_enterprise']; ?>" disabled />
														<?php }else { ?>
														<input type="text" class="form-control" value="<?= $enterprise_information[0]['ent_name_info']; ?>" disabled />
														
														<?php } ?>
													</div>
												</div>
											</div>
										<?php } ?>
										
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
											<?php if($enterprise_information[0]['program'] == '14') { ?>
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
										<?php if($enterprise_information[0]['program'] == '28') { ?>
										<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Provide a brief description of your innovation (product or service)<span>*</span></label>
                                                     <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['inv_desc']; ?></textarea>
                                              
                                                </div>
                                            </div>
											<div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>At what stage is your enterprise</label>
													<select class="form-control fieldDisable" disabled id="stage_prod" name="stage_prod">
														<option value="">-Select</option>
														<option value="Pre Revenue" <?php echo ($enterprise_information[0]['pilots']=="Pre Revenue")?"selected":"";?>>Pre Revenue</option>
														<option value="Post Revenue" <?php echo ($enterprise_information[0]['pilots']=="Post Revenue")?"selected":"";?>>Post Revenue</option>
													</select>
													
												
                                                </div>
                                            </div>
											
                                        </div> 
										
										<?php } ?>
										
										<?php if($enterprise_information[0]['program'] != '38' && $enterprise_information[0]['program'] != '33'  && $enterprise_information[0]['program'] != '14'  && $enterprise_information[0]['program'] != '28' && $enterprise_information[0]['program'] != '30') { ?>
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
										
										<?php if($enterprise_information[0]['program'] == '14') { ?>
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
											<?php if($enterprise_information[0]['program'] != '33') {  ?>
											<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>At what stage is your product / service<span>*</span></label>
														 <select class="form-control fieldDisable" disabled id="stage_prod" name="stage_prod">
															<option value="">-Select</option>
															<option value="Proof of concept" <?php echo ($enterprise_information[0]['stage_product']=="Proof of concept")?"selected":"";?>>Proof of concept</option>
															<option value="Prototype development" <?php echo ($enterprise_information[0]['stage_product']=="Prototype development")?"selected":"";?>>Prototype development</option>
															<option value="Prototype testing" <?php echo ($enterprise_information[0]['stage_product']=="Prototype testing")?"selected":"";?>>Prototype testing</option>
															<option value="Technical pilot" <?php echo ($enterprise_information[0]['stage_product']=="Technical pilot")?"selected":"";?>>Technical pilot</option>
															<option value="Commercial pilot" <?php echo ($enterprise_information[0]['stage_product']=="Commercial pilot")?"selected":"";?>>Commercial pilot</option>
															<option value="Early sales / Production" <?php echo ($enterprise_information[0]['stage_product']=="Early sales / Production")?"selected":"";?>>Early sales / Production</option>
															<option value="Consistent sales / Growth" <?php echo ($enterprise_information[0]['stage_product']=="Consistent sales / Growth")?"selected":"";?>>Consistent sales / Growth</option>
															<option value="Scaling" <?php echo ($enterprise_information[0]['stage_product']=="Scaling")?"selected":"";?>>Scaling</option>
														</select>
														
														
													</div>
												</div>
												<?php } ?>
                                        </div>
										<?php } ?>
										
										<?php if($enterprise_information[0]['program'] != '38' && $enterprise_information[0]['program'] != '14' && $enterprise_information[0]['program'] != '33' && $enterprise_information[0]['program'] != '28' && $enterprise_information[0]['program'] != '30') { ?>
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
										
										<?php 
										
										if($enterprise_information[0]['program'] == '30') { 
										#echo'<pre>';print_r($enterprise_information);
										?>
										<div class="row">
												 <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Select the category of your application<span>*</span></label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="competition" id="competition1" value="Digital solutions led by women" <?php if ($enterprise_information[0]['social_media'] == 'Digital solutions led by women') echo "checked=checked"; ?> onclick="show_compet(this.value);">
                                                        <label class="form-check-label" for="competition1">Digital solutions led by women</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="competition" id="competition2" value="Digital Solutions Impacting Women" <?php if ($enterprise_information[0]['social_media'] == 'Digital Solutions Impacting Women') echo "checked=checked"; ?> onclick="show_compet(this.value);">
                                                        <label class="form-check-label" for="competition2">Digital Solutions Impacting Women</label>
                                                    </div>
													<div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="competition" id="competition2" value="Tech solutions building financial inclusion" <?php if ($enterprise_information[0]['social_media'] == 'Tech solutions building financial inclusion') echo "checked=checked"; ?> onclick="show_compet(this.value);">
                                                        <label class="form-check-label" for="competition2">Tech solutions building financial inclusion</label>
                                                    </div>
                                                    <label for="competition" class="error"></label>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group" id="bus_compet" <?= $com_display_field; ?>>
														<label>Do you have Women in your founding team<span>*</span></label>
														<input type="text" disabled name="business_compet" class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['reco_no']; ?>"/>
													</div>
												</div>
											
                                            
											</div>
											
											
											<div class="row">
												 <div class="col-12 col-lg-6 col-md-6">
                                               <div class="form-group" id="bus_compet" <?= $com_display_field; ?>>
														<label>Please mention their name, and position in the company<span>*</span></label>
														<input type="text" disabled name="business_compet" class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['entity_specify']; ?>"/>
													</div>
                                            </div>
											<div class="col-12 col-lg-6 col-md-6">
												
												</div>
											
                                            
											</div>
											
											
											<div class="row">
												 <div class="col-12 col-lg-6 col-md-6">
                                               <div class="form-group" id="bus_compet" <?= $com_display_field; ?>>
														<label>Provide a brief description of your innovation<span>*</span></label>
														<textarea class="form-control fieldDisable" name="txtAddressOne" cols="30" rows="3" disabled><?= str_replace(PHP_EOL, '', $enterprise_information[0]['inv_risks']); ?></textarea>
													</div>
                                            </div>
											 <div class="col-12 col-lg-6 col-md-6">
                                               <div class="form-group" id="bus_compet" <?= $com_display_field; ?>>
														<label>Describe the technology in your solution<span>*</span></label>
														<textarea class="form-control fieldDisable" name="txtAddressOne" cols="30" rows="3" disabled><?= str_replace(PHP_EOL, '', $enterprise_information[0]['inv_problem']); ?></textarea>
													</div>
                                            </div>
											</div>
											
											
											
											<div class="row">
												 <div class="col-12 col-lg-6 col-md-6">
                                               <div class="form-group" id="bus_compet" <?= $com_display_field; ?>>
														<label>How is the need addressed without your innovation? What are the available alternatives<span>*</span></label>
														<textarea class="form-control fieldDisable" name="txtAddressOne" cols="30" rows="3" disabled><?= str_replace(PHP_EOL, '', $enterprise_information[0]['proposal_desc']); ?></textarea>
													</div>
                                            </div>
											 <div class="col-12 col-lg-6 col-md-6">
                                               <div class="form-group" id="bus_compet" <?= $com_display_field; ?>>
														<label>Describe your business model<span>*</span></label>
														<textarea class="form-control fieldDisable" name="txtAddressOne" cols="30" rows="3" disabled><?= str_replace(PHP_EOL, '', $enterprise_information[0]['pilots']); ?></textarea>
													</div>
                                            </div>
											</div>
											<div class="row">
												 <div class="col-12 col-lg-6 col-md-6">
                                               <div class="form-group" id="bus_compet" <?= $com_display_field; ?>>
														<label>What challenges / risks have you identified in the business?<span>*</span></label>
														<textarea class="form-control fieldDisable" name="txtAddressOne" cols="30" rows="3" disabled><?= str_replace(PHP_EOL, '', $enterprise_information[0]['org_short_desc']); ?></textarea>
													</div>
                                            </div>
											 <div class="col-12 col-lg-6 col-md-6">
                                               <div class="form-group" id="bus_compet" <?= $com_display_field; ?>>
														<label>Who are the key partners of your organisation? List them here<span>*</span></label>
														<textarea class="form-control fieldDisable" name="txtAddressOne" cols="30" rows="3" disabled><?= str_replace(PHP_EOL, '', $enterprise_information[0]['geographic']); ?></textarea>
													</div>
                                            </div>
											</div>
											<div class="row">
												 <div class="col-12 col-lg-6 col-md-6">
                                               <div class="form-group" id="bus_compet" <?= $com_display_field; ?>>
														<label>How do you aim to scale-up<span>*</span></label>
														<textarea class="form-control fieldDisable" name="txtAddressOne" cols="30" rows="3" disabled><?= str_replace(PHP_EOL, '', $enterprise_information[0]['robot_efficient']); ?></textarea>
													</div>
                                            </div>
											</div>
											

											
										<?php } ?>
										
										
										
										
										<?php if($enterprise_information[0]['program'] == '14') { ?>
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
												<div class="col-12 col-lg-6 col-md-6">
												<div class="form-group" id="other_org" <?= $org_display_field; ?>>
													<label>Provide Company CIN. If you don’t have one, write NA<span>*</span></label>
													<input type="text" disabled name="other_org_name" class="form-control fieldDisable" value="<?php echo $enterprise_information[0]['cin_number']; ?>"/>
												</div>
											</div>
											
											</div>
											
											
											 <div class="row">
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
                                            
                                            <div class="col-12 col-lg-6 col-md-6">
												<div class="text-right">
													<span class="clr-red">*</span>Supports only jpeg,png,pdf	
												</div>
                                                <div class="form-group">
                                                    <label>Have you participated in or won any business plan competitions?<span>*</span></label>
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
										</div>
											
											
										<?php } ?>
                                    <?php } ?>
										<div class="row">
									
											<?php if($enterprise_information[0]['program'] == '30') { ?>
												<div class="col-12 col-lg-6 col-md-6 leaveLabel">
													<div class="form-group">
														<label>Geographies of Operation<span>*</span></label>
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
														<select id="select_states" class="multiselect" multiple="multiple" name="select_states[]" ></select>
													</div>
													<div id="state_err"></div>
												</div>
											<?php } ?>
											
									</div>
									
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
    .ui-multiselect.ui-helper-clearfix.ui-widget .selected,.ui-multiselect.ui-helper-clearfix.ui-widget .available{
        width: 50% !important;
    }
    .ui-multiselect.ui-helper-clearfix.ui-widget .selected .selected.connected-list.ui-sortable,.ui-multiselect.ui-helper-clearfix.ui-widget .available .available.connected-list{
        width: 100% !important;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('load_application' => 'application', 'page_load' => 'drag_multiselect')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        get_userLists();
		get_lists_states();
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
            url: "<?php echo site_url('application/load_state_list'); ?>",
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
	
	function get_lists_states() {
        var inv_user_id = "<?= $enterprise_information[0]['inv_user_id']; ?>";
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('application/load_state_list_geo'); ?>",
            data: {'inv_user_id': inv_user_id},
            success: function (response) {
                var options = '';
                if (response.all_states == '' && response.ext_state == null) {
                    options = '<option value=""> Select </option>';
                    $("#select_states").html('');
                    $('#select_states').multiselect('destroy');
                    $("#select_states").multiselect();
                } else if (response.all_states != '' || response.ext_state != null) {
                    '<option value="">Select </option>';
                    for (var i = 0; i < response.all_states.length; i++) {
                        options += '<option value="' + response.all_states[i].id + '">' + response.all_states[i].state_name + '</option>';
                    }
                    $('#select_states').multiselect('destroy');
                    $("#select_states").html(options);
                    if (response.ext_state != null) {
                        for (var i = 0; i < response.all_states.length; i++) {
                            if ($.inArray(response.all_states[i].id, response.ext_state.user_state) != -1) {
                                $("#select_states").find("option[value=" + response.all_states[i].id + "]").prop("selected", "selected");
                            }
                        }
                    }
                    $('#select_states').multiselect();
                    $("#select_states").multiselect("refresh");
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