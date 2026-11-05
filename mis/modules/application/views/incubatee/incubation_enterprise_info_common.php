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
                        <div class="scrtabs-allow-scrollbar">
                            <div class="scrtabs-tab-container" style="visibility: visible;"><div class="scrtabs-tab-scroll-arrow scrtabs-tab-scroll-arrow-left" style=""><span class="fas fa-chevron-left"></span></div><div class="scrtabs-tabs-fixed-container" style="width: 1360px;"><div class="scrtabs-tabs-movable-container" style="width: 1360px;"><ul class="nav nav-tabs" role="tablist">
								
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">Enterprise</a></li>
                                <?php if($enterprise_information[0]['program'] != 28 && $enterprise_information[0]['program'] != 32){  ?>
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
									
									<?php if($enterprise_information[0]['program'] == '32') { ?>
									 <div class="row">
										<div class="col-12 col-lg-6 col-md-6 leaveLabel">
											<div class="form-group">
												<label>Registered form of your entity<span>*</span></label>
												<?php $operation_val = $enterprise_information[0]['in_operation']; ?>
												<select class="form-control fieldDisable" disabled id="in_operation" name="in_operation">
													<option value="">--Select--</option>
													<option value="Pvt Ltd" <?php
													if ($enterprise_information[0]['develop_product'] == 'Pvt Ltd') {
														echo 'selected';
													}
													?>>Pvt Ltd</option>
													<option value="Non-profit" <?php
													if ($enterprise_information[0]['develop_product'] == 'Non-profit') {
														echo 'selected';
													}
													?>>Non-profit</option>
													<option value="Others" <?php
													if ($enterprise_information[0]['develop_product'] == 'Others') {
														echo 'Others';
													}
													?>>Others</option>
													</select>
												</div>
												<div id="state_err"></div>
											 </div>
											 <div class="col-12 col-lg-6 col-md-6">
												<div class="form-group">
													<label>Will your social enterprise be based in India?<span>*</span></label>
													<div class="form-check form-check-inline">
														<input class="form-check-input fieldDisable" disabled type="radio" name="stage_product1" id="stage_product1" value="Yes" <?php if ($enterprise_information[0]['stage_product'] == 'Yes') echo "checked=checked"; ?> onclick="show_compet(this.value);">
														<label class="form-check-label" for="competition1">Yes</label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input fieldDisable" disabled type="radio" name="stage_product1" id="stage_product1" value="No" <?php if ($enterprise_information[0]['stage_product'] == 'No') echo "checked=checked"; ?> onclick="show_compet(this.value);">
														<label class="form-check-label" for="competition2">No</label>
													</div>
													<label for="competition" class="error"></label>
												</div>
											</div>
									 </div>	

									<div class="row">
										<div class="col-12 col-lg-6 col-md-6">
											<div class="form-group">
												<label>At what stage is your product/service<span>*</span></label>
												 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['business_model']; ?></textarea>
										  
											</div>
										</div>
										<div class="col-12 col-lg-4 col-md-4">
											<div class="form-group">
												<label>At what stage is your enterprise</label>
												<select class="form-control fieldDisable" disabled id="stage_prod" name="stage_prod">
													<option value="">-Select</option>
													<option value="Pre product development" <?php echo ($enterprise_information[0]['hear_abt']=="Pre product development")?"selected":"";?>>Pre product development</option>
													<option value="Pilot/Trials Stage" <?php echo ($enterprise_information[0]['hear_abt']=="Pilot/Trials Stage")?"selected":"";?>>Pilot/Trials Stage</option>
													<option value="Commercialization" <?php echo ($enterprise_information[0]['hear_abt']=="Commercialization")?"selected":"";?>>Commercialization</option>
													<option value="Scaling/Stable Revenue" <?php echo ($enterprise_information[0]['hear_abt']=="Scaling/Stable Revenue")?"selected":"";?>>Scaling/Stable Revenue</option>
												</select>
											</div>
										</div>
									</div> 
									<div class="row">
										<div class="col-12 col-lg-6 col-md-6">
											<div class="form-group">
												<label>Provide a brief description of your product or service<span>*</span></label>
												 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['inv_problem']; ?></textarea>
										  
											</div>
										</div>
										<div class="col-12 col-lg-4 col-md-4">
											<div class="form-group">
												<label>Who will be the beneficiaries of your product/service<span>*</span></label>
												 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['proposal_desc']; ?></textarea>
										  
											</div>
										</div>
									</div> 
									<div class="row">
										<div class="col-12 col-lg-6 col-md-6">
											<div class="form-group">
												<label>What type of impact will your product/service have on the BoP/poor<span>*</span></label>
												 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['inv_risks']; ?></textarea>
										  
											</div>
										</div>
										<div class="col-12 col-lg-4 col-md-4">
											<div class="form-group">
												<label>In which states are you operating/plan to operate<span>*</span></label>
												 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['org_short_desc']; ?></textarea>
											</div>
										</div>
									</div> 
									<div class="row">
										<div class="col-12 col-lg-6 col-md-6">
											<div class="form-group">
												<label>Amount of Debt Required<span>*</span></label>
												 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['inno_prob']; ?></textarea>
										  
											</div>
										</div>
										<div class="col-12 col-lg-4 col-md-4">
											<div class="form-group">
												<label>Purpose/proposed use of funds raised through this program<span>*</span></label>
												 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['pilots']; ?></textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12 col-lg-6 col-md-6">
											<div class="form-group">
												<label>Have you previously accessed credit from any financial institution<span>*</span></label>
												<div class="form-check form-check-inline">
													<input class="form-check-input fieldDisable" disabled type="radio" name="robot_efficient1" id="robot_efficient1" value="Yes" <?php if ($enterprise_information[0]['robot_efficient'] == 'Yes') echo "checked=checked"; ?> onclick="show_compet(this.value);">
													<label class="form-check-label" for="competition1">Yes</label>
												</div>
										  
											</div>
										</div>
										<?php if ($enterprise_information[0]['robot_efficient'] == 'Yes'){ ?>
										<div class="col-12 col-lg-4 col-md-4">
											<div class="form-group">
												<label>If yes, please mention the names of the financial institutions<span>*</span></label>
												 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['avail_alter']; ?></textarea>
											</div>
										</div>
										<?php } ?>
									</div>
									
									<div class="row">
										<div class="col-12 col-lg-6 col-md-6">
											<div class="form-group">
												<label>Have you been incubated, funded, or participated in an accelerator program with another organization<span>*</span></label>
												<div class="form-check form-check-inline">
													<input class="form-check-input fieldDisable" disabled type="radio" name="prop_model1" id="prop_model1" value="Yes" <?php if ($enterprise_information[0]['prop_model'] == 'Yes') echo "checked=checked"; ?> onclick="show_compet(this.value);">
													<label class="form-check-label" for="competition1">Yes</label>
												</div>
											</div>
										</div>
										<?php if ($enterprise_information[0]['prop_model'] == 'Yes'){ ?>
										<div class="col-12 col-lg-4 col-md-4">
											<div class="form-group">
												<label>If yes please mention the details<span>*</span></label>
												 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['ident_risk']; ?></textarea>
											</div>
										</div>
										<?php } ?>
									</div>
									<?php  }else if( $enterprise_information[0]['program'] == '37'){ ?>
										
										 <div class="row">
											<div class="col-12 col-lg-6 col-md-6 ">
												<div class="form-group">
													<label>Registered form of your entity<span>*</span></label>
													<?php $operation_val = $enterprise_information[0]['in_operation']; ?>
													<select class="form-control fieldDisable" disabled id="in_operation" name="in_operation">
														<option value="">--Select--</option>
														 <option value="0to6" <?php echo ($enterprise_information[0]["in_operation"]=="0to6")?"selected":"";?>>0 – 6 months</option>
															<option value="6to12" <?php echo ($enterprise_information[0]["in_operation"]=="6to12")?"selected":"";?>>6 – 12 months</option>
															<option value="1" <?php echo ($enterprise_information[0]["in_operation"]=="1")?"selected":"";?>>1 year </option>
															<option value="2" <?php echo ($enterprise_information[0]["in_operation"]=="2")?"selected":"";?>>2 years </option>
															<option value=">2" <?php echo ($enterprise_information[0]["in_operation"]==">2")?"selected":"";?>>> 2 years </option>
														</select>
												</div>
												<div id="state_err"></div>
											 </div>
											 <div class="col-12 col-lg-6 col-md-6 ">
												<div class="form-group">
													<label>State<span>*</span></label>
													<?php 
													
													 $states = explode(',',$enterprise_information[0]['operate_on_state']);

													$state_list = $this->Minnovation->getState(); ?>
													<select  style="height:100px!important" multiple class="form-control fieldDisable" disabled id="in_operation" name="in_operation">
														<option value="">--Select--</option>
														<?php foreach ($state_list as $state): ?>
														<option value="<?= htmlspecialchars($state['id']) ?>"  <?= in_array($state['state_name'], $states) ? 'selected' : '' ?>>

															<?= htmlspecialchars($state['state_name']) ?>
														</option>
													<?php endforeach; ?>
													</select>
												</div>
												<div id="state_err"></div>
											 </div>
											 
										 </div>
										 
										  <div class="row">
											<div class="col-12 col-lg-6 col-md-6 ">
												<div class="form-group">
												<label>Please select if your solution is currently active in any of the following location<span>*</span></label>
												<?php
													$locations = ['Mumbai', 'Bangalore', 'Chennai', 'Pune', 'Bhubaneshwar', 'Jaipur'];
													 $selected_locations = unserialize($enterprise_information[0]['startup_challenge']);
													
													?>

													<select style="height:100px!important" disabled id="location_select" name="locations[]" multiple class="form-control fieldDisable">
														<?php foreach ($locations as $loc): ?>
															<option value="<?= $loc ?>" <?= php72_in_array($loc, $selected_locations) ? 'selected' : '' ?>>
																<?= $loc ?>
															</option>
														<?php endforeach; ?>
													</select>

												</div>
											 </div>
											 <div class="col-12 col-lg-6 col-md-6 ">
												<div class="form-group">
												<label>Are you developing a<span>*</span></label>
												<?php $operation_val = $enterprise_information[0]['in_operation']; ?>
												<select class="form-control fieldDisable" disabled id="in_operation" name="in_operation">
													<option value="">--Select--</option>
													<option value="Pvt Ltd" <?php
													if ($enterprise_information[0]['develop_product'] == 'Product') {
														echo 'selected';
													}
													?>>Product</option>
													<option value="Non-profit" <?php
													if ($enterprise_information[0]['develop_product'] == 'Service') {
														echo 'selected';
													}
													?>>Service</option>
													<option value="Others" <?php
													if ($enterprise_information[0]['develop_product'] == 'Hybrid') {
														echo 'selected';
													}
													?>>Hybrid</option>
													</select>
												</div>
											 </div>
											 
										 </div>
										  <div class="row">
											<div class="col-12 col-lg-6 col-md-6">
												<div class="form-group">
														<label>Which solutions does your project align with? <span class="req">*</span></label>
														<?php 
														
														$project_solutions = unserialize($enterprise_information[0]["org_short_desc"]);

														$solutions = [
															"Drinking water treatment",
															"Flood/rainwater management",
															"Non-revenue water management",
															"Wastewater management",
															"Decentralised STP",
															"Monitoring & Analytics",
															"Water resource management",
															"Water distribution",
															"Storage and infrastructure",
															"Others"
														];
														?>
														<select multiple style="height:100px!important"  name="org_short_desc[]" class="form-control fieldDisable" disabled>
															<?php foreach ($solutions as $solution): ?>
																<option value="<?= htmlspecialchars($solution) ?>" <?= php72_in_array($solution, $project_solutions) ? 'selected' : '' ?>>
																	<?= htmlspecialchars($solution) ?>
																</option>
															<?php endforeach; ?>
														</select>
													</div>

											</div>
											<div class="col-12 col-lg-6 col-md-6">
												<div class="col-12 col-lg-6 col-md-6">
													<div class="form-group">
														<label>What problem does your innovation address<span>*</span></label>
														 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['inv_problem']; ?></textarea>
												  
													</div>
												</div>
											</div>
										 </div>
										  <div class="row">
											<div class="col-12 col-lg-6 col-md-6">
												<div class="form-group">
												
													<div class="form-group">
														<label>What is the role of technology in your innovation<span>*</span></label>
														 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['inv_desc']; ?></textarea>
												  
													</div>
												
												</div>
											</div>
											<div class="col-12 col-lg-6 col-md-6">
												<div class="form-group">
													<label>How is the need addressed without your innovation? What are the available alternatives<span>*</span></label>
													 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['inv_alternatives']; ?></textarea>
												</div>
											</div>
										 </div>
										 
										 
										   <div class="row">
											<div class="col-12 col-lg-6 col-md-6">
												<div class="form-group">
												
													<div class="form-group">
														<label>Describe your proposed / current business and revenue model<span>*</span></label>
														 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['proposal_desc']; ?></textarea>
												  
													</div>
												
												</div>
											</div>
											 <div class="col-12 col-lg-6 col-md-6 ">
												<div class="form-group">
												<label>Do you have any patents or IPs<span>*</span></label>
												<select class="form-control fieldDisable" disabled id="in_operation" name="in_operation">
													<option value="">--Select--</option>
													<option value="Pvt Ltd" <?php
													if ($enterprise_information[0]['reco_no'] == 'Yes') {
														echo 'selected';
													}
													?>>Yes</option>
													<option value="Non-profit" <?php
													if ($enterprise_information[0]['reco_no'] == 'No') {
														echo 'selected';
													}
													?>>No</option>
													</select>
												</div>
											 </div>
										 </div>
										 <div class="row">
											<div class="col-12 col-lg-6 col-md-6">
												<div class="form-group">
													<label>If yes, please provide information.<span>*</span></label>
													 <textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $enterprise_information[0]['inv_risks']; ?></textarea>
												  
												</div>
											</div>
											<div class="col-12 col-lg-6 col-md-6">
												<div class="form-group">
												 <label>Social media engagement status<span class="req">*</span></label>
													<?php 
													$social_media = unserialize($enterprise_information[0]["social_media"]);

													$options = [
														"Government MoU",
														"State/municipal utility collaboration",
														"No formal engagement, but discussions are ongoing",
														"No formal engagement yet"
													];
													?>
													<select disabled multiple style="height:100px!important" name="social_media[]" class="form-control fieldDisable" disabled>
														<?php foreach ($options as $option): ?>
															<option value="<?= htmlspecialchars($option) ?>" <?= php72_in_array($option, $social_media) ? 'selected' : '' ?>>
																<?= htmlspecialchars($option) ?>
															</option>
														<?php endforeach; ?>
													</select>
													</div>
											</div>
										 </div>
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