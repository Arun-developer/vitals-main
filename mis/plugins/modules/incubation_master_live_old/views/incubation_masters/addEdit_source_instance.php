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
                                    <h4><?php if($this->uri->segment(4)!=''){ echo "Edit"; }else{ echo "Add";}?> Source</h4>
                                </div>
								<?php if($this->uri->segment(4)!=''){ ?>
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
											<form method="post" enctype="multipart/form-data" name="insertEdit_source" id="insertEdit_source" action="<?php echo base_url().'index.php/incubation_master/insertEdit_sourceInstance'; ?>" class="form" novalidate autocomplete="off">
											
												<input type="hidden" name="source_id" value="<?php echo $this->uri->segment(3); ?>" >
												<input type="hidden" name="id" value="<?php echo $this->uri->segment(4); ?>" >
												<div class="inputplan-structureall plan-structure-new ">
												
													<div class="row leaveLabel">
														<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
															<div class="form-group">
																<label>Instance Name<span>*</span></label>
																<input value="<?php if(isset($instance_master->instance_name) && $instance_master->instance_name!=''){ echo $instance_master->instance_name; } ?>" name="instance_name" id="instance_name" class="form-control edit_cls" type="text" placeholder="">
															</div>
															
															<div class="form-group">
																<label>Date<span>*</span></label>
																<input value="<?php if (isset($instance_master->date) && $instance_master->date != '' && $instance_master->date != 0) echo date('d/m/Y', strtotime($instance_master->date)); ?>"  name="date" id="dateCalendar" class="form-control edit_cls" type="text" placeholder="">
															</div>
															<div class="form-group">
																<label>Remarks<span>*</span></label>
																<textarea name="remarks" id="remarks" class="form-control edit_cls" type="text" ><?php if(isset($instance_master->remarks) && $instance_master->remarks!=''){ echo $instance_master->remarks; } ?></textarea>
															</div>
															<div class="form-group">
																<label>Document<span></span></label> 
																<input type="button" class="form-control masterPicUpdatebtn employeeInput edit_cls" value="Upload Document">
																<input type="file" name="document" id="my_file" style="display: none;">
																<input type="hidden" name="old_pre_document" value="<?php if(isset($instance_master->document) && $instance_master->document!=''){ echo $instance_master->document; } ?>">
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
			var edit_id = '<?php echo $this->uri->segment(4); ?>';
			$('#submit_btn_cls').css("display",'block');
			if(edit_id!=''){
				$('.edit_cls').prop("disabled", true);
				$('#submit_btn_cls').css("display",'none');
			}
			
			$('#dateCalendar').datepicker({
				changeMonth: true,
				changeYear: true,
				maxDate: 0
            });
			
			
			$(document).on('click', '.masterPicUpdatebtn', function () {
                $("input[id='my_file']").click();
            });
			error_count = 0;
			$(document).on('change', 'input[type="file"]', function () {
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
						$('.employeeInput').val(last_char);
						error_count = 0;
					}
				} else {
					error_count = 1;
					$('#file_err').html("<label class='tbl_err'>File exceeds 10 MB</label>");
				}
			});
			
			
			
			
			$('.loginField').hide();
			
			/* $(document).on('click', '.masterPicUpdatebtn', function () {
                $("input[id='my_file']").click();
            }); */
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
			
		$('#insertEdit_source').validate({
			rules: {
				instance_name:{
					required:true
				},
				date:{
					required:true
				},
				remarks:{
					required:true
				}

			},
			messages: {
				instance_name: "Enter Instance",
				date: "Select Date",
				remarks: "Enter Remarks"
			}
		});
	
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
			if(!$("#insertEdit_source").valid()  || error_count == 1){
				e.preventDefault();
			}else{
				$('#insertEdit_source').submit();
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