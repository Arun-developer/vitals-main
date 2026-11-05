<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Villgro MIS</title>
</head>

<body>
    <?php  
    $this->load->view('incubation_masters/header.php', array('page' => 'screening_master'));
	
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
                            <?php $this->load->view('incubation_masters/master_sidemenu.php', array('page' => 'screening_master')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
							<div class="row dataconfig d_v_d_c">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
									<span><a href="<?php echo base_url().'index.php/incubation_master/means_validation'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4><?php if($this->uri->segment(3) !=''){ echo "Edit"; }else{ echo "Add"; } ?> Validation</h4>
                                </div>
								<?php if($this->uri->segment(3) !=''){  ?>
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
											<form method="post" name="insertEdit_validation" id="insertEdit_validation" action="<?php echo base_url().'index.php/incubation_master/insertEdit_validation'; ?>" class="form" novalidate autocomplete="off">
												<div class="inputplan-structureall plan-structure-new ">
													<input type="hidden" name="id" value="<?php echo $this->uri->segment(3); ?>" >
													<div class="row leaveLabel">
														<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
															<div class="form-group">
																<label>Criteria<span>*</span></label>
																<select name="criteria" id="criteria" class="form-control edit_cls">
																	<option value="" >--Select--</option>
																	<?php foreach($criteriaList as $list){?>
																	<option 
																	<?php if(isset($get_validation->criteria) && $get_validation->criteria!=''){ if($get_validation->criteria ==  $list->id){ echo "selected"; }} ?>
																	
																	value="<?php echo $list->id; ?>" ><?php echo $list->master_name; ?></option>						
																	<?php } ?>
																</select> 
															</div>
															
															<div class="form-group">
																<label>Validation<span>*</span></label>
																<input value="<?php if(isset($get_validation->validation) && $get_validation->validation!=''){ echo $get_validation->validation; } ?>"  name="validation" id="validation" class="form-control edit_cls" type="text" placeholder="">
															</div>
															<div class="form-group">
																<label>Status<span>*</span></label>
																<select name="status" id="status" class="form-control edit_cls">
																	<option value="">--Select--</option>
																	<option <?php if($get_validation->status == 1)echo"selected"; ?> value="1" >Approved</option>
																	<option <?php if($get_validation->status == 0)echo"selected"; ?> value="0">Disapproved </option></select> 
															</div>
														</div>
														
													</div>
													<input type="hidden" id="edit_status">
													
													<div id="submit_btn_cls" >
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
			var check_edit = '<?php echo $this->uri->segment(3);  ?>';
			
			if(check_edit!=''){
				$(".edit_cls").prop('disabled', false);
				$(".edit_cls").prop('disabled', true);
				$("#submit_btn_cls").css('display','none');
				
			}
		});
		$('.scrollsideMenu').scrollTop($('.scrollsideMenu').scrollTop()+330);
		$('#insertEdit_validation').validate({
			rules: {
				criteria:{
					required:true
				},
				validation:{
					required:true
				},
				status:{
					required:true
				},

			},
			messages: {
				criteria: "Select Criteria",
				validation: "Enter Validation",
				status: "Select Status"
			}
		});
		
		$(".numberField").on("input", function (evt) {
			var self = $(this);
			self.val(self.val().replace(/[^0-9]/g, ''));
			if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
				evt.preventDefault();
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
			$(document).on('click', '.master_deluser', function () {
				$(this).closest('div').remove();
			});
        });
		
		
		
		$(document).on('click', '#submit_btn', function (e) {
			if(!$("#insertEdit_validation").valid()){
				e.preventDefault();
			}else{
				$('#insertEdit_validation').submit();
			}
		});
		
		
		$(document).on('click', '#deleteRecord', function() {
			common_ids = [];
			$(".master_check").each(function(index) {
				if ($(this).is(":checked")) {
					if (this.value != '' && this.value != undefined && this.value !='on') {
						common_ids[index] = this.value;
					}
				}
			});
			
			var id = $('#delete_ids').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/incubation_master/commonDelete",
                data: {
                    id: common_ids,
                    table:'means_validation',
                },
                dataType: 'json',
                success: function(msg) { console.log(msg);
                    $('#deletemodal').modal('hide');
                    $('.deletetoast').toast('show');
					$("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                    //$('.deleteMsg').removeClass('display-hide');
                    setTimeout(function() {
						location.reload();
                    }, 1000);
                }
            });
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