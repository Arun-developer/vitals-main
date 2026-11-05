<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Villgro MIS</title>
</head>
<style>
label.tbl_err {
    width: 100%;
	text-align: right;
	color: #FF0000 !important;
}
</style>
<body>
    <?php  
    $this->load->view('incubation_masters/header.php', array('page' => 'source_instance_master'));
	
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
                            <?php $this->load->view('incubation_masters/master_sidemenu.php', array('page' => 'source_instance_master')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
							<div class="row dataconfig d_v_d_c">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
									<span><a href="<?php echo base_url().'index.php/incubation_master/source_instance_master'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4>Add Source</h4>
                                </div>
								
                            </div>
							
							<div class="plan-structure-vital vital_windowScroll">
                                <div class="tab-slider--container tab-content">
                                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                        <main class="page-content">
											<form method="post" enctype="multipart/form-data" name="insertEdit_sources" id="insertEdit_sources" action="<?php echo base_url().'index.php/incubation_master/insertEdit_source'; ?>" class="form" novalidate autocomplete="off">
												<div class="inputplan-structureall plan-structure-new ">
												
													<div class="row leaveLabel">
														<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
															<div class="form-group">
																<label>Employee<span>*</span></label>
																<select name="employee" id="employee" class="form-control">
																	<option value="">--Select--</option>
																	<?php foreach($usersList as $list){?><option value="<?php echo $list['emp_number']; ?>" ><?php echo $list['emp_name']; ?></option>						
																	<?php } ?>
																</select> 
															</div> 
															<div class="form-group">
																<label>Source Type<span>*</span></label>
																<select name="source_type" id="source_type" class="form-control">
																	<option value="" >--Select--</option>
																	<?php foreach($sourceType as $list){?><option value="<?php echo $list->id; ?>" ><?php echo $list->master_name; ?></option>						
																	<?php } ?>
																</select> 
															</div>
															<div class="form-group">
																<label>Source Name<span>*</span></label>
																<input name="source_name" id="source_name" class="form-control" type="text" placeholder="">
															</div>
															
															<div class="form-group">
																<label>Contact Name<span>*</span></label>
																<input name="contact_person" id="contact_person" class="form-control" type="text" placeholder="">
															</div>
															
															<div class="form-group">
																<label>Designation<span>*</span></label>
																<input name="designation" id="designation" class="form-control" type="text" placeholder="">
															</div>
															
															<div class="form-group">
																<label>Address<span>*</span></label>
																<textarea name="address" id="address" class="form-control" type="text" ></textarea>
															</div>
															<div class="form-group">
																<label>Phone(Office No.)<span></span></label>
																<input name="phone" id="phone" class="form-control" type="text" placeholder="">
															</div>
															<div class="form-group">
																<label>Mobile<span></span></label>
																<input name="mobile" id="mobile" class="form-control" type="text" placeholder="">
															</div>
															<div class="form-group">
																<label>E-Mail<span></span></label>
																<input name="email" id="email" class="form-control" type="text" placeholder="">
															</div>
															<div class="form-group">
																<label>Fax<span></span></label>
																<input name="fax" id="fax" class="form-control" type="text" placeholder="">
															</div>
															
															<div class="form-group">
																<label>Status<span>*</span></label>
																<select name="status" id="status" class="form-control">
																	<option value="">--Select--</option>
																	<option value="1" >Approved</option>
																	<option value="0">Disapproved </option>
																</select> 
															</div>
															
															<div class="form-group">
																<label>Frequency<span>*</span></label>
																<select name="frequency" id="frequency" class="form-control">
																	<option value="" >--Select--</option>
																	<option value="Monthly">Monthly</option>
																	<option value="Quaterly">Quaterly</option>
																	<option value="Half-Yearly">Half-Yearly</option>
																	<option value="Yearly">Yearly</option>
																</select> 
															</div>
															
															<div class="form-group">
																<label>Date<span>*</span></label>
																<input id="dateCalendar" type="text" class="form-control valid" name="date" placeholder="dd-mm-yyyy" >
															</div>
															<div class="form-group">
																<label>Alert <span>*</span></label>
																<input type="radio" value="yes" name="alert">Yes
																<input type="radio" value="no" checked="checked" style="margin-left: 20px;" name="alert">No
															</div>
															<div class="form-group">
																<label>Link (Please write link for username and password)<span></span></label>
																<input type="text" class="form-control valid" name="link" >
															</div>
															<div class="form-group loginField">
																<label>Username<span></span></label>
																<input type="text" class="form-control valid" name="username" >
															</div>
															<div class="form-group loginField">
																<label>Password<span></span></label>
																<input type="text" class="form-control valid" name="password" >
															</div>
															
															<div class="form-group">
																<label>Pagecontent<span></span></label>
																<textarea name="pagecontent" id="pagecontent" class="form-control" type="text" ></textarea>
															</div>
															<div class="form-group">
																<label>Description<span></span></label>
																<textarea name="description" id="description" class="form-control" type="text" ></textarea>
															</div>
															<div class="form-group">
																<label>Document<span></span></label> 
																<input type="button" class="form-control masterPicUpdatebtn employeeInput" value="Upload Document">
																<input type="file" name="document" id="my_file" style="display: none;">
																<input type="hidden" name="old_pre_document" value="">
																<div id="file_err"></div>
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
			
				
		$('#insertEdit_sources').validate({
			rules: {
				employee:{
					required:true
				},
				source_type:{
					required:true
				},
				source_name:{
					required:true
				},
				contact_person:{
					required:true
				},
				designation:{
					required:true
				},
				address:{
					required:true
				},
				phone:{
					number:true
				},
				mobile:{
					number:true
				},
				email:{
					email: true
				},
				status:{
					required:true
				},
				period:{
					required:true
				},
				date:{
					required:true
				},
				alert:{
					required:true
				},

			},
			messages: {
				employee: "Select Employee",
				source_type: "Select Type",
				source_name: "Enter Source Name",
				contact_person: "Enter Contact Name",
				designation: "Enter Designation",
				address: "Enter Address",
				phone: "Enter Valid Phone Number",
				mobile: "Enter Valid Mobile Number",
				alert: "Select Alert",
				date: "Select Date",
				period: "Select Frequency",
				email: "Enter Valid Email",
				status: "Select Status"
			}
		});
	
	
	
			$('#dateCalendar').datepicker({
				changeMonth: true,
				changeYear: true,
				maxDate: 0
            });
			$('.loginField').hide();
			
			$(document).on('click', '.masterPicUpdatebtn', function () {
                $("input[id='my_file']").click();
            });
			error_count = 0;
			$(document).on('change', 'input[type="file"]', function () {
				//var file_btn_id = $(this).attr('data-btn-id');
				var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
				var last_char = filename.slice(-40);

				var countFiles = $(this)[0].files.length;
				var imgPath = $(this)[0].value;
				var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
				var imgSize = $(this)[0].files[0].size;
				$('#file_err').html("");
				if (imgSize <= 10485760) {
					var file_typeArr = ["pdf", "xls", "ppt", "xlsx", "doc", "docx", "pptx"];
					if (file_typeArr.indexOf(extn) <= -1) {
						error_count = 1;
						$('#file_err').html("<label class='tbl_err'>Invalid File</label>");
					} else {
						//$('#' + file_btn_id).val(last_char);
						error_count = 0;
					}
				} else {
					error_count = 1;
					$('#file_err').html("<label class='tbl_err'>File exceeds 10 MB</label>");
				}
			});
	
	
		});
		$("input[name='link']").change(function(){
			if($(this).val() != '')
				$('.loginField').show()
			else
				$('.loginField').hide()
		});
		if($("input[name='link']").val() != ''){
			$('.loginField').show()
		}
		
		$(document).on('change', '#mastertype', function () {
			mastertype = $(this).val();
			var datas = $.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>index.php/incubation_master/ajax_criteria",
				data: {'mastertypes':mastertype,'isajax':true},
				dataType:'json',
				success: function(datas) {
					$("#criteria").html('');
					if(datas.status ==1){
						$("#criteria").html(datas.response);
					}
				}
			});		
		
		});
		
		$(document).on('change', '#input_type', function () {
			input_type = $(this).val();
			$("#add_value").css('display','none');
			if(input_type =='Listbox' || input_type =='Radio'|| input_type =='Checkbox'){
				$("#add_value").css('display','block');
			}else{
				$(".value_cls").val('');
				$(".append_value").remove();
				//$(".value_cls").closest('div').remove();
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
			
			if(!$("#insertEdit_sources").valid()  || error_count == 1){
				e.preventDefault();
			}else{
				$('#insertEdit_sources').submit();
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

</script>

</body>

</html>