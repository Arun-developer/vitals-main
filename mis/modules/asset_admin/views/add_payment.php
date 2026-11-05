<?php $this->load->view('vitals_header.php', array('main_menu' => 'approve', 'page_title' => 'Assets In Use', 'page_table' => 'datatable')); ?>
<body>
	
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-1.9.1.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.validate.min.js'; ?>"></script>
		
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-ui.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery.toaster.js'; ?>"></script>

		<script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap-datetimepicker.min.js'; ?>"></script>
        <!-- <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap-multiselect.js'; ?>"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/fullcalendar.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-bootstrap-scrolling-tabs.js'; ?>"></script>
		
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
                            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'assetUse', 'an_approval_count' => $an_approval_count)); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
							<div class="row dataconfig d_v_d_c">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
									<span><a href="<?php echo base_url().'index.php/asset_admin/listasset'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4>Add Asset Payment</h4>
                                </div>
								<!-- <div class="col-xl-8 col-lg-6 col-md-12 col-12 text-right">
									<ul class="vitals-links">
										<li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
									</ul>
								</div> -->
                            </div>
							
							<div class="plan-structure-vital vital_windowScroll">
                                <div class="tab-slider--container tab-content">
                                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                        <main class="page-content">
											<form method="post" name="add_asset_payment" id="add_asset_payment" action="<?php echo base_url().'index.php/asset_admin/insertEdit_payment'; ?>" class="form" novalidate autocomplete="off">
												<div class="inputplan-structureall plan-structure-new ">
													<input type="hidden" name="asset_id" value="<?php echo $this->uri->segment(3); ?>" >
													<div class="row leaveLabel">
														<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
															<div class="form-group">
																<label>Asset Number<span>*</span></label>
																<input  name="asset_no" id="asset_no" value="<?php echo $assetInfo[0]['asset_no']; ?>" class="form-control edit_cls" type="text" placeholder="">
															</div>
														
															<div class="form-group">
																<label>Payment Type<span>*</span></label>
																<select name="payment_type" id="payment_type" class="form-control edit_cls">
																	<option value="">--Select--</option>
																	<?php foreach ($payment_type as $key => $value): ?>
																		<option <?php echo ($assetInfo[0]['payment_type'] == $key) ? ('selected') : (''); ?> value="<?= $key ?>"  <?php echo ($payment_type == $key) ? ('selected') : (''); ?> ><?= $value ?></option>
																	<?php endforeach; ?>
																</select> 
															</div>
															

															<div class="form-group employee_id" style="display:none;" >
																<label>Payment To (Currenly Under)<span>*</span></label>
																<select name="employee_id" id="employee_id" class="form-control edit_cls">
																	<option value="">--Select--</option>
																	<?php foreach ($userList as $rowsuser) { ?>
																		<option value="<?= $rowsuser['id']; ?>" <?php echo ($employee_id == $rowsuser['id']) ? ('selected') : (''); ?>>
																			<?= $rowsuser['user_name']; ?>
																		</option>
																	<?php } ?>
																	<option value="others">Others</option>
																</select> 
															</div> 	
															
															<div class="form-group other_employee_id" style="display:none;">
																<label>Others<span>*</span></label>
																<input  name="other_employee_id" id="other_employee_id" value="" class="form-control edit_cls" type="text" placeholder="">
															</div>															
															<div class="form-group">
																<label>Donor<span>*</span></label>
																<select name="donor" id="donor" class="form-control edit_cls">
																	<option value="">--Select--</option>
																	<?php foreach ($donorList as $rows): ?>
																		<option value="<?php  echo $rows['master_id']; ?>" ><?php echo $rows['master_name']; ?></option>
																	<?php endforeach; ?>
																	<option value="others">Others</option>
																</select> 
															</div>
															
															<div class="form-group other_donor" style="display:none;">
																<label>Others<span>*</span></label>
																<input  name="other_donor" id="other_donor" value="" class="form-control edit_cls" type="text" placeholder="">
															</div>

															<div class="form-group cost_centre">
																<label>Sub-line Item<span>*</span></label>
																<select name="cost_centre" id="cost_centre" class="form-control edit_cls">
																	<option value="">--Select--</option>
																	<?php foreach ($costCentreList as $rows):?>
																		<option value="<?php  echo $rows['master_id']; ?>" ><?php echo $rows['master_name']; ?></option>
																	<?php endforeach; ?>
																	<option value="others">Others</option>
																</select> 
															</div> 
															
															<div class="form-group other_cost_centre" style="display:none;">
																<label>Others<span>*</span></label>
																<input  name="other_cost_centre" id="other_cost_centre" value="" class="form-control edit_cls" type="text" placeholder="">
															</div>
															
															<div class="form-group">
																<label>Vendor<span>*</span></label>
																<select name="vendor" id="vendor" class="form-control edit_cls">
																	<option value="">--Select--</option>
																	<?php foreach ($vendorList as $rows) { ?>
																		<option value="<?= $rows['vendor_id']; ?>" <?php echo ($vendor == $rows['vendor_id']) ? ('selected') : (''); ?>>
																			<?= $rows['vendor_name']; ?>
																		</option>
																	<?php } ?>
																</select> 
															</div>
															
															<div class="form-group">
																<label>Payment Period From<span>*</span></label>
																<input  name="payment_period1" id="payment_period1" class="form-control edit_cls" type="text" placeholder="">
															</div>
															
															<div class="form-group">
																<label>Payment Period To<span>*</span></label>
																<input  name="payment_period2" id="payment_period2" class="form-control edit_cls" type="text" placeholder="">
															</div>
															
															<div class="form-group">
																<label>Bill Date<span>*</span></label>
																<input  name="bill_date" id="bill_date" class="form-control edit_cls" type="text" placeholder="">
															</div>
															<div class="form-group">
																<label>Bill Number<span>*</span></label>
																<input  name="bill_no" id="bill_no" class="form-control edit_cls" type="text" placeholder="">
															</div>
															<div class="form-group">
																<label>Amount<span>*</span></label>
																<input  name="total_amount" id="total_amount" class="form-control edit_cls commonAlphaNum" type="text" placeholder="">
															</div>
														</div>
														
													</div>					
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
			
		$('#payment_period1').datepicker({
			dateFormat: "dd-mm-yy",
			onSelect: function (startDate) {
				$('#payment_period2').datepicker('option', 'minDate', startDate);
			}
		});
		$('#payment_period2').datepicker({
			dateFormat: "dd-mm-yy",
			onSelect: function (startDate) {
				$('#payment_period1').datepicker('option', 'maxDate', startDate);
			}
		});
		
		$('#bill_date').datepicker({
			dateFormat: "dd-mm-yy",
			onSelect: function (startDate) {
				$('#bill_no').datepicker('option', 'minDate', startDate);
			}
		});
		$('#add_asset_payment').validate({
			rules: {
				asset_no:{
					required:true
				},
				payment_type:{
					required:true
				},
				employee_id:{
					required:true
				},
				donor:{
					required:true
				},
				cost_centre:{
					required:true
				},
				vendor:{
					required:true
				},
				payment_period1:{
					required:true
				},
				payment_period2:{
					required:true
				},
				bill_date:{
					required:true
				},
				bill_no:{
					required:true
				},
				total_amount:{
					required:true
				},
				other_employee_id:{
					required:true
				},
				other_donor:{
					required:true
				},
				other_cost_centre:{
					required:true
				}
			},
			messages: {
				asset_no: "Enter asset number",
				payment_type: "Select payment",
				employee_id: "Select employee",
				donor: "Enter donor",
				cost_centre: "Select subline item",
				vendor: "Enter vendor",
				payment_period1: "Enter payment period from",
				payment_period2: "Enter payment period to",
				bill_date: "Enter bill date",
				bill_no: "Enter bill number",
				total_amount: "Enter input type",
				other_employee_id: "Enter others",
				other_donor: "Enter others",
				other_cost_centre: "Enter others"
			}
		});
		$(document).on('click', '#payment_type', function () {
			$(".employee_id").css('display','none');
			if($(this).val() == 'usage'){
				$(".employee_id").css('display','block');
			}
		});
		$(document).on('click', '#employee_id', function () {
			$(".other_employee_id").css('display','none');
			if($(this).val() == 'others'){
				$(".other_employee_id").css('display','block');
			}
		});
		$(document).on('click', '#donor', function () {
			$(".other_donor").css('display','none');
			if($(this).val() == 'others'){
				$(".other_donor").css('display','block');
			}
		});
		$(document).on('click', '#cost_centre', function () {
			$(".other_cost_centre").css('display','none');
			if($(this).val() == 'others'){
				$(".other_cost_centre").css('display','block');
			}
		});
		
		$(document).on('click', '#submit_btn', function () {
			if($("#add_asset_payment").valid() == true){
				$("#add_asset_payment").submit();
			}
			return false;
		});
		
		$(".numberField").on("input", function (evt) {
			var self = $(this);
			self.val(self.val().replace(/[^0-9]/g, ''));
			self.val(inrFormat(self.val()));
			if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
				evt.preventDefault();
			}
		});
		
		
		$(".edt_btnVital").on("click", function (evt) {
			$("#append_value").append('<div  class="form-group append_value value_cls_div"><input name="value[]" style="width: 80%;display: initial;"  class="form-control edit_cls value_cls" type="text" placeholder=""> <a href="javascript:void(0)" class="master_deluser clr_red" id="delLocation"><i class="fas fa-trash-alt"></i>Remove</a></div>');
			return false;
		});
		
		$(document).ready(function() {
			var selected_criteria = '<?php echo $progress_master->criteria; ?>';
			var mastertype = '<?php echo $progress_master->mastertype; ?>';
			var datas = $.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>index.php/incubation_master/ajax_criteria",
				data: {'mastertypes':mastertype,'selected_criteria':selected_criteria,'isajax':true},
				dataType:'json',
				success: function(datas) {
					$("#criteria").html('');
					if(datas.status ==1){
						$("#criteria").html(datas.response);
					}
				}
			});
			
		});
		
		$(document).on('change', '#mastertype', function (selected_criteria) {
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
			$(".add_value").css('display','none');
			
			if(input_type =='Listbox' || input_type =='Radio'|| input_type =='Checkbox'){
				$("#add_value").css('display','block');
				$(".add_value").css('display','block');
			}else{
				$(".value_cls").val('');
				$(".append_value").remove();
				$(".value_cls_div").hide();
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
			
			$(document).on('input', '.commonAlphaNum', function(evt) {
				var self = $(this);
				self.val(self.val().replace(/[^0-9\.]/g, ''));
				self.val(inrFormat(self.val()));
				var patt = new RegExp(/[0-9\,.]*[.]{1}[0-9]{2}/i);
				var matchedString = self.val().match(patt);
				if (matchedString) {
					self.val(matchedString);
				}
			});
		
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
			if(!$("#insertincubation_field").valid()){
				e.preventDefault();
			}else{
				$('#insertincubation_field').submit();
			}
		});
		
		
	
	function inrFormat(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        var z = 0;
        var len = String(x1).length;
        var num = parseInt((len / 2) - 1);
        while (rgx.test(x1)) {
            if (z > 0) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            } else {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
                rgx = /(\d+)(\d{2})/;
            }
            z++;
            num--;
            if (num == 0) {
                break;
            }
        }
        return x1 + x2;
    }
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