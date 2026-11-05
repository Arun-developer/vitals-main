<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Villgro MIS</title>
</head>

<body>
    <?php  
    $this->load->view('incubation_masters/header.php', array('page' => 'grading_master'));
	
    ?>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
        <div class="container-fluid">
            <?php
            $successMsg = ($this->session->flashdata('successMsg')) ? $this->session->flashdata('successMsg') : '';
            $errorMsg = ($this->session->flashdata('errorMsg')) ? $this->session->flashdata('errorMsg') : '';
            if ($successMsg != '') {
            ?>
                <div class="position-absolute d-flex flex-column p-4 toastPlace">
                    <div id="toast-container" aria-live="polite" aria-atomic="true">
                        <div id="toast-wrapper">
                            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                <div class="toast-header bg-success text-white">
                                    <strong class="mr-auto"><?= $successMsg; ?></strong>
                                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                        <span aria-hidden="true" class="text-white">×</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            if ($errorMsg != '') {
            ?>
                <div class="position-absolute d-flex flex-column p-4 toastPlace">
                    <div id="toast-container" aria-live="polite" aria-atomic="true">
                        <div id="toast-wrapper">
                            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                <div class="toast-header bg-danger text-white">
                                    <strong class="mr-auto"><?= $errorMsg; ?></strong>
                                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                        <span aria-hidden="true" class="text-white">×</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="display-hide deleteMsg">
                <div class="position-absolute d-flex flex-column p-4 toastPlace">
                    <div id="toast-container" aria-live="polite" aria-atomic="true">
                        <div id="toast-wrapper">
                            <div class="toast deletetoast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                                <div class="toast-header bg-success text-white">
                                    <strong class="mr-auto">Record(s) deleted successfully</strong>
                                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                        <span aria-hidden="true" class="text-white">×</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
			
            <div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
                <div class="row">
                    <div class="col-lg-3 col-xl-3 col-md-3 col-12">
                        <div id="leftMenuLoad">
                            <?php $this->load->view('incubation_masters/master_sidemenu.php', array('page' => 'grading_master')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
							<div class="row dataconfig d_v_d_c">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
									<span><a href="<?php echo base_url().'index.php/incubation_master/incubation_master/grading_master'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4><?php if($this->uri->segment(3) !=''){ echo "Edit"; }else{ echo "Add"; } ?> Grading Master</h4>
                                </div>
								<?php if($this->uri->segment(3)!=''){?>
									<div class="col-xl-8 col-lg-6 col-md-12 col-12 text-right">
										<ul class="vitals-links">
											<li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
										</ul>
									</div>
								<?php } ?>
                            </div>
							
							<div class="plan-structure-vital vital_windowScroll">
                                <div class="tab-slider--container tab-content">
                                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                        <main class="page-content">
											<form method="post" name="insertEdit_grading_master" id="insertEdit_grading_master" action="<?php echo base_url().'index.php/incubation_master/insertEdit_grading_master'; ?>" class="form" novalidate autocomplete="off">
												<div class="inputplan-structureall plan-structure-new ">
													<input type="hidden" name="id" value="<?php echo $this->uri->segment(3); ?>">
													<div class="row leaveLabel">
														<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
															
															<?php if($this->uri->segment(3) ==''){ ?>
															<div class="form-group">
																<label>Program Type<span>*</span></label>
																<select name="program_type" id="program_type" class="form-control edit_cls">
																	<option value="">--Select--</option>
																	<?php foreach($program_stage as $list){?>
																	<option  value="<?php echo $list->id; ?>"><?php echo $list->master_name; ?></option>
																	<?php } ?>
																</select> 
															</div>
															
															<div class="form-group">
																<label>Program Service Offering<span>*</span></label>
																<select name="program_service_offering" id="program_service_offering" class="form-control edit_cls">
																	<option value="">--Select--</option>
																</select> 
															</div> 
															<div class="form-group">
																<label>Program Stage<span>*</span></label>
																<select name="program_stage" id="program_stage" class="form-control edit_cls">
																	<option value="">--Select--</option>
																</select> 
															</div> 
															<?php } ?>
															<div class="form-group">
																<label>Criteria<span>*</span></label>
																<select name="category" id="category" class="form-control edit_cls">
																	<option value="">--Select--</option>
																	<?php foreach($category as $list){?>
																	<option  <?php if(isset($get_grade->category) && $get_grade->category == $list->id){ echo"selected"; } ?> value="<?php echo $list->id; ?>"><?php echo $list->master_name; ?></option>
																	<?php } ?>
																</select> 
															</div> 
															
															<div class="form-group">
																<label>Sub-Criteria<span>*</span></label>
																<input value="<?php if(isset($get_grade->criteria) && $get_grade->criteria!='')echo $get_grade->criteria; ?>"  id="criteria" name="criteria" type="text" class="form-control edit_cls" >
															</div> 
															<div class="form-group">
																<label>Weightage<span>*</span></label>
																<input value="<?php if(isset($get_grade->waitage) && $get_grade->waitage!='')echo $get_grade->waitage; ?>"  id="waitage" name="waitage" type="text" class="form-control edit_cls" >
															</div>
															<div class="form-group">
																<label>Scale<span>*</span></label>
																<input  value="<?php if(isset($get_grade->scale) && $get_grade->scale!='')echo $get_grade->scale; ?>" id="scale" name="scale" type="text" class="form-control edit_cls" >
															</div> 
															<?php 	
															$scaling_factor = unserialize($get_grade->scaling_factor);
															$scale = isset($get_grade->scale) ? $get_grade->scale : '6';
																    for($i = 1; $i <= $scale; $i++){ ?>
																<div class="form-group">
																	<label>Scaling Factor[Scale <?php echo $i; ?>]<span>*</span></label>
																	<textarea data-attr="scale_<?php echo $i; ?>"  name="scaling_factor[]" type="text" class="form-control edit_cls scale_factor" ><?php echo $scaling_factor[$i-1]; ?></textarea>
																	<div id="scale_<?php echo $i; ?>" ></div>
																</div> 
															<?php } ?>
															
														</div>
													</div>
													
													
													<input type="hidden" id="edit_status">					
													<div id="submit_btn_cls">
														<ul class="vitals-links">
															<li><input type="submit" id="submit_btn" class="vital_yellow_btn wdt_100"></input></li>
															<li><a href="" class="wdt_100 vital_bordered_btn">Cancel</a></li>
														</ul>
													</div>
													
													<div class="table_configcontentnew pad-bt0">
														<div class="tabpanel-title">
															<div class="row">
																<div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
																</div>
																<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
																	<ul class="milestone-links">
																	</ul>
																</div>
															</div>
														</div>
													</div>
												</div>
											</form>
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



    <script type="text/javascript">
	
		$(document).ready(function() {
			var edit_id = '<?php echo $this->uri->segment(3); ?>';
			$(".edit_cls").prop('disabled', false);
			if(edit_id!=''){
				$(".edit_cls").prop('disabled', true);
				$("#submit_btn_cls").css('display','none');
			}
		});
		$('.scrollsideMenu').scrollTop($('.scrollsideMenu').scrollTop()+260);																			
		 $('#insertEdit_grading_master').validate({
			rules: {
				program_type:{
					required:true
				},
				program_service_offering:{
					required:true
				},
				program_stage:{
					required:true
				},
				category:{
					required:true
				},
				criteria:{
					required:true
				},
				waitage:{
					required:true
				},
				scale:{
					required:true
				}
			},
			messages: {
				program_type: "Select Source",
				program_service_offering: "Select Program Service Offering",
				program_stage: "Enter Program Stage",
				category: "Enter Criteria",
				criteria: "Enter Sub-Criteria",
				waitage: "Enter Weightage",
				scale: "Enter Scale",
				status: "Select Status",
			}
		});
		$(document).on('click', '.summaryEdit', function () {
			
			$("#edit_status").val("1");
			$(".edit_cls").attr("disabled", false);
			$(".multiselect").attr("disabled", false);
			$("#submit_btn_cls").css("display","block");
			$(".edit").addClass("activeTabs");
		});	
		
			
        $(document).ready(function() {
             $('.nav-tabs').scrollingTabs({
                enableSwiping: true
            }).on('ready.scrtabs', function() {
                $('.tab-content').show();
            });
            $('#navLoad').removeClass('display-hide');
            $('.vital_windowScroll').css({
                'height': (($(window).height()) - 190) + 'px'
            });
            $('.toast').toast('show');
            setTimeout(function() {
                $('.success').addClass('display-hide');
            }, 3000);
        });
		
		$(document).on('change', '.scale_factor', function () {
			var current_attr = $(this).attr('data-attr');
			$("#"+current_attr).html('');
			if($(this).val() ==''){
				$("#"+current_attr).html('<label style="color: #FF0000 !important;text-align: right;width: 100%;" >Enter Scaling Factor</label>');
			}
		});	
			
		//scale_factor
		
		$(document).on('click', '#submit_btn', function (e) {
			error = 0;
			$(".scale_factor").each(function(index){
				var current_attr = $(this).attr('data-attr');
				$("#"+current_attr).html('');
				if($(this).val() ==''){
					$("#"+current_attr).html('<label style="color: #FF0000 !important;text-align: right;width: 100%;" >Enter Scaling Factor</label>');
					error = 1;
				}
			});
			if(!$("#insertEdit_grading_master").valid() && error ==0){
				e.preventDefault();
			}else{
				$('#insertEdit_grading_master').submit();
			}
		});
		
	
    </script>
	
	<script>
    // Window Height
    // ---------------------------------------
    $(document).ready(function() {
        $('.vital_windowScroll').css({
            'height': (($(window).height()) - 190) + 'px'
        });

        $('#multiselect, #accessibleTo').multiselect({
                buttonWidth: '100%',
                includeSelectAllOption: true,
                nonSelectedText: 'Select an Option'
            });
    });
    function getSelectedValues() {
            var selectedVal = $("#multiselect, #accessibleTo").val();
            for (var i = 0; i < selectedVal.length; i++) {
                if (window.CP.shouldStopExecution(0)) break;

                function innerFunc(i) {
                    setTimeout(function() {
                        location.href = selectedVal[i];
                    }, i * 2000);
                }
                innerFunc(i);
            }
            window.CP.exitedLoop(0);
        }
</script>

</body>

</html>