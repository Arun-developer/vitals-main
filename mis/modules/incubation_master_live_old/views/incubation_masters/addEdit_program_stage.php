<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Villgro MIS</title>
</head>

<body>
    <?php  
    $this->load->view('incubation_masters/header.php', array('page' => 'addEdit_program_stage'));
	
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
                            <?php $this->load->view('incubation_masters/master_sidemenu.php', array('page' => 'addEdit_program_stage')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
							<div class="row dataconfig d_v_d_c">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
									<span><a href="<?php echo base_url().'index.php/incubation_master/incubation_master/program_stage_master'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4><?php if($this->uri->segment(3) !=''){ echo "Edit"; }else{ echo "Add"; } ?> Program Stage</h4>
                                </div>
                            </div>
							<?php if($this->uri->segment(3)!=''){?>
								<div class="col-xl-8 col-lg-6 col-md-12 col-12 text-right">
									<ul class="vitals-links">
										<li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
									</ul>
								</div>
							<?php } ?>
							
							<div class="plan-structure-vital vital_windowScroll">
                                <div class="tab-slider--container tab-content">
                                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                        <main class="page-content">
											<form method="post" name="insertEdit_programStage" id="insertEdit_programStage" action="<?php echo base_url().'index.php/incubation_master/insertEdit_programStage'; ?>" class="form" novalidate autocomplete="off">
												<div class="inputplan-structureall plan-structure-new ">
													<input type="hidden" name="id" value="<?php echo $this->uri->segment(3); ?>">
													<div class="row leaveLabel">
														<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
															
															<div class="form-group">
																<label>Program Type<span>*</span></label>
																<select name="program_type" id="program_type" class="form-control edit_cls">
																	<option value="">--Select--</option>
																	<?php foreach($get_source_type as $list){?>
																	<option <?php if(isset($program_stage['program_type']) && $program_stage['program_type']!=''){ if($program_stage['program_type'] == $list->id){ echo "selected";}}   ?>  value="<?php echo $list->id; ?>"><?php echo $list->master_name; ?></option>
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
																<input  value="<?php if(isset($program_stage['title']) && $program_stage['title']!='') echo $program_stage['title']; ?>" id="title" name="title"" type="text" class="form-control edit_cls" name="name="title">
															</div> 
															
															<div class="form-group">
																<label>Status<span>*</span></label>
																<select name="status" id="status"  class="form-control edit_cls">
																	<option value="">--Select--</option>
																	<option <?php if(isset($program_stage['status']) && $program_stage['status']!=''){ if($program_stage['status'] =='1'){ echo "selected";}}   ?> value="1" >Approved</option>
																	<option <?php if(isset($program_stage['status']) && $program_stage['status']!=''){ if($program_stage['status'] =='0'){ echo "selected";}}   ?>  value="0">Disapproved </option>
																</select> 
															</div>
															
														</div>
													</div>
													
													
													<input type="hidden" id="edit_status">					
													<div id="submit_btn_cls"  >
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
		 $('#insertEdit_programStage').validate({
			rules: {
				program_type:{
					required:true
				},
				program_service_offering:{
					required:true
				},
				title:{
					required:true
				},
				status:{
					required:true
				}
			},
			messages: {
				program_type: "Select Source",
				program_service_offering: "Select Program Service Offering",
				title: "Enter Program Stage",
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
		
		
		$(document).on('click', '#submit_btn', function (e) {
			if(!$("#insertEdit_programStage").valid()){
				e.preventDefault();
			}else{
				$('#insertEdit_programStage').submit();
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