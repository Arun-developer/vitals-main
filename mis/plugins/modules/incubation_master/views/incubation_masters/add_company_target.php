<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Villgro MIS</title>
</head>

<body>
    <?php  
    $this->load->view('incubation_masters/header.php', array('page' => 'stage_efficiency'));
	
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
                            <?php $this->load->view('incubation_masters/master_sidemenu.php', array('page' => 'stage_efficiency')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
							<div class="row dataconfig d_v_d_c">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
									<span><a href="<?php echo base_url().'index.php/incubation_master/portfolio_settings/company_target'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                                    <h4>Add Company Target</h4>
                                </div>
								<div class="col-xl-8 col-lg-6 col-md-12 col-12 text-right">
									<ul class="vitals-links">
										<li class="edit"><a href="javascript:" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
									</ul>
								</div>

                            </div>
							
							<div class="plan-structure-vital vital_windowScroll">

                                <div class="tab-slider--container tab-content">
                                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                        <main class="page-content">
											<form method="post" name="insertcompany_target" id="insertcompany_target" action="<?php echo base_url().'index.php/incubation_master/insertcompany_target'; ?>" class="form" novalidate autocomplete="off">
												<div class="inputplan-structureall plan-structure-new ">
												
													<div class="row leaveLabel">
														<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
															<div class="form-group">
																<label>Sector<span>*</span></label>
																<select name="sector"  id="sector" class="form-control">
																	<option value="">--Select--</option>
																	<?php foreach($sectorDetails as $list){?>		<option value="<?php echo $list->id; ?>" ><?php echo $list->sector; ?></option>						
																	<?php } ?>
																</select> 
															</div> 
														</div>
														<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
															<div class="form-group">
																<label>Financial Year<span>*</span></label>
																<select name="financial_year" id="financial_year"  class="form-control">
																<option value="" >--Select--</option>
																	<?php foreach($fin_year as $list){?>
																			<option value="<?php echo $list['fin_year']; ?>" ><?php echo $list['fin_year']; ?></option>
																	<?php } ?>
																</select> 
															</div>
														</div>
													</div>
													<div class="row leaveLabel">
														<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
															<div class="form-group">
																<label>Partner Type<span>*</span></label>
																<select name="partner_id" id="partner_id"   class="form-control">
																<option value="" >--Select--</option>
																	<?php foreach($barnch_details as $list){?>
																			<option value="<?php echo $list->id; ?>" ><?php echo $list->branch_name;  ?></option>
																	<?php } ?>
																</select> 
															</div>
														</div>
														<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
															<div class="form-group">
																<label>Status<span>*</span></label>
																<select name="status" id="status"   class="form-control">
																	<option value="">--Select--</option>
																	<option value="1" >Approved</option>
																	<option value="0">Disapproved </option>																</select> 
															</div>
														</div>
													</div>
													
													
													<div class="row ">
														<div class="col-12 col-md-12 col-lg-12 col-xl-12">
															<div class="table_configcontentnew">
																<table class="table">
																	<thead>
																		<tr>
																			<th></th>
																			<th>Q1</th>
																			<th>Q2</th>
																			<th>Q3</th>
																			<th>Q4</th>																			
																			<th>Annual</th>																			
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td class="vill-gray">Application</td>
																			<td><input  name="app_q1" id="app_q1" class="form-control numberField apptotal" type="text" placeholder=""></td>		
																			<td><input  name="app_q2" id="app_q2" class="form-control numberField apptotal" type="text" placeholder=""></td>		
																			<td><input  name="app_q3" id="app_q3" class="form-control numberField apptotal" type="text" placeholder=""></td>		
																			<td><input  name="app_q4" id="app_q4" class="form-control numberField apptotal" type="text" placeholder=""></td>		
																			<td><input  name="app_annual" id="app_annual" class="form-control numberField apptotal" type="text" placeholder=""></td>		
																																				
																		</tr>
																		<tr>
																			<td class="vill-gray">PA/RD</td>
																			<td><input name="pard_q1" id="pard_q1"  class="form-control numberField pardtotal" type="text" placeholder=""></td>
																			<td><input name="pard_q2" id="pard_q2"  class="form-control numberField pardtotal" type="text" placeholder=""></td>
																			<td><input name="pard_q3" id="pard_q3"  class="form-control numberField pardtotal" type="text" placeholder=""></td>
																			<td><input name="pard_q4" id="pard_q4"  class="form-control numberField pardtotal" type="text" placeholder=""></td>
																			<td><input name="pard_annual" id="pard_annual"  class="form-control numberField pardtotal" type="text" placeholder=""></td>
																																				
																		</tr>
																		<tr>
																			<td class="vill-gray">Deals at IIC</td>
																			<td><input name="iic_q1" id="iic_q1"  class="form-control numberField iictotal" type="text" placeholder=""></td>
																			<td><input name="iic_q2" id="iic_q2"  class="form-control numberField iictotal" type="text" placeholder=""></td>
																			<td><input name="iic_q3" id="iic_q3"  class="form-control numberField iictotal" type="text" placeholder=""></td>
																			<td><input name="iic_q4" id="iic_q4"  class="form-control numberField iictotal" type="text" placeholder=""></td>
																			<td><input name="iic_annual" id="iic_annual"  class="form-control numberField iictotal" type="text" placeholder=""></td>
																																						
																		</tr>
																		<tr>
																			<td class="vill-gray">Deals at EIC</td>
																			<td><input name="eic_q1" id="eic_q1"  class="form-control numberField eictotal" type="text" placeholder=""></td>
																			<td><input name="eic_q2" id="eic_q2"  class="form-control numberField eictotal" type="text" placeholder=""></td>
																			<td><input name="eic_q3" id="eic_q3"  class="form-control numberField eictotal" type="text" placeholder=""></td>
																			<td><input name="eic_q4" id="eic_q4"  class="form-control numberField eictotal" type="text" placeholder=""></td>
																			<td><input name="eic_annual" id="eic_annual"  class="form-control numberField eictotal" type="text" placeholder=""></td>
																																						
																		</tr>
																		<tr>
																			<td class="vill-gray">Total Incubatees</td>
																			<td><input name="tot_q1" id="tot_q1"  class="form-control numberField cmptotal" type="text" placeholder=""></td>
																			<td><input name="tot_q2" id="tot_q2"  class="form-control numberField cmptotal" type="text" placeholder=""></td>
																			<td><input name="tot_q3" id="tot_q3"  class="form-control numberField cmptotal" type="text" placeholder=""></td>
																			<td><input name="tot_q4" id="tot_q4"  class="form-control numberField cmptotal" type="text" placeholder=""></td>
																			<td><input name="tot_annual" id="tot_annual"  class="form-control numberField cmptotal" type="text" placeholder=""></td>
																			
																																					
																		</tr>
																		<tr>
																			<td class="vill-gray">New Incubatees</td>
																			<td><input name="new_q1" id="new_q1"  class="form-control numberField newtotal" type="text" placeholder=""></td>
																			<td><input name="new_q2" id="new_q2"  class="form-control numberField newtotal" type="text" placeholder=""></td>
																			<td><input name="new_q3" id="new_q3"  class="form-control numberField newtotal" type="text" placeholder=""></td>
																			<td><input name="new_q4" id="new_q4"  class="form-control numberField newtotal" type="text" placeholder=""></td>
																			<td><input name="new_annual" id="new_annual"  class="form-control numberField newtotal" type="text" placeholder=""></td>
																																				
																		</tr>
																		<tr>
																			<td class="vill-gray">Exit Incubatees</td>
																			<td><input name="ext_q1" id="ext_q1"  class="form-control numberField exttotal" type="text" placeholder=""></td>
																			<td><input name="ext_q2" id="ext_q2"  class="form-control numberField exttotal" type="text" placeholder=""></td>
																			<td><input name="ext_q3" id="ext_q3"  class="form-control numberField exttotal" type="text" placeholder=""></td>
																			<td><input name="ext_q4" id="ext_q4"  class="form-control numberField exttotal" type="text" placeholder=""></td>
																			<td><input name="ext_annual" id="ext_annual"  class="form-control numberField exttotal" type="text" placeholder=""></td>
																																					
																		</tr>
																		
																		
																	</tbody>
																</table>
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
	
		
		$('#insertcompany_target').validate({
			rules: {
				sector:{
					required:true
				},
				financial_year:{
					required:true
				},
				partner_id:{
					required:true
				},
				status:{
					required:true
				},
				app_q1:{
					required:true
				},pard_q1:{
					required:true
				},iic_q1:{
					required:true
				},eic_q1:{
					required:true
				},tot_q1:{
					required:true
				},ext_q1:{
					required:true
				},new_q1:{
					required:true
				},
				app_q2:{
					required:true
				},pard_q2:{
					required:true
				},iic_q2:{
					required:true
				},eic_q2:{
					required:true
				},tot_q2:{
					required:true
				},ext_q2:{
					required:true
				},new_q2:{
					required:true
				},
				app_q3:{
					required:true
				},pard_q3:{
					required:true
				},iic_q3:{
					required:true
				},eic_q3:{
					required:true
				},tot_q3:{
					required:true
				},ext_q3:{
					required:true
				},new_q3:{
					required:true
				},
				app_q4:{
					required:true
				},pard_q4:{
					required:true
				},iic_q4:{
					required:true
				},eic_q4:{
					required:true
				},tot_q4:{
					required:true
				},ext_q4:{
					required:true
				},new_q4:{
					required:true
				},
			},
			messages: {
				sector: "Select Sector Type",
				status: "Select Status",
				financial_year: "Select Financial Year",
				partner_id: "Select Partner Type",
			}
		});
		
		$(".numberField").on("input", function (evt) {
			var self = $(this);
			self.val(self.val().replace(/[^0-9]/g, ''));
			self.val(inrFormat(self.val()));
			if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) {
				evt.preventDefault();
			}
		});
		
		$(document).on('click', '.summaryEdit', function () {
			
			$("#edit_status").val("1");
			$(".edit_cls").attr("", false);
			$(".multiselect").attr("", false);
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
			if(!$("#insertcompany_target").valid()){
				e.preventDefault();
			}else{
				$('#insertcompany_target').submit();
			}
		});
		
		$(document).on('keyup', '.apptotal', function () {
        var q1 = $('#app_q1').val();
        var q2 = $('#app_q2').val();
        var q3 = $('#app_q3').val();
        var q4 = $('#app_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#app_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.pardtotal', function () {
        var q1 = $('#pard_q1').val();
        var q2 = $('#pard_q2').val();
        var q3 = $('#pard_q3').val();
        var q4 = $('#pard_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#pard_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.iictotal', function () {
        var q1 = $('#iic_q1').val();
        var q2 = $('#iic_q2').val();
        var q3 = $('#iic_q3').val();
        var q4 = $('#iic_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#iic_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.eictotal', function () {
        var q1 = $('#eic_q1').val();
        var q2 = $('#eic_q2').val();
        var q3 = $('#eic_q3').val();
        var q4 = $('#eic_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#eic_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.cmptotal', function () {
        var q1 = $('#tot_q1').val();
        var q2 = $('#tot_q2').val();
        var q3 = $('#tot_q3').val();
        var q4 = $('#tot_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#tot_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.newtotal', function () {
        var q1 = $('#new_q1').val();
        var q2 = $('#new_q2').val();
        var q3 = $('#new_q3').val();
        var q4 = $('#new_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#new_annual').val(inrFormat(value));
    });

    $(document).on('keyup', '.exttotal', function () {
        var q1 = $('#ext_q1').val();
        var q2 = $('#ext_q2').val();
        var q3 = $('#ext_q3').val();
        var q4 = $('#ext_q4').val();

        var q1Val = Number(q1.replace(/[^0-9]+/g, ""));
        var q2Val = Number(q2.replace(/[^0-9]+/g, ""));
        var q3Val = Number(q3.replace(/[^0-9]+/g, ""));
        var q4Val = Number(q4.replace(/[^0-9]+/g, ""));

        var value = q1Val + q2Val + q3Val + q4Val;
        $('#ext_annual').val(inrFormat(value));
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