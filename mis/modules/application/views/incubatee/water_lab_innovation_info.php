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
                               <?php /*  <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">Team</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">Enterprise</a></li>
                                <li role="presentation" class=" active"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">Impact</a></li>
								<?php if($innovation_information[0]['program'] == '14') { ?>
								<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/about_business/' . $application_id; ?>">Business</a></li>
									<li role="presentation" ><a href="<?php echo base_url() . 'index.php/application/support_info/' . $application_id; ?>">Support</a></li>
								 <?php } ?>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/additional_info/' . $application_id; ?>">Additional Information</a></li>
								*/ ?>
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/basic_info/' . $application_id; ?>">Basic Information</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/team_info/' . $application_id; ?>">
								<?php if($innovation_information[0]['program'] == '21' || $innovation_information[0]['program'] == '22'){
									echo "Team information";  
									}else{
										echo "Team";
									}  
								?>
								</a></li>
                                <li role="presentation"><a href="<?php echo base_url() . 'index.php/application/enterprise_info/' . $application_id; ?>">
								<?php if($innovation_information[0]['program'] == '21' || $innovation_information[0]['program'] == '22'){
									echo "About the Enterprise";  
									}else if($innovation_information[0]['program'] == '23'){
										echo "Funding details & Support";
									}else{
										echo "Enterprise";
									}  
								?>
								</a></li>
                                <li role="presentation"  class=" active"><a href="<?php echo base_url() . 'index.php/application/innovation_info/' . $application_id; ?>">
								<?php if($innovation_information[0]['program'] == '21' || $innovation_information[0]['program'] == '22'){
									echo "About the Business model";  
									}else{
										echo "Impact";
									}  
								?>
								</a></li>
								
								<?php if($innovation_information[0]['program'] == '21' && date('Y-m-d', strtotime($innovation_information[0]['created_date']))  >= date('2024-01-01')){ ?>
									
								<?php }else{ ?>
									<?php if($innovation_information[0]['program'] == '14' || $innovation_information[0]['program'] == '21' || $innovation_information[0]['program'] == '22') { ?>
									<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/about_business/' . $application_id; ?>">
									<?php if($innovation_information[0]['program'] == '21' || $innovation_information[0]['program'] == '22'){
										echo "Impact of the business";  
										}else{
											echo "Business";
										}  
									?>
									</a></li>
									<?php } ?>
								<?php } ?>
								
								
								<?php  if (php72_cmp($innovation_information[0]['program']) != 37 && php72_cmp($innovation_information[0]['program']) != 0 && php72_cmp($innovation_information[0]['program']) != 33 && php72_cmp($innovation_information[0]['program']) != 21 && php72_cmp($innovation_information[0]['program']) != 22 && php72_cmp($innovation_information[0]['program']) != 23 && php72_cmp($innovation_information[0]['program']) != 26 && php72_cmp($innovation_information[0]['program']) != 24 && php72_cmp($innovation_information[0]['program']) != 27 && php72_cmp($innovation_information[0]['program']) != 25  && php72_cmp($innovation_information[0]['program']) != 35 && php72_cmp($innovation_information[0]['program']) != 29) {  ?>
								<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/support_info/' . $application_id; ?>">Support</a></li>
								<?php } ?>
								
								<?php  if (php72_cmp($innovation_information[0]['program']) == 25 || php72_cmp($innovation_information[0]['program']) == 35) {  ?>
									<li role="presentation"><a href="<?php echo base_url() . 'index.php/application/gmt_info/' . $application_id; ?>">GTM related information </a></li>
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
                                    
									
									
									
									  <div class="row" >
                                            <div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Have you conducted research on your customer segments / run pilots?<span>*</span></label>
                                                    <select class="form-control fieldDisable" name="cust_seg" id="cust_seg" onchange="showSegment(this.value);" disabled>
                                                        <option value="">--Select--</option>
                                                        <option value="yes" <?php if ($innovation_information[0]['research_cus_seg'] == 'yes') echo "selected='selected'"; ?>>Yes</option>
                                                        <option value="no" <?php if ($innovation_information[0]['research_cus_seg'] == 'no') echo "selected='selected'"; ?>>No</option>
                                                    </select>
                                                </div>
                                            </div>
											 <div class="col-12 col-lg-6 col-md-6">
												<div class="form-group"> 
													<label>Briefly explain the problem that you are addressing</label>
													<textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['demographic_profie']; ?></textarea>
												</div>
											</div>
                                        </div>
										<div class="row" >
											<div class="col-12 col-lg-6 col-md-6"> 
                                                <div class="form-group">
													<label>What type of impact will your product / service have on the BoP (base of pyramid) / poor? </label>
													<input type="radio" disabled name="piloted_solutions"  value="Direct" <?php echo ($innovation_information[0]["piloted_solutions"]=="Direct")?"checked":"";?>> Direct<br/>
													<input type="radio" disabled name="piloted_solutions"  value="Indirect" <?php echo ($innovation_information[0]["piloted_solutions"]=="Indirect")?"checked":"";?>> Indirect 
												</div>
											</div>
											<div class="col-12 col-lg-6 col-md-6"> 
                                                <div class="form-group">
													<label>How do you quantitatively and qualitatively measure the Environmental Impact (and water saving measures) of your activity?</label>
													<textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['primary_benifi']; ?></textarea>
												</div>
											</div>
										 </div>
										 
										 <div class="row" >
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
													<label>How do you quantitatively and qualitatively measure the Social Impact of your activity?</label>
														<textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['avg_monthly']; ?></textarea>
												
												 </div>
											</div>
											
											<div class="col-12 col-lg-6 col-md-6"> 
                                                <div class="form-group">
													<label>Will your product or service benefit other beneficiary groups? Describe these groups briefly</label>
													<textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['inv_impact']; ?></textarea>
												</div>
											</div>
										 </div>
										 
										
										
										 <div class="row" >
											<div class="col-12 col-lg-6 col-md-6">
                                                <div class="form-group">
													<label>Outline your expected impact in short term, medium term and long term.</label>
													<textarea class="form-control fieldDisable" cols="30" rows="3" disabled><?= $innovation_information[0]['others_benefit']; ?></textarea>
												
												 </div>
											</div>
										 </div>
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

<style>
@media only screen and (min-width: 1200px) {
      #no_impact {
		 margin-top: 20px;
	  }
	  #prop_model {
		 margin-top: 20px;
	  }
	  #avg_earn{
		  margin-top: 20px;
	  }
}
@media only screen and (min-width: 1500px) {
      #no_impact {
		 margin-top: 0px;
	  }
	  #prop_model {
		 margin-top: 0px;
	  }
	  #avg_earn{
		  margin-top: 20px;
	  }
}
</style>

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