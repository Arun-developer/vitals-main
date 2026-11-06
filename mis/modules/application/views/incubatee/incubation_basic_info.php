<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $basic_information[0]['name_of_enterprise'] . ' - Basic Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $basic_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $basic_information[0]['name_of_enterprise'], 'app_stage' => $basic_information[0]['stage'], 'program' => $basic_information[0]['program'], 'doc1' => $basic_information[0]['doc1'], 'doc2' => $basic_information[0]['doc2'], 'doc3' => $basic_information[0]['doc3'])); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                               <?php 
							   /* <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">Enterprise</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">Impact</a></li>
								<?php if($basic_information[0]['program'] == '14') { ?>
								<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/about_business/' . $application_id; ?>">Business</a></li>
									<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/support_info/' . $application_id; ?>">Support</a></li>
								 <?php } ?>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li> */
								?>
								<li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">
								<?php if($basic_information[0]['program'] == '21' || $basic_information[0]['program'] == '22'){
									echo "Team information";  
									}else{
										echo "Team";
									}  
								?>
								</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">
								
								<?php if($basic_information[0]['program'] == '21' || $basic_information[0]['program'] == '22'){
										echo "About the Enterprise";  
									}else if($basic_information[0]['program'] == '31'){
										echo "Enterprise &Innovation challenge";
									}else{
										echo "Enterprise";
									}  
								?>
								</a></li>
								<?php  if ($basic_information[0]['program'] != '28' && $basic_information[0]['program'] != '31'){ ?>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">
								
								<?php if($basic_information[0]['program'] == '21' || $basic_information[0]['program'] == '22'){
									echo "About the Business model";  
									}else if($basic_information[0]['program'] == '23'){
										echo "Funding details & Support";
									}else{
										echo "Impact";
									}  
								?>
								
								</a></li>
								<?php } ?>
									<?php if($basic_information[0]['program'] == '21' && date('Y-m-d', strtotime($basic_information[0]['created_date']))  >= date('2024-01-01')){ ?>
									
									<?php }else{ ?>
								<?php if($basic_information[0]['program'] == '14' || $basic_information[0]['program'] == '21' || $basic_information[0]['program'] == '22') { ?>
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/about_business/' . $application_id; ?>">
								
								<?php if($basic_information[0]['program'] == '21' || $basic_information[0]['program'] == '22'){
									echo "Impact of the business";  
									}else{
										echo "Business";
									}  
								?>
								<?php } ?>
								</a></li>
								<?php } ?>
								<?php  if (php72_cmp($basic_information[0]['program']) != 33 &&php72_cmp($basic_information[0]['program']) != 0 && php72_cmp($basic_information[0]['program']) != 21 && $basic_information[0]['program'] != '28' && php72_cmp($basic_information[0]['program']) != 22 && php72_cmp($basic_information[0]['program']) !=34 && php72_cmp($basic_information[0]['program']) != 23 && php72_cmp($basic_information[0]['program']) != 31  && php72_cmp($basic_information[0]['program']) != 24 && php72_cmp($basic_information[0]['program']) != 26 && php72_cmp($basic_information[0]['program']) != 27 && php72_cmp($basic_information[0]['program']) != 29) {  ?>
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/support_info/' . $application_id; ?>">Support</a></li>
								<?php } ?>
								<?php  if (php72_cmp($basic_information[0]['program']) == 25 || php72_cmp($basic_information[0]['program']) == 34) {  ?>
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/gmt_info/' . $application_id; ?>">GTM related information </a></li>
								<?php } ?>
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                 <div class="tab-slider--container tab-content">
                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="basicForm" action="<?php echo base_url() . 'index.php/application/update_basic_details'; ?>" autocomplete="off">
                                    <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                    <input type="hidden" name="inv_user_id" value="<?= $basic_information[0]['inv_user_id']; ?>">
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Innovation ID</label>
                                                <?php
                                                if ($basic_information[0]['copy_partner_id'] == '') {
                                                    $inv_id = $basic_information[0]['copy_id'] . "_" . $basic_information[0]['partner_id'] . "_" . $basic_information[0]['partner_count'];
                                                } else {
                                                    $inv_id = $basic_information[0]['copy_id'] . "_" . $basic_information[0]['copy_partner_id'] . "_" . $basic_information[0]['partner_count'];
                                                }
                                                ?>
                                                <input type="text" class="form-control" value="<?= $inv_id; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label><?php 
														if (php72_cmp($basic_information[0]['program']) == 14) {
															echo "Name of the organisation";
														}else{
															echo "Name of Enterprise";
														}
													?><span>*</span></label>
                                                <input type="text" class="form-control fieldDisable" disabled name="txtEnterprise" value="<?= $basic_information[0]['name_of_enterprise']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label><?php 
														if (php72_cmp($basic_information[0]['program']) == 14) {
															echo "Name of the woman founder/ co-founder";
														}else{
															echo "Name of Entrepreneur";
														}
													?><span>*</span></label>
                                                <input type="text" class="form-control fieldDisable" disabled name="txtEntrepreneur" value="<?= $basic_information[0]['name_of_entrepreneur']; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Program</label>
                                                <input type="text" class="form-control" disabled value="<?= $program_name; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Registered Date</label>
                                                <?php
                                                $reg_date = isset($basic_information[0]['created_date']) && $basic_information[0]['created_date'] != '0000-00-00' ? date("d-M-y", strtotime($basic_information[0]['created_date'])) : '-';
                                                ?>
                                                <input type="text" class="form-control" value="<?= $reg_date; ?>" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Submitted Date</label>
                                                <?php
                                                $sub_date = isset($basic_information[0]['submitted_date']) && $basic_information[0]['submitted_date'] != '0000-00-00' ? date("d-M-y", strtotime($basic_information[0]['submitted_date'])) : '-';
                                                ?>
                                                <input type="text" class="form-control" value="<?= $sub_date; ?>" disabled />
                                            </div>
                                        </div>
                                    </div>
									 <?php if (php72_cmp($basic_information[0]['program']) == 0 || php72_cmp($basic_information[0]['program']) == 14 || php72_cmp($basic_information[0]['program']) == 21) { ?>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Address 1<span>*</span></label>
                                                    <textarea class="form-control fieldDisable" name="txtAddressOne" cols="30" rows="3" disabled><?= str_replace(PHP_EOL, '', $basic_information[0]['address_line1']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Address 2</label>
                                                    <textarea class="form-control fieldDisable" name="txtAddressTwo" cols="30" rows="3" disabled><?= nl2br($basic_information[0]['address_line2']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Country<span>*</span></label>
                                                    <select class="form-control fieldDisable" disabled name="txtCountry">
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($country_list as $country) { ?>
                                                            <option value="<?= $country['id']; ?>" <?php
                                                            if ($basic_information[0]['country_id'] == $country['id']) {
                                                                echo 'selected';
                                                            }
                                                            ?>><?= $country['country_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
									<?php if ( php72_cmp($basic_information[0]['program']) == 14 || php72_cmp($basic_information[0]['program']) == 21) { ?>
								  
										<div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Designation<span>*</span></label>
                                                    <input type="text" class="form-control fieldDisable" disabled name="txtEntrepreneur" value="<?= $basic_information[0]['website']; ?>"/>
                                                </div>
                                            </div>
											<?php if(php72_cmp($basic_information[0]['program']) == 21 && php72_cmp($basic_information[0]['impact_of_product']) == 1) { ?>
												<div class="col-12 col-lg-4 col-md-4">
													<div class="form-group">
														<label>City<span>*</span></label>
														<input type="text" class="form-control fieldDisable" disabled name="txtEntrepreneur" value="<?= $basic_information[0]['supporting_doc']; ?>"/>
													</div>
												</div>
												<div class="col-12 col-lg-4 col-md-4">
													<div class="form-group">
														<label>Please select the criteria you fit under<span>*</span></label>
														<?php $abtVills =  php72_implode(',',unserialize($basic_information[0]['impact_product']));  ?>
														
														<input type="text" class="form-control" value="<?= $abtVills; ?>" disabled />
													</div>
												</div>
											
											<?php } ?>
                                           
                                        </div>
								   <?php } ?>
								   <?php if(php72_cmp($basic_information[0]['program']) == 21 && php72_cmp($basic_information[0]['impact_of_product']) == 1  ) { ?>
								   <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
													<div class="form-group">
														 <label>Please specify if you are the participant or applying on their behalf<span>*</span></label>
														 <input type="text" class="form-control fieldDisable" disabled name="txtEntrepreneur" value="<?= $basic_information[0]['benificiary']; ?>"/>
													</div>
												</div>
											<?php if(php72_cmp($basic_information[0]['program']) == 21 && php72_cmp($basic_information[0]['impact_of_product']) == 1) { ?>
												<div class="col-12 col-lg-4 col-md-4">
													<div class="form-group">
														<label>Gender of the participant<span>*</span></label>
														<input type="text" class="form-control fieldDisable" disabled name="txtEntrepreneur" value="<?= $basic_information[0]['gender']; ?>"/>
													</div>
												</div>
												<?php if(date('Y-m-d', strtotime($basic_information[0]['created_date']))  >= date('2024-01-01')){ ?>
													<div class="col-12 col-lg-4 col-md-4">
														<div class="form-group">
															<label>State<span>*</span></label>
															<input type="text" class="form-control fieldDisable" disabled name="txtEntrepreneur" value="<?= $basic_information[0]['state']; ?>"/>
														</div>
													</div>
												<?php } ?>
											
											<?php } ?>
                                           
                                        </div>
										
								   <?php } ?>
								   
								   
								   
                                    <?php if (php72_cmp($basic_information[0]['program']) == 0 || php72_cmp($basic_information[0]['program']) == 11 || php72_cmp($basic_information[0]['program']) == 13) { ?>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Address 1<span>*</span></label>
                                                    <textarea class="form-control fieldDisable" name="txtAddressOne" cols="30" rows="3" disabled><?= str_replace(PHP_EOL, '', $basic_information[0]['address_line1']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Address 2</label>
                                                    <textarea class="form-control fieldDisable" name="txtAddressTwo" cols="30" rows="3" disabled><?= nl2br($basic_information[0]['address_line2']); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Country<span>*</span></label>
                                                    <select class="form-control fieldDisable" disabled name="txtCountry">
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($country_list as $country) { ?>
                                                            <option value="<?= $country['id']; ?>" <?php
                                                            if ($basic_information[0]['country_id'] == $country['id']) {
                                                                echo 'selected';
                                                            }
                                                            ?>><?= $country['country_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Email<span>*</span></label>
                                                <input type="text" class="form-control" disabled name="txtEmail" id="txtEmail" value="<?= $basic_information[0]['email_id']; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Mobile<span>*</span></label>
                                                <input type="text" class="form-control fieldDisable" disabled name="txtMobile" value="<?= $basic_information[0]['mobile_no']; ?>"/>
                                            </div>
                                        </div>
                                        <?php if ($this->session->userdata('user_type') == 'superadmin') { ?>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Partner<span>*</span></label>
                                                    <select name="txtPartner" id="txtPartner" class="form-control fieldDisable" disabled>
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($branch as $partner) { ?>
                                                            <option value="<?= $partner['id']; ?>" <?php
                                                            if ($basic_information[0]['partner_id'] == $partner['id']) {
                                                                echo 'selected';
                                                            }
                                                            ?>><?= $partner['partner_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Partner<span>*</span></label>
                                                    <input type="text" class="form-control" disabled name="txtPartner" value="<?= $this->session->userdata('partner_name'); ?>"/>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
									
									 <?php if (php72_cmp($basic_information[0]['program']) == 30 ||php72_cmp($basic_information[0]['program']) == 38 ) { ?>
									   <div class="row">
											<div class="col-12 col-lg-4 col-md-4">
										
												<div class="form-group">
												<label><?php if(php72_cmp($basic_information[0]['program']) == 38){ echo "Type of Entity"; }else { echo "Type of registration"; } ?> </label>
													<?php if(php72_cmp($basic_information[0]['program']) == 38){ ?>
													<div class="form-check form-check-inline">
														<input class="form-check-input fieldDisable" disabled type="radio" name="txtProfitEntity" id="txtProfit11" value="Private Limited" <?php if ($basic_information[0]['india_based'] == 'Private Limited') echo "checked=checked"; ?>>
														<label class="form-check-label" for="txtProfit1">Private Limited</label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input fieldDisable" disabled type="radio" name="txtProfitEntity" id="txtProfit12" value="LLP" <?php if ($basic_information[0]['india_based'] == 'LLP') echo "checked=checked"; ?>>
														<label class="form-check-label" for="txtProfit2">LLP</label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input fieldDisable" disabled type="radio" name="txtProfitEntity" id="txtProfit13" value="Sole proprietorship" <?php if ($basic_information[0]['india_based'] == 'Sole proprietorship') echo "checked=checked"; ?>>
														<label class="form-check-label" for="txtProfit2">Sole proprietorship</label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input fieldDisable" disabled type="radio" name="txtProfitEntity" id="txtProfit14" value="Others" <?php if ($basic_information[0]['india_based'] == 'Others') echo "checked=checked"; ?>>
														<label class="form-check-label" for="txtProfit2">Others</label>
													</div>
													<?php }else { ?>
													<div class="form-check form-check-inline">
														<input class="form-check-input fieldDisable" disabled type="radio" name="txtProfit" id="txtProfit1" value="Profit" <?php if ($basic_information[0]['india_based'] == 'Profit') echo "checked=checked"; ?>>
														<label class="form-check-label" for="txtProfit1">Profit</label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input fieldDisable" disabled type="radio" name="txtProfit" id="txtProfit2" value="Not For Profit" <?php if ($basic_information[0]['india_based'] == 'Not For Profit') echo "checked=checked"; ?>>
														<label class="form-check-label" for="txtProfit2">Not For Profit</label>
													</div>
													
													<?php } ?>
												</div>
											</div>
											<?php if (php72_cmp($basic_information[0]['program']) == 38 ) { ?>
											<div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>Website Url<span>*</span></label>
													<input type="text" class="form-control fieldDisable" disabled name="txtEnterprise" value="<?= $basic_information[0]['website']; ?>"/>
												</div>
											</div>
											<?php }else{ ?>
												<div class="col-12 col-lg-4 col-md-4">
													<div class="form-group">
														<label>Website Url<span>*</span></label>
														<input type="text" class="form-control fieldDisable" disabled name="txtEnterprise" value="<?= $inv_ent_info[0]['website_url']; ?>"/>
													</div>
												</div>
											<?php } ?>
											
											
											<div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>Registered Address<span>*</span></label>
													<?php //<input type="text" class="form-control fieldDisable" disabled name="txtEntrepreneur" value="<?= $basic_information[0]['address1']; ?> 
													<textarea class="form-control fieldDisable" name="txtEntrepreneur" cols="30" rows="3" disabled><?= str_replace(PHP_EOL, '', $basic_information[0]['address1']); ?></textarea>
												</div>
											</div>
											
										</div>
										
										 <div class="row">
											<div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>City<span>*</span></label>
													<?php if (php72_cmp($basic_information[0]['program']) == 38 ) { ?>
														<input type="text" class="form-control fieldDisable" disabled name="txtEntrepreneur" value="<?= $basic_information[0]['impact_product']; ?>"/>
													<?php }else{ ?>
														<input type="text" class="form-control fieldDisable" disabled name="txtEntrepreneur" value="<?= $inv_ent_info[0]['city']; ?>"/>
													<?php } ?>
												</div>
											</div>
											 <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Country<span>*</span></label>
                                                    <select class="form-control fieldDisable" disabled name="txtCountry">
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($country_list as $country) { ?>
                                                            <option value="<?= $country['id']; ?>" <?php
                                                            if ($basic_information[0]['country_id'] == $country['id']) {
                                                                echo 'selected';
                                                            }
                                                            ?>><?= $country['country_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
											<div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>Short description of your organisation<span>*</span></label>
													<input type="text" class="form-control fieldDisable" disabled name="txtEntrepreneur" value="<?= $basic_information[0]['address2']; ?>"/>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>CIN number</label>
													<?php if (php72_cmp($basic_information[0]['program']) == 38 ) { ?>
														<input type="text" class="form-control" value="<?=  $basic_information[0]['cin_number']; ?>" disabled />
													<?php }else{ ?>
														<input type="text" class="form-control" value="<?=  $inv_ent_info[0]['cin']; ?>" disabled />
													<?php } ?>
												</div>
											</div>
											 <div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>DPIIT Number</label>
													 <?php if (php72_cmp($basic_information[0]['program']) == 38 ) { ?>
														<input type="text" class="form-control" value="<?=  $basic_information[0]['product_service']; ?>" disabled />
													<?php }else{ ?>
														<input type="text" class="form-control" value="<?=  $inv_ent_info[0]['primary_point']; ?>" disabled />
													<?php } ?>
												</div>
											</div>
											
											<?php if (php72_cmp($basic_information[0]['program']) == 38 ) { ?>

											
												  <div class="col-12 col-lg-4 col-md-4">
													<div class="form-group">
														<label>State<span>*</span></label>
														<select class="form-control fieldDisable" disabled name="txtCountry">
															<option value="">--Select--</option>
															<?php foreach ($stateLists as $stateData) { ?>
																<option value="<?= $stateData['id']; ?>" <?php
																if ($basic_information[0]['state'] == $stateData['id']) {
																	echo 'selected';
																}
																?>><?= $stateData['state_name']; ?></option>
															<?php } ?>
														</select>
													</div>
                                            </div>
											<?php } ?>
											
												
										</div>
									<?php } ?>
									
									
									
                                    <?php if (php72_cmp($basic_information[0]['program']) == 9) { ?>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Sector<span>*</span></label>
                                                    <select class="form-control fieldDisable" disabled name="txtSector" id="txtSector" onchange="incSubSector(this.value);">
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($sector_details as $index => $row) { ?>
                                                            <option value="<?php echo $row['id']; ?>" <?php
                                                            if ($basic_information[0]['sector_id'] == $row['id']) {
                                                                echo 'selected';
                                                            }
                                                            ?>><?php echo $row['sector']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else if (php72_cmp($basic_information[0]['program']) == 10) { ?>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <input type="text" class="form-control" disabled value="<?= ucfirst($basic_information[0]['gender']); ?>"/>
                                                </div>
                                            </div>
                                            <?php $dob = isset($basic_information[0]['dob']) && $basic_information[0]['dob'] != '0000-00-00' ? date("d-M-y", strtotime($basic_information[0]['dob'])) : '-'; ?>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Date of Birth</label>
                                                    <input type="text" class="form-control" disabled value="<?= $dob; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Sector</label>
                                                    <input type="text" class="form-control" disabled value="<?= $basic_information[0]['sector_name']; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Sub Sector</label>
                                                    <input type="text" class="form-control" disabled value="<?= $basic_information[0]['sub_sector']; ?>"/>
                                                </div>
                                            </div> 
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>If Others, specify</label>
                                                    <input type="text" class="form-control" disabled value="<?= $basic_information[0]['sub_sector_other']; ?>"/>
                                                </div>
                                            </div> 
                                        </div>                                           
                                    <?php } else if (php72_cmp($basic_information[0]['program']) == 12) { ?> 
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Alternate Mobile<span>*</span></label>
                                                    <input type="text" class="form-control" disabled value="<?= $basic_information[0]['phone_no']; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Sector<span>*</span></label>
                                                    <input type="text" class="form-control" disabled value="Health"/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Sub Sector<span>*</span></label>
                                                    <input type="text" class="form-control" disabled value="<?= $basic_information[0]['business_category']; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Sector<span>*</span></label>
                                                    <select class="form-control fieldDisable" disabled name="txtSector" id="txtSector" onchange="incSubSector(this.value);">
                                                        <option value="">--Select--</option>
                                                        <?php foreach ($sector_details as $index => $row) { ?>
                                                            <option value="<?php echo $row['id']; ?>" <?php
                                                            if ($basic_information[0]['sector_id'] == $row['id']) {
                                                                echo 'selected';
                                                            }
                                                            ?>>
															<?php 
															
															if($basic_information[0]['program'] == '26'){
																if($row['sector'] =='Education & Employability'){
																	echo 'Agri or Agri allied'; 
																}if($row['sector'] =='Agri-business'){
																	echo 'Dairy'; 
																}else if($row['sector'] =='Climate Action'){
																	echo 'Textile'; 
																}else if($row['sector'] =='Health'){
																	echo 'Art & Crafts'; 
																}else if($row['sector'] =='Others'){
																	echo 'Others or Multi-sector'; 
																}
																
															}else{
																	echo $row['sector'];
															}
															
															 ?>
															 </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
											<?php if($basic_information[0]['program'] != '26' && $basic_information[0]['program'] != '31'){ ?>
                                            <div class="col-12 col-lg-4 col-md-4"> 
                                                <div class="form-group">
                                                    <label>Sub Sector<span>*</span></label>
                                                    <select class="form-control fieldDisable" disabled name="txtSubSector" id="incsub_sector">
                                                        <option value="">--Select--</option>
                                                    </select>
                                                </div>
                                            </div>
											<?php } ?>
											<?php if( $basic_information[0]['program'] != '30' && $basic_information[0]['program'] != '31'){ ?>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label><?php 
													if (php72_cmp($basic_information[0]['program']) == 23) {  
														echo "Type of Organization";
													}else{
														echo "Is Your Enterprise a";
													}
													?>
													<a href="javascript:(void)" id="profit_hint">(?)</a><span>*</span></label>
                                                    <div id="dialog" title="Information" style="display:none;height:100px;">
                                                        <p>
                                                            <b>For-profit:</b> Incubatee must be registered or plans to register as a Private Limited Company<br />
                                                            <b>Non-profit:</b> Incubatee is registered or plans to register as a Society, Trust or Section 25 Company
                                                        </p>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="txtProfit" id="txtProfit1" value="profit" <?php if ($basic_information[0]['ent_type'] == 'profit') echo "checked=checked"; ?>>
                                                        <label class="form-check-label" for="txtProfit1">For-profit organization</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="txtProfit" id="txtProfit2" value="nonprofit" <?php if ($basic_information[0]['ent_type'] == 'nonprofit') echo "checked=checked"; ?>>
                                                        <label class="form-check-label" for="txtProfit2">Non-profit organization</label>
                                                    </div>
                                                    <label for="txtProfit" class="error"></label>
                                                </div>
                                            </div>
											
                                        </div>
										<?php }else if( $basic_information[0]['program'] == '31'){
											
											?>
										<div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Type of Organization<a href="javascript:(void)" id="profit_hint">(?)</a><span>*</span></label>
                                                    <div id="dialog" title="Information" style="display:none;height:100px;">
                                                        <p>
                                                            <b>For-profit:</b> Incubatee must be registered or plans to register as a Private Limited Company<br />
                                                            <b>Non-profit:</b> Incubatee is registered or plans to register as a Society, Trust or Section 25 Company
                                                        </p>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="compnay_types" id="compnay_types" value="For Profit" <?php if ($basic_information[0]['ent_type'] == 'For Profit') echo "checked=checked"; ?>>
                                                        <label class="form-check-label" for="txtProfit1">For-profit</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="compnay_types" id="compnay_types" value="Non-Profit" <?php if ($basic_information[0]['ent_type'] == 'Non-Profit') echo "checked=checked"; ?>>
                                                        <label class="form-check-label" for="txtProfit2">Non-profit</label>
                                                    </div>
                                                    <label for="txtProfit" class="error"></label>
                                                </div>
                                            </div>
											
										<?php } ?>
										
										<?php if (php72_cmp($basic_information[0]['program']) == 23 || php72_cmp($basic_information[0]['program']) == 31) {  ?>
										<div class="row">
										 <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Date of registration of your organisation</label>
                                                <?php
                                                $reg_date = isset($basic_information[0]['dob']) && $basic_information[0]['dob'] != '0000-00-00' ? date("d-M-y", strtotime($basic_information[0]['dob'])) : '-';
                                                ?>
                                                <input type="text" class="form-control" value="<?= $reg_date; ?>" disabled />
                                            </div>
                                        </div>
										 <div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>Website URL</label>
                                                <input type="text" class="form-control" value="<?=  $inv_ent_info[0]['website_url']; ?>" disabled />
                                            </div>
                                        </div>
										<div class="col-12 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label>PAN Number</label>
                                                <input type="text" class="form-control" value="<?=  $inv_ent_info[0]['pan']; ?>" disabled />
                                            </div>
                                        </div>
										
										
											 <div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>City</label>
													 <input type="text" class="form-control" value="<?=  $inv_ent_info[0]['city']; ?>" disabled />
												</div>
											</div>
											
											 <div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>
													<?php 
															if(php72_cmp($basic_information[0]['program']) == 31){
																echo "Designation of the applicant in the compan";
															}else{
																echo "Qualification of the Entrepreneur";
															}
													?>
													
													</label>
													 <input type="text" class="form-control" value="<?=  $basic_information[0]['website']; ?>" disabled />
												</div>
											</div>
											<div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>Pin code</label>
													<input type="text" class="form-control" value="<?=  $inv_ent_info[0]['tech_challege']; ?>" disabled />
												</div>
											</div>
                                       
										
											<div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>Short description of your organisation</label>
													<input type="text" class="form-control" value="<?=  $inv_ent_info[0]['startup_challenge']; ?>" disabled />
												</div>
											</div>
											 <div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>Registered Address</label>
													 <input type="text" class="form-control" value="<?=  $basic_information[0]['address1']; ?>" disabled />
												</div>
											</div>
											<div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>Which geographies are you operational in</label>
													<input type="text" class="form-control" value="<?=  $inv_ent_info[0]['support_name']; ?>" disabled />
												</div>
											</div>
                                        
											<div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>CIN number</label>
													<input type="text" class="form-control" value="<?=  $inv_ent_info[0]['cin']; ?>" disabled />
												</div>
											</div>
											 <div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>DPIIT Number</label>
													 <input type="text" class="form-control" value="<?=  $inv_ent_info[0]['primary_point']; ?>" disabled />
												</div>
											</div>
											
											<div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>Email</label>
													<input type="text" class="form-control" value="<?=  $basic_information[0]['email_id']; ?>" disabled />
												</div>
											</div>
                                       
											<div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>Mobile</label>
													<input type="text" class="form-control" value="<?=  $basic_information[0]['mobile_no']; ?>" disabled />
												</div>
											</div>
											
											
                                     
										
										<?php }else{ 
											
										
										?>
										
										
                                        <div class="row">
										 <?php if($basic_information[0]['program'] != '26' && $basic_information[0]['program'] != '38' && $basic_information[0]['program'] != '30' && $basic_information[0]['program'] != '31'){ ?>
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label><?php 
													if (php72_cmp($basic_information[0]['program']) == 14) { 
														echo "Is your social enterprise headquartered in India";
													}else if (php72_cmp($basic_information[0]['program']) == 21 || php72_cmp($basic_information[0]['program']) == 27) { 
														echo "Is your enterprise headquartered in India";
													}else{
														echo "Will your social enterprise be based in India";
													}
													echo ' '.$basic_information[0]['india_based'];
													
													?><span>*</span></label>
													
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="txtIndiaq" id="txtIndia1q" value="yes" <?php if ($basic_information[0]['india_based'] == 'yes') echo "checked=checked"; ?>>
                                                        <label class="form-check-label" for="txtIndia1q">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="txtIndiaq" id="txtIndia2q" value="no" <?php if ($basic_information[0]['india_based'] == 'no') echo "checked=checked"; ?>>
                                                        <label class="form-check-label" for="txtIndia2q">No</label>
                                                    </div>
                                                    <label for="txtIndia" class="error"></label>
                                                </div>
												
                                            </div>
											
										<?php }  ?>
                                            <?php
                                            $benificary_val = unserialize($basic_information[0]['benificiary']);
											
											$impact_of_product = unserialize($basic_information[0]['impact_of_product']);
												
                                            ?>
											
											<?php  
											if ((php72_cmp($basic_information[0]['program']) != 31 && php72_cmp($basic_information[0]['program']) != 21 && php72_cmp($basic_information[0]['program']) != 22) && php72_cmp($basic_information[0]['program']) != 27 && $basic_information[0]['program'] != '30') {  ?>
											
                                            <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Who will be the beneficiaries of your product/services?<span><?php if($basic_information[0]['program']!='33'){ echo"*"; }else { echo"";} ?> </span></label>
                                                    
													<select class="form-control fieldDisable" disabled multiple name="txtBeneficiary[]" id="txtBeneficiary" >
                                                        <?php if(php72_cmp($basic_information[0]['program']) == 38){ ?>
															<option value="Rural Population" <?php if (php72_in_array('Rural Population', $benificary_val)) echo "selected"; ?>>Rural Population</option>
															<option value="Peri-Urban Population" <?php if (php72_in_array('Peri-Urban Population', $benificary_val)) echo "selected"; ?>>Peri-Urban Population</option>
															<option value="Urban Population" <?php if (php72_in_array('Urban Population', $benificary_val)) echo "selected"; ?>>Urban Population</option>
															
                                                        <?php }else{ ?>
															<option value="People at the base of the pyramid" <?php if (php72_in_array('People at the base of the pyramid', $benificary_val)) echo "selected"; ?>>People at the base of the pyramid</option>
															<option value="Rural poor" <?php if (php72_in_array('Rural poor', $benificary_val)) echo "selected"; ?>>Rural poor</option>
															<option value="Urban poor" <?php if (php72_in_array('Urban poor', $benificary_val)) echo "selected"; ?>>Urban poor</option>
															<option value="Rural or urban middle income" <?php if (php72_in_array('Rural or urban middle income', $benificary_val)) echo "selected"; ?>>Rural or urban middle income</option>
															<option value="Rural or urban high income" <?php if (php72_in_array('Rural or urban high income', $benificary_val)) echo "selected"; ?>>Rural or urban high income</option>
														
                                                        <?php } ?>
														
													</select>
                                                    <div id="beneficiary_err"></div>
                                                </div>
                                            </div>
											
											<?php  if(php72_cmp($basic_information[0]['program']) == 38){ ?>
												<div class="col-12 col-lg-4 col-md-4">
													 <div class="form-group">
														<label>How will you define the primary clients of your innovation?<span><?php if($basic_information[0]['program']!='33'){ echo"*"; }else { echo"";} ?> </span></label>
														
														<select class="form-control fieldDisable" disabled multiple name="txtclients[]" id="txtclients" >
															<option value="Households" <?php if (php72_in_array('Households', $impact_of_product)) echo "selected"; ?>>Households</option>
															<option value="Urban Local Bodies" <?php if (php72_in_array('Urban Local Bodies', $impact_of_product)) echo "selected"; ?>>Urban Local Bodies</option>
															<option value="Govt Institutions" <?php if (php72_in_array('Govt Institutions', $impact_of_product)) echo "selected"; ?>>Govt Institutions</option>
															<option value="Private institutions/Corporates" <?php if (php72_in_array('Private institutions/Corporates', $impact_of_product)) echo "selected"; ?>>Private institutions/Corporates</option>
														</select>
														<div id="beneficiary_err"></div>
													</div>
												</div>
											<?php  } ?>
											
											<?php if (php72_cmp($basic_information[0]['program']) == 38 ) { ?>
											<div class="col-12 col-lg-4 col-md-4">
												<div class="form-group">
													<label>Website<span>*</span></label>
													<input type="text" class="form-control fieldDisable" disabled name="txtEnterprise" value="<?= $basic_information[0]['sub_sector_other']; ?>"/>
												</div>
											</div>
											<?php }?>
											
											
											<?php if($basic_information[0]['program'] == '29'){ if (php72_in_array('Others', $benificary_val)){  ?>
												<div class="form-group" style="margin-left: 14px; ">
													<label>Please Mention</label>
													<input type="text" class="form-control" value="<?=  $basic_information[0]['cin_number']; ?>" disabled />
												</div>
											<?php } } ?>
											
											<?php if($basic_information[0]['program'] == '26' || php72_cmp($basic_information[0]['program']) != 27 && php72_cmp($basic_information[0]['program']) != 25  && php72_cmp($basic_information[0]['program']) != 38  && php72_cmp($basic_information[0]['program']) != 34 && $basic_information[0]['program'] != '30' && $basic_information[0]['program'] != '31' && $basic_information[0]['program'] != '33'){ 
											
											$product_service = unserialize($basic_information[0]['product_service']);
											
											?>
											<div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Who will be the beneficiaries of your product/service?<span>*</span></label>
                                                    <select class="form-control fieldDisable" disabled multiple name="product_service[]" id="product_service" >
                                                        <option value="Livelihood generation and/or improvement" <?php if (php72_in_array('Livelihood generation and/or improvement', $product_service)) echo "selected"; ?>>Livelihood generation and/or improvement</option>
                                                        <option value="Renewable energy utilisation" <?php if (php72_in_array('Renewable energy utilisation', $product_service)) echo "selected"; ?>>Renewable energy utilisation</option>
                                                        <option value="Gender inclusion" <?php if (php72_in_array('Gender inclusion', $product_service)) echo "selected"; ?>>Gender inclusion</option>
                                                     </select>
                                                    <div id="beneficiary_err"></div>
                                                </div>
                                            </div>
											
											<?php }  ?>
											
											<?php if($basic_information[0]['program'] != '27' && $basic_information[0]['program'] != '31'&& $basic_information[0]['program'] != '38'){ ?>
												<div class="col-12 col-lg-4 col-md-4">
													<div class="form-group">
														<label><?php 
														if (php72_cmp($basic_information[0]['program']) == 14) { 
															echo "What type of impact will your product / service have on low-income populations";
														}else{
															echo "What type of impact will your Product / service have on the BoP / poor?";
														}
														
														?><span>*</span></label>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="txtImpact" id="txtImpact1" value="Direct" <?php if ($basic_information[0]['impact_of_product'] == 'Direct') echo "checked=checked"; ?>>
															<label class="form-check-label" for="txtImpact1">Direct</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="txtImpact" id="txtImpact2" value="Indirect" <?php if ($basic_information[0]['impact_of_product'] == 'Indirect') echo "checked=checked"; ?>>
															<label class="form-check-label" for="txtImpact2">Indirect</label>
														</div>
														<label for="txtImpact" class="error"></label>
													</div>
												</div>
											<?php } ?>
											
											<?php } ?>
											<?php  if (php72_cmp($basic_information[0]['program']) == 27) { ?>
											  <div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label>Is your enterprise women led - owned and controlled by a woman or a group of women having a minimum financial interest of 50% of capital in the startup?<span>*</span></label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="txtIndia" id="txtIndia1" value="yes" <?php if ($basic_information[0]['product_service'] == 'yes') echo "checked=checked"; ?>>
                                                        <label class="form-check-label" for="txtIndia1">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input fieldDisable" disabled type="radio" name="txtIndia" id="txtIndia2" value="no" <?php if ($basic_information[0]['product_service'] == 'no') echo "checked=checked"; ?>>
                                                        <label class="form-check-label" for="txtIndia2">No</label>
                                                    </div>
                                                    <label for="txtIndia" class="error"></label>
                                                </div>
                                            </div>
											
                                        </div>
										<?php } ?>
										<?php  if (php72_cmp($basic_information[0]['program']) == 27) { ?>
										
											<div class="row">
													<div class="form-group clearfix">
														<label>Supporting documents</label>
														<div class="fileUpload blue-btn btn width100">
															<?php
															if (isset($basic_information[0]['supporting_doc']) && !empty($basic_information[0]['supporting_doc'])) {
																$business_truncate = strlen($basic_information[0]['supporting_doc']) > 20 ? "..." . substr($basic_information[0]['supporting_doc'], -20) : $basic_information[0]['supporting_doc'];
																?>
																<span><?= $business_truncate; ?></span>
																<?php
															} else {
																?>
																<span><i class="fas fa-upload"></i> Upload</span>
															<?php } ?>
															<input type="file" class="uploadlogo" name="business_file" id="business_file" />
															<input type="hidden" name="old_business_file" id="old_business_file" value="<?php echo isset($basic_information[0]['supporting_doc']) ? $basic_information[0]['supporting_doc'] : ''; ?>" />
														</div>
														<?php if (isset($basic_information[0]['supporting_doc']) && !empty($basic_information[0]['supporting_doc'])) { ?>
															<span class="download-btn"><a href="<?php echo host_url() . 'Thrive/uploads/' . $basic_information[0]['supporting_doc']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
															
														<?php } ?>
														<label class="sow_msg error" id="business_file_error"></label>
														<div class="clearfix"></div>
													</div>
												</div>
											</div>
										<?php } ?>
										
										
										<?php } ?>
										
										<?php  if (php72_cmp($basic_information[0]['program']) == 14) { ?>
											<div class="row">
												<div class="col-12 col-lg-4 col-md-4">
													<div class="form-group">
														<label>What type of impact will your product / service have on the environment<span>*</span></label>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="txtImpact_pro" id="txtImpact_pro" value="Direct" <?php if ($basic_information[0]['impact_product'] == 'Direct') echo "checked=checked"; ?>>
															<label class="form-check-label" for="txtImpact1">Direct</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="txtImpact_pro" id="txtImpact_pro" value="Indirect" <?php if ($basic_information[0]['impact_product'] == 'Indirect') echo "checked=checked"; ?>>
															<label class="form-check-label" for="txtImpact2">Indirect</label>
														</div>
														
													</div>
												</div>
												<div class="col-12 col-lg-4 col-md-4">
													<div class="form-group">
														<label>Does your Product/Service impact the environment<span>*</span></label>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="product_service" id="product_service" value="yes" <?php if ($basic_information[0]['product_service'] == 'yes') echo "checked=checked"; ?>>
															<label class="form-check-label" for="txtIndia1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="product_service" id="product_service" value="no" <?php if ($basic_information[0]['product_service'] == 'no') echo "checked=checked"; ?>>
															<label class="form-check-label" for="txtIndia2">No</label>
														</div>
														
													</div>
												</div>
												
											</div>
										<?php } ?>
                                        <div class="row ">
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <div class="text-left">
                                                    <ul class="vitals-links saveLinkView display-hide">
                                                        <li><input type="submit" value="Save" id="saveForm" class="vital_yellow_btn wdt_100"></li>
                                                        <li><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
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
            </div>
        </main>
    </div>
</div>
</div>
</div>
</div>

<?php $this->load->view('vitals_footer.php', array('load_application' => 'application', 'multi_select' => 'multiselect')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#txtBeneficiary').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });
		$('#txtclients').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });
		
		

        var sector_id = "<?php echo $basic_information[0]['sector_id']; ?>";
        incSubSector(sector_id);
    });

    $('.summaryEdit').click(function () {
        $(".fieldDisable").attr("disabled", false);
        $('li.edit').addClass("activeTabs");
        $('li.edit a').addClass("greentab");
        $('.saveLinkView').addClass("display-show");
        $('.saveLinkView').removeClass("display-hide");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').attr("disabled", false);
    });

    $(document).on('click', '#saveForm', function (e) {
        var multiselect_len = $('.multiselect-selected-text').html();
        $("#beneficiary_err").html('');
        if (multiselect_len == 'Select an Option') {
            $("#basicForm").valid();
            e.preventDefault();
            $("#beneficiary_err").html('<label for="txtBeneficiary" class="error">Select beneficiary</label>');
        }
    });

    $('#basicForm').validate({
        rules: {
            "txtEnterprise": "required",
            "txtEntrepreneur": "required",
            "txtAddressOne": "required",
            "txtCountry": "required",
            "txtMobile": "required",
            "txtPartner": "required",
            "txtProfit": "required",
            "txtIndia": "required",
            "txtSector": "required",
            "txtSubSector": "required",
            "txtImpact": "required"
        },
        messages: {
            "txtEnterprise": "Enter enterprise",
            "txtEntrepreneur": "Enter entrepreneur",
            "txtAddressOne": "Enter address",
            "txtCountry": "Select country",
            "txtMobile": "Enter mobile",
            "txtPartner": "Select partner",
            "txtProfit": "Select type",
            "txtIndia": "Select type",
            "txtSector": "Select sector",
            "txtSubSector": "Select sub sector",
            "txtImpact": "Select type"
        }
    });

    function incSubSector(val) {
        var myarray = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/scouting/getSubsector",
            data: {
                sector_id: val
            },
            dataType: 'json',
            success: function (msg) {
                $('#incsub_sector').find('option').not(':first').remove().end();
                $.each(msg, function (i, value) {
                    myarray.push(value.id);
                    $('#incsub_sector').append($('<option>').text(value.sector).attr('value', value.id));
                });
                var subsec_id = "<?php echo $basic_information[0]['sub_sector_id']; ?>";
                if ($.inArray(subsec_id, myarray) != -1) {
                    $('#incsub_sector').val(subsec_id);
                } else {
                    $('#incsub_sector').val('');
                }
            },
        });
    }

    $("#profit_hint").mouseover(function () {
        $("#dialog").dialog({
            modal: true,
            width: 460,
            maxWidth: 500,
            resizable: false,
            dialogClass: "dialogaddSeasons"
        });
    });
</script>

</body>
</html>