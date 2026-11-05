<?php $this->load->view('vitals_header.php', array('main_menu' => 'application', 'page_title' => $innovation_information[0]['name_of_enterprise'] . ' - Innovation Info')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'application', 'application_id' => $application_id, 'page' => 'deals', 'inv_stage' => $innovation_information[0]['stage'])); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <?php $this->load->view('application_options.php', array('application_id' => $application_id, 'stage' => $stage, 'status' => $status, 'assign_incharge_id' => $assign_incharge_id, 'incharge' => $assign_incharge, 'enterprise_name' => $innovation_information[0]['name_of_enterprise'], 'app_stage' => $innovation_information[0]['stage'], 'program' => $innovation_information[0]['program'], 'doc1' => $innovation_information[0]['doc1'], 'doc2' => $innovation_information[0]['doc2'], 'doc3' => $innovation_information[0]['doc3'])); ?>
                <div class="display-hide" id="navLoad">
                    <div class="newCLickTabs">
                        <div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">Enterprise</a></li>
                                <li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">Impact</a></li>
								 <?php if($innovation_information[0]['program'] == '14') { ?>
								 <li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/about_business/' . $application_id; ?>">Business</a></li>
									
								 <?php } ?>
								 <?php if($innovation_information[0]['program'] == '14' || $innovation_information[0]['program'] == '30'|| $innovation_information[0]['program'] == '38') { ?>
								 <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/support_info/' . $application_id; ?>">Support</a></li>
								 <?php } ?>
								 
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-slider--container">
                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                        <main class="page-content">
                            <div class="inputplan-structureall plan-structure-new">
                                <form method="post" id="innovationForm" action="<?php echo base_url() . 'index.php/application/add_innovation_details'; ?>" autocomplete="off">
                                    <input type="hidden" name="inv_id" value="<?= $application_id; ?>">
                                    <input type="hidden" name="inv_user_id" value="<?= $innovation_information[0]['inv_user_id']; ?>">
									
									<?php if($innovation_information[0]['program'] == '30')  { ?>
											<div class="row">
												
													<div class="col-12 col-lg-6 col-md-6">
														<div class="form-group">
															<label>
															
															<?php 
															
															if($innovation_information[0]['program'] == '30' ){ 
																echo "What amount of funding support have you received in the past (grant/equity/debt)"; 
															}else{
																echo"Why do you want to participate in the acceleration program";
															}
															
															?>
															
															<span>*</span></label>
															<textarea class="form-control fieldDisable" cols="30" rows="8" disabled><?= $innovation_information[0]['estimate_qua']; ?></textarea>
														</div>
													</div>
												
													<div class="col-12 col-lg-6 col-md-6 leaveLabel">
														<div class="form-group">
															<label>
															<?php if($innovation_information[0]['program'] == '30'){ 
															echo "If the acceleration program provides grant support of 30L, how do you plan to utilise this?";
															}else{?>
															If the acceleration program provides <?php if($innovation_information[0]['program'] == '27'){ echo"financial assistance";  }else{  echo"grant"; }  ?> support of <?php if($innovation_information[0]['program'] != '27'){ if($innovation_information[0]['program'] == '30'){  echo"30L";}else {echo"35L";} } else { echo"20L"; }?>20L, how do you plan to utilise this<span>*</span></label>
															
															<?php } ?>
															<?php if($innovation_information[0]['program'] == '30'){   ?>
															<span>*</span></label>
															<?php } ?>
															
															<textarea class="form-control fieldDisable" cols="30" rows="8" disabled><?= $innovation_information[0]['company_description']; ?></textarea>
															
															
															
														</div>
														<div id="state_err"></div>
													</div>
												</div>
												
												<div class="row">
												
													<div class="col-12 col-lg-6 col-md-6">
														<div class="form-group">
															<label>
															
															<?php 
															
															echo "How will this program support you in your future growth";
															
															?>
															
															<span>*</span></label>
															<textarea class="form-control fieldDisable" cols="30" rows="8" disabled><?= $innovation_information[0]['tanseed_program']; ?></textarea>
														</div>
													</div>
												
													<div class="col-12 col-lg-6 col-md-6 leaveLabel">
														<div class="form-group">
															<label>
																<?php echo "The program will provide access to CISCO’s technical experts & mentors. Briefly explain how you would be interested to engage with them during the program"; ?>
																
																<?php if($innovation_information[0]['program'] == '30'){   ?>
															<span>*</span></label>
															<?php } ?>
																<textarea class="form-control fieldDisable" cols="30" rows="8" disabled><?= $innovation_information[0]['part_org']; ?></textarea>
															
															
															
														</div>
														<div id="state_err"></div>
													</div>
												</div>
												
												<div class="row">
												<div class="col-12 col-lg-6 col-md-6 leaveLabel">
													<div class="form-group">
														<label>The program aims to provide the below listed support. Please indicate the Top 3 areas of support you would like from us
														<span>*</span></label>
														<?php $villsupport = explode(",", $innovation_information[0]['business_model']); ?>
														<select style="height: calc(1.5em + 10.75rem + 2px) !important;" class="form-control fieldDisable" id="abt_vill" disabled multiple="multiple" name="abt_vill[]" onchange="about_value();">
															<option style="display:<?php echo (in_array('Access to mentors / sector experts',$villsupport))?'block':'none';?>" value=" Access to mentors / sector experts" <?php echo (in_array('Access to mentors / sector experts',$villsupport))?'checked':'';?>> Access to mentors / sector experts</option>
															<option value="Building team’s capacity for market-entry / market-expansion" <?php echo (in_array('Building team’s capacity for market-entry / market-expansion',$villsupport))?'checked':'';?> style="display:<?php echo (in_array('Building team’s capacity for market-entry / market-expansion',$villsupport))?'block':'none';?>"> Building team’s capacity for market-entry / market-expansion</option>
															<option style="display:<?php echo (in_array('Customer introductions / Networks',$villsupport))?'block':'none';?>" value="Customer introductions / Networks" <?php echo (in_array('Customer introductions / Networks',$villsupport))?'checked':'';?>> Customer introductions / Networks</option>
															<option style="display:<?php echo (in_array('Capacity building / Training / on go-to-market strategies',$villsupport))?'block':'none';?>" value="Capacity building / Training / on go-to-market strategies" <<?php echo (in_array('Capacity building / Training / on go-to-market strategies',$villsupport))?'checked':'';?>> Capacity building / Training / on go-to-market strategies</option>
															<option style="display:<?php echo (in_array('Access to Market Insights & Customer Data',$villsupport))?'block':'none';?>" value="Access to Market Insights & Customer Data" <?php echo (in_array('Access to Market Insights & Customer Data',$villsupport))?'checked':'';?>> Access to Market Insights & Customer Data</option>
															<option style="display:<?php echo (in_array('Support on conducting pilots / trials',$villsupport))?'block':'none';?>" value="Support on conducting pilots / trials" <?php echo (in_array('Support on conducting pilots / trials',$villsupport))?'checked':'';?> > Support on conducting pilots / trials</option>
															<option style="display:<?php echo (in_array('Support on end-user financing strategies / connectionsn',$villsupport))?'block':'none';?>" value="Support on end-user financing strategies / connectionsn" <?php echo (in_array('Support on end-user financing strategies / connectionsn',$villsupport))?'checked':'';?>  > Support on end-user financing strategies / connectionsn</option>
															<option style="display:<?php echo (in_array('Testing and strengthening technology',$villsupport))?'block':'none';?>" value="Testing and strengthening technology" <?php echo (in_array('Testing and strengthening technology',$villsupport))?'checked':'';?>  > Testing and strengthening technology</option>
															<option style="display:<?php echo (in_array('Strengthening early stage fintech digital innovations to be gender-inclusive and remove gender biases',$villsupport))?'block':'none';?>" value="Strengthening early stage fintech digital innovations to be gender-inclusive and remove gender biases" <?php echo (in_array('Strengthening early stage fintech digital innovations to be gender-inclusive and remove gender biases',$villsupport))?'checked':'';?>  > Strengthening early stage fintech digital innovations to be gender-inclusive and remove gender biases</option>
															<option style="display:<?php echo (in_array('Business Model validation',$villsupport))?'block':'none';?>" value="Business Model validation" <?php echo (in_array('Business Model validation',$villsupport))?'checked':'';?>  > Business Model validation</option>
															<option  style="display:<?php echo (in_array('Other',$villsupport))?'block':'none';?>" value="Other" <?php echo (in_array('Other',$villsupport))?'checked':'';?>   > Other</option>

														</select>
													</div>
													<div id="state_err"></div>
												</div>
												</div>
												
												
												
									
									<?php }  ?>
									<?php if($innovation_information[0]['program'] == '38')  { ?>
									
									<div class="row">
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>Please provide details on previously conducted pilots within ULBs in Maharashtra<span>*</span></label>
														<textarea class="form-control fieldDisable" cols="30" rows="8" disabled><?= $innovation_information[0]['avg_monthly']; ?></textarea>
													</div>
												</div>
												<div class="col-12 col-lg-6 col-md-6 leaveLabel">
													<div class="form-group">
														<label>What is the demographic profile of the beneficiary group<span>*</span></label>
														<textarea class="form-control fieldDisable" cols="30" rows="8" disabled><?= $innovation_information[0]['demographic_profie']; ?></textarea>
													</div>
													<div id="state_err"></div>
												</div>
											</div>
											<div class="row">
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>How do you quantitatively and qualitatively measure the Environmental Impact (e.g. waste diverted from landfill) of your activity<span>*</span></label>
														<textarea class="form-control fieldDisable" cols="30" rows="8" disabled><?= $innovation_information[0]['primary_benifi']; ?></textarea>
													</div>
												</div>
												<div class="col-12 col-lg-6 col-md-6 leaveLabel">
													<div class="form-group">
														<label>How do you quantitatively and qualitatively measure the Social Impact of your activity<span>*</span></label>
														<textarea class="form-control fieldDisable" cols="30" rows="8" disabled><?= $innovation_information[0]['others_benefit']; ?></textarea>
													</div>
													<div id="state_err"></div>
												</div>
											</div>
											<div class="row">
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>Outline your expected impact in short term, medium term and long term<span>*</span></label>
														<textarea class="form-control fieldDisable" cols="30" rows="8" disabled><?= $innovation_information[0]['inv_impact']; ?></textarea>
													</div>
												</div>
											</div>
										
									<?php }  ?>	
                                    <?php if($innovation_information[0]['program'] == '14')  { ?>
									
								
											
											<div class="row">
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>Why do you want to participate in the acceleration program<span>*</span></label>
														<textarea class="form-control fieldDisable" cols="30" rows="8" disabled><?= $innovation_information[0]['estimate_qua']; ?></textarea>
													</div>
												</div>
												<div class="col-12 col-lg-6 col-md-6 leaveLabel">
													<div class="form-group">
														<label>If the acceleration program provides grant support of 20L, how do you plan to utilise this<span>*</span></label>
														<textarea class="form-control fieldDisable" cols="30" rows="8" disabled><?= $innovation_information[0]['geographic']; ?></textarea>
													</div>
													<div id="state_err"></div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>The program will provide access to CISCO’s technical experts & mentors. Briefly explain how you would be interested to engage with them during the program<span>*</span></label>
														<textarea class="form-control fieldDisable" cols="30" rows="8" disabled><?= $innovation_information[0]['part_org']; ?></textarea>
													</div>
												</div>
												<div class="col-12 col-lg-6 col-md-6 leaveLabel">
													<div class="form-group">
														<label>Through the program, Villgro aims to provide market access support to the enterprise. What areas of support do you require for market access? Please indicate the Top 3 areas of support you would like from us<span>*</span></label>
														<?php $villsupport = explode(",", $innovation_information[0]['business_model']); ?>
														<select style="height: calc(1.5em + 10.75rem + 2px) !important;" class="form-control fieldDisable" id="abt_vill" disabled multiple="multiple" name="abt_vill[]" onchange="about_value();">
															<option style="display:<?php echo (in_array('Access to mentors / sector experts',$villsupport))?'block':'none';?>" value=" Access to mentors / sector experts" <?php echo (in_array('Access to mentors / sector experts',$villsupport))?'checked':'';?>> Access to mentors / sector experts</option>
															<option value="Building team’s capacity for market-entry / market-expansion" <?php echo (in_array('Building team’s capacity for market-entry / market-expansion',$villsupport))?'checked':'';?> style="display:<?php echo (in_array('Building team’s capacity for market-entry / market-expansion',$villsupport))?'block':'none';?>"> Building team’s capacity for market-entry / market-expansion</option>
															<option style="display:<?php echo (in_array('Customer introductions / Networks',$villsupport))?'block':'none';?>" value="Customer introductions / Networks" <?php echo (in_array('Customer introductions / Networks',$villsupport))?'checked':'';?>> Customer introductions / Networks</option>
															<option style="display:<?php echo (in_array('Capacity building / Training / on go-to-market strategies',$villsupport))?'block':'none';?>" value="Capacity building / Training / on go-to-market strategies" <<?php echo (in_array('Capacity building / Training / on go-to-market strategies',$villsupport))?'checked':'';?>> Capacity building / Training / on go-to-market strategies</option>
															<option style="display:<?php echo (in_array('Access to Market Insights & Customer Data',$villsupport))?'block':'none';?>" value="Access to Market Insights & Customer Data" <?php echo (in_array('Access to Market Insights & Customer Data',$villsupport))?'checked':'';?>> Access to Market Insights & Customer Data</option>
															<option style="display:<?php echo (in_array('Support on conducting pilots / trials',$villsupport))?'block':'none';?>" value="Support on conducting pilots / trials" <?php echo (in_array('Support on conducting pilots / trials',$villsupport))?'checked':'';?> > Support on conducting pilots / trials</option>
															<option style="display:<?php echo (in_array('Support on end-user financing strategies / connectionsn',$villsupport))?'block':'none';?>" value="Support on end-user financing strategies / connectionsn" <?php echo (in_array('Support on end-user financing strategies / connectionsn',$villsupport))?'checked':'';?>  > Support on end-user financing strategies / connectionsn</option>
															<option  style="display:<?php echo (in_array('Other',$villsupport))?'block':'none';?>" value="Other" <?php echo (in_array('Other',$villsupport))?'checked':'';?>   > Other</option>

														</select>
													</div>
													<div id="state_err"></div>
												</div>
											</div>
											
                                        <div class="row ">
                                            <div class="col-12 col-sm-6 col-md-6">
                                                <div class="text-left">
                                                    <ul class="vitals-links saveLinkView display-hide">
                                                        <li><input type="submit" value="Save" id="saveForm" class="vital_yellow_btn wdt_100"></li>
                                                        <li><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>" class="wdt_100 vital_bordered_btn">Cancel</a></li>
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
        </div>
    </div>
</div>
</div>

<?php $this->load->view('vitals_footer.php', array('load_application' => 'application')); ?>

<script type="text/javascript">
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

    function showSegment(value) {
        if (value == 'yes') {
            $(".showGroup").css('display', 'block');
        } else {
            $(".showGroup").css('display', 'none');
        }
    }

    $('#innovationForm').validate({
        rules: {
            "type_prod": "required",
            "stage_prod": "required",
            "cust_seg": "required"
        },
        messages: {
            "type_prod": "Select type",
            "stage_prod": "Select type",
            "cust_seg": "Select type"
        }
    });
</script>

</body>
</html>