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
                        <div class="scrtabs-allow-scrollbar">
                            <div class="scrtabs-tab-container" style="visibility: visible;"><div class="scrtabs-tab-scroll-arrow scrtabs-tab-scroll-arrow-left" style=""><span class="fas fa-chevron-left"></span></div><div class="scrtabs-tabs-fixed-container" style="width: 1360px;"><div class="scrtabs-tabs-movable-container" style="width: 1360px;"><ul class="nav nav-tabs" role="tablist">
								
                                 
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
								<?php  if ($additional_information[0]['program'] != '32' &&$additional_information[0]['program'] != '28' && $additional_information[0]['program'] != '31'){ ?>
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
								<?php  if ($additional_information[0]['program'] != '32'  && $additional_information[0]['program'] != '0'  && $additional_information[0]['program'] != '28' && $additional_information[0]['program'] != '31' && $additional_information[0]['program'] != '21' && $additional_information[0]['program'] != '22' && $additional_information[0]['program'] != '23' && $additional_information[0]['program'] != '24' && $additional_information[0]['program'] != '25' && $additional_information[0]['program'] != '27') {  ?>
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/support_info/' . $application_id; ?>">Support</a></li>
								<?php } ?>
								<?php  if ($additional_information[0]['program'] == 25) {  ?>
									<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/gmt_info/' . $application_id; ?>">GTM related information </a></li>
								<?php } ?>
								
								
								<li role="presentation"  class=" active"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                  <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="additionalForm" action="<?php echo base_url() . 'index.php/application/add_additional_details'; ?>" enctype="multipart/form-data" autocomplete="off">
                                    <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                    <input type="hidden" name="inv_user_id" value="<?= $additional_information[0]['inv_user_id']; ?>">
									
									
									<?php  if ($additional_information[0]['program'] == '32') { ?>
										<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                   <div>
														 <label>Does the company have an intentional focus on creating impact on underserved populations(rural, women, economically underprivileged) or the environment<span>*</span></label>
															<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="from_villgro1" id="from_villgro1" value="Yes" <?php if ($additional_information[0]['from_villgro'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="from_villgro1" id="from_villgro1" value="No" <?php if ($additional_information[0]['from_villgro'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
												</div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
													<div>
														<label>Do the promoters and/or key managerial persons of the company have a minimum of 3 years of relevant past experience</label>
															<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="support_name1"  value="Yes" <?php if ($additional_information[0]['support_name'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="support_name1"  value="No" <?php if ($additional_information[0]['support_name'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
												</div>
                                            </div>
                                        </div>
										
										<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                   <div>
														 <label>Does the company have at least one set of audited financials without any qualified opinions from the auditors, with operating revenues for 12 months<span>*</span></label>
															<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="inv_idea_ent1" id="inv_idea_ent1" value="Yes" <?php if ($additional_information[0]['inv_idea_ent'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="inv_idea_ent1" id="inv_idea_ent1" value="No" <?php if ($additional_information[0]['inv_idea_ent'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
												</div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
													<div>
														<label>Is the company's monthly revenue at least INR 5 lakhs</label>
															<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="referal_name1"  value="Yes" <?php if ($additional_information[0]['referal_name'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="referal_name1"  value="No" <?php if ($additional_information[0]['referal_name'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
												</div>
                                            </div>
                                        </div>
										
										<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                   <div>
														 <label>Does the company require funding to scale up operations and manage the working capital cycle<span>*</span></label>
															<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="video_url1" id="video_url1" value="Yes" <?php if ($additional_information[0]['video_url'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="video_url1" id="video_url1" value="No" <?php if ($additional_information[0]['video_url'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
												</div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
													<div>
														<label>Has the business raised equity funding in the past 2 years</label>
															<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="won_competition1"  value="Yes" <?php if ($additional_information[0]['won_competition'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="won_competition1"  value="No" <?php if ($additional_information[0]['won_competition'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
												</div>
                                            </div>
                                        </div>
										
										<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                   <div>
														 <label>Does the Company have a positive net worth (Net worth = Share capital + Accumulated reserves and surplus<span>*</span></label>
															<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="ant_org1" id="ant_org1" value="Yes" <?php if ($additional_information[0]['ant_org'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="ant_org1" id="ant_org1" value="No" <?php if ($additional_information[0]['ant_org'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
												</div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
													<div>
														<label>In case the business is incurring losses on a monthly basis, does the company have a
minimum of 9 months' cash reserves to fund business operations and service the debt financing
EMIs during the period</label>
															<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="ant_org_name1"  value="Yes" <?php if ($additional_information[0]['ant_org_name'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="ant_org_name1"  value="No" <?php if ($additional_information[0]['ant_org_name'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
												</div>
                                            </div>
                                        </div>
										
										<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                   <div>
														 <label>Has the company/enterprise received confirmed orders from reputed client(s) and requires
funding for the purchase of raw materials or inventory<span>*</span></label>
															<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="inc_cert1" id="inc_cert1" value="Yes" <?php if ($additional_information[0]['company_entr'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="inc_cert1" id="inc_cert1" value="No" <?php if ($additional_information[0]['company_entr'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
												</div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
													<div>
														<label>The company has no current overdues or past default write-offs and good repayment history
in the credit bureau report</label>
															<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="competition_name1"  value="Yes" <?php if ($additional_information[0]['competition_name'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="competition_name1"  value="No" <?php if ($additional_information[0]['competition_name'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
												</div>
                                            </div>
                                        </div>
										<div class="row">
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                   <div>
														 <label>Do all founders have a CIBIL score >650<span>*</span></label>
															<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="other_funding1" id="other_funding1" value="Yes" <?php if ($additional_information[0]['other_funding'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="other_funding1" id="other_funding1" value="No" <?php if ($additional_information[0]['other_funding'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
												</div>
                                            </div>
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
													<div>
														<label>Does the company have the ability to share MIS projections for at least 18 months, covering
details of revenues, expenses, and receivables</label>
															<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="current_product1"  value="Yes" <?php if ($additional_information[0]['current_product'] == 'Yes') echo "checked=checked"; ?>  >
															<label class="form-check-label" for="with_other_org1">Yes</label>
														</div>
														<div class="form-check form-check-inline">
															<input class="form-check-input fieldDisable" disabled type="radio" name="current_product1"  value="No" <?php if ($additional_information[0]['current_product'] == 'No') echo "checked=checked"; ?> ">
															<label class="form-check-label" for="with_other_org2">No</label>
														</div>
													</div>
												</div>
                                            </div>
                                        </div>
										
									<?php   } ?>
									
									
									
									<?php 
									
									if ($additional_information[0]['program'] == '21') { ?>
									
									
										<?php 
										
										
										if ($additional_information[0]['impact_of_product'] == '1'){ ?>
										
										
										
										 <?php if ($additional_information[0]['prop_model'] == 'No') { ?>
											
										<?php } ?>
										
										<?php } ?>
									
													
										
										
									
									<?php } else{ ?>
                                    <?php if ($additional_information[0]['program'] == '12') { ?>
                                      
                                    <?php } else { ?>
									
									
									
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
														<?php }else if( $additional_information[0]['program'] == '32'){ ?>
														<span class="download-btn"><a href="<?php echo host_url() . 'villgro_debt_access_program/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														
														 <?php }else{ ?>
														 <span class="download-btn"><a href="<?php echo host_url() . 'shelterTech/uploads/' . $additional_information[0]['doc1']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
														
														 <?php } ?>
														
                                                    <?php } ?>
                                                    <label class="sow_msg error" id="business_file_error"></label>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
											
											<div class="col-12 col-lg-4 col-md-4">
                                                <div class="form-group">
                                                    <label><?php  if($additional_information[0]['program'] == '32') { echo "Upload Audited Financial Statement for latest FY"; }else { echo "Additional Information"; } if($additional_information[0]["best_describe"]=='Yes, I have a GTM model in place'){ echo '<span>*<span>';} ?></label>
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
														<?php } else if ($additional_information[0]['program'] == '32') { ?>
													 <span class="download-btn"><a href="<?php echo host_url() . 'villgro_debt_access_program/uploads/' . $additional_information[0]['doc2']; ?>" title="View Document" target="_blank"><i class="fas fa-file-download"></i></a></span>
															
														<?php }else{ ?>
														 <?php } ?>
                                                    <?php } ?>
                                                    <label class="sow_msg error" id="info_file_error"></label>
                                                    <div class="clearfix"></div>
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