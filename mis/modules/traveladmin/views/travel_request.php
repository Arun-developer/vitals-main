<?php
$this->load->view('vitals_header.php', array('main_menu' => 'travellist', 'page_title' => 'Travel Request Form', 'module' => 'travel_accom'));
?>

<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'travellist_request')); ?>
        </div>

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
                        <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
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

        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content pad-hr15">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <h4>Travel Request Form</h4>
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <form method="post" id="travelrequest_form" name="travelrequest_form" action="<?php echo base_url() . 'index.php/travel/add_edit_travel_request'; ?>" class="form" novalidate autocomplete="off">
                        <div style="height: 20px;"></div>
						
						 <div class="plan-structure-vital vital_windowScroll">
							<div class="tab-slider--container">
								<div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
									<main class="page-content">
										
										<div class="inputplan-structureall plan-structure-new tabpanel-details">
										
											<div class="row">
										
											 <input type="hidden" class="form-control" name="vendor_id" id="vendor_id" value="<?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->id;} ?>" />
											<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
												<div class="form-group">
												    <input type="radio" name="default_employee" onclick="employeeType('Yes')" value="Yes" checked="checked" style="margin-right: 10px;">Yes, Villgro has all my details
												</div>
												
											</div>
											
											
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
											
												<div class="form-group">
												    <input type="radio" name="default_employee" value="No" onclick="employeeType('No')" style="margin-right: 10px;">No, I'd like to specify traveller details for this request  
												</div>
												
											</div>
											
										</div>
										
										<div class="table_configcontentnew pad-bt0">
													
												</div>
												
												<input type="hidden" name="account_number_err" id="account_number_err">
												<input type="hidden" name="delete_ids" id="delete_ids" />
												<input type="hidden" name="master_type" id="master_type" value="<?php echo $master_type; ?>" />
											
											</div>
											  <div class="row">
												<div class="col-12 col-sm-4  col-md-4 ">
													<div class="text-left">
														<ul class="vitals-links saveLinkView">
															<?php if($user_status =='1'){ ?>
																<?php if($vendorDetails->status=='' || $vendorDetails->status== 3 ) { ?>
																	<li><input type="submit" id="submit_btn" onclick="submitMultiple();" value="Send Approval" class="wdt_100 vital_yellow_btn submitMultiple"></li>
																	<li><a href="" class="wdt_100 vital_bordered_btn">Cancel</a></li>
																<?php } ?>
															<?php } ?>
															
															<?php if($user_status =='2'){ ?>
																<?php if($vendorDetails->status=='1') { ?>
																	<li><input type="button" id="approved" value="Approved" class="wdt_100 vital_yellow_btn"></li>
																	<li><input type="button" id="amend" value="Amend" style="background: #db9090;border: #db9090;" class="wdt_100 vital_yellow_btn"></li>
																<?php } ?>
															<?php } ?>
														</ul>
													</div>
												</div>
											</div>
										
									</main>
								</div>
							</div>
						</div>
						
                        <div class="table_configcontentnew pad-bt0">
                            <div class="tabpanel-title">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
                                        <ul class="milestone-links">
                                            <li class="">
                                                <a><i></i>&nbsp;Person's Details</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                        <ul class="milestone-links">
                                            <li class="brd-left-onboard">
                                                <a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                            <table id="travel_request_form" class="table table-hover dt-responsive">
                                <thead>
                                    <tr>
                                        <th width="18px" class="removeArrow" style="text-align: center"><!--<input class='master_check_all' type='checkbox' name='master_check_all' id='master_check_all'>--></th>
                                        <th width="35%">Name(Ms/Mr. First Name Surname) <span class="text-danger">*</span></th>
                                        <th width="20%">Mobile Number </th>
                                        <th width="20%">DOB</th>
                                        <th width="20%">Nationality <span class="text-danger">*</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="odd row_cls_0">
                                        <td class="sorting_1" tabindex="0">
                                            <!--<input type="hidden" name="edit_id[]" value="" ><input class="form-control master_check" data-attr="0" type="checkbox" name="master_check[1]">-->
                                        </td>
                                        <td id="set_user_type_0">
                                            <input class="form-control commonAlphaNum user_name_0 user_name_text" type="text" value="" name="user_name[]">
											<select class="form-control user_name user_name_0 user_name_select" data-attr="count_0" name="user_id[]">
                                                <option value="">--Select--</option>
                                                <?php foreach ($userList as $list) { ?>
                                                    <option value="<?php echo $list['id']; ?>"><?php echo $list['user_name']; ?></option>
                                                <?php } ?>
                                                <option value="other">Other</option>
                                            </select>
                                       
                                        </td>
                                        <td>
                                            <input class="form-control commonAlphaNum mobile_number_0" type="text" value="" name="mobile_number[]">
                                        </td>
                                        <td>
                                            <input class="form-control datepicker dob_0" type="text" value="" placeholder="dd-mm-yy" name="dob[]">
										</td>
                                        <td>
											<select class="form-control nationality_0" data-attr="count_0" name="nationality[]">
												<option value="">--Select--</option>
                                                    <?php foreach ($nationality as $nation) { ?>
                                                        <option value="<?= $nation['id']; ?>" <?php
                                                        if ($nation['id'] == $employee[0]['nationality']) {
                                                            echo 'selected';
                                                        }
                                                        ?>><?= $nation['nationality']; ?></option>
                                                    <?php } ?>
											</select>
													
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <input type="hidden" name="delete_ids" id="delete_ids" />
                        <br>
                        <div class="row other_user_div">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <h4 style="font-size: 17px;padding: 0px 0px 0px;margin: 0;letter-spacing: 0.5px;">Travel Information</h4>
                                
								<div class="inputplan-structureall plan-structure-new tabpanel-details">
										
									<div class="row">
										<input type="hidden" class="form-control" name="vendor_id" id="vendor_id" value="<?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->id;} ?>" />
										<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
											<div class="form-group">
												<label>Purpose of Travel <span class="text-danger">*</span></label>
												<textarea class="form-control purpose_of_travel" type="text" value="" name="purpose_of_travel"></textarea>
											</div>
											<div class="form-group">
												<label>Donor <span class="text-danger">*</span></label>
												<select class="form-control" name="donor_list" id="donor" onchange="getBudgetList('1', this.value);">
													<option value="">--Select--</option>
												</select>
											</div>   
										</div>
										
										
										
										<div class="col-12 col-md-4 col-lg-4 col-xl-4">
											<div class="form-group">
												<label>Sector <span class="text-danger">*</span></label>
												<select class="form-control" data-attr="count_0" name="sector">
													<option value="">--Select--</option>
													<?php foreach ($sector_details as $list) { ?>
														<option value="<?php echo $list->id; ?>"><?php echo $list->sector; ?></option>
													<?php } ?>
												</select>
											</div> 
											
											<div class="form-group">
											<br>
												<label>Budget <span class="text-danger">*</span></label>
												<select class="form-control"  onchange="getLineList('1', this.value);" name="budget_list" id="budget" >
													<option value="">--Select--</option>
												</select>
											</div>
											
										

										</div>
										<div class="col-12 col-md-4 col-lg-4 col-xl-4">
											<div class="form-group">
												<label>Programme <span class="text-danger">*</span></label>
												 <select class="form-control" name="programme" id='programme_id' onchange="getDonorList('1', this.value);">
													<option value=''>--Select--</option>
													<?php foreach ($program_list as $program) { ?>
														<option value='<?= $program['programme_id']; ?>'><?= $program['programme']; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="form-group">
											<br>
												<label>Line Item  <span class="text-danger">*</span></label>
												<select class="form-control" name="line_item" id="line_item" >
													<option value="">--Select--</option>
												</select>
											</div>
										</div>
										
										<div class="col-12 col-md-4 col-lg-4 col-xl-4">
											<div class="form-group">
											<br>
												<label>Mode of Transport  <span class="text-danger">*</span></label>
												<select class="form-control" name="mode_of_transport" id="mode_of_transport" >
													<option value="">--Select--</option>
													<option value="Bus">Bus</option>
													<option value="Train">Train</option>
													<option value="Flight">Flight</option>
												</select>
											</div>
										</div>
										
									</div>
									<ul class="vitals-links">
										<label>Do you require stay   <span class="text-danger">*</span></label>
										<li class="mob_fulfill">
										
											<label style="font-size: 12px !important;"></label>
											<div class="form-group has-search-right mar-bt8 wdt_100">
												<input type="radio" name="require_stay" onclick="showHotel('Yes')" value="Yes" checked="checked" style="margin-right: 10px;">Yes
											</div>
										</li>
										<li class="mob_fulfill">
											<label style="font-size: 12px !important;"></label>
											<div class="form-group has-search-right mar-bt8 wdt_100">
												<input type="radio" name="require_stay" value="round" onclick="showHotel('No')" style="margin-right: 10px;">No
											</div>
										</li>
									</ul>
                            </div>
								<div class="hotel_details_div">
								<h4 style="font-size: 17px;padding: 0px 0px 0px;margin: 0;letter-spacing: 0.5px;">Hotel Details</h4>
								<div class="inputplan-structureall plan-structure-new tabpanel-details ">
										
									<div class="row">
										<input type="hidden" class="form-control" name="vendor_id" id="vendor_id" value="<?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->id;} ?>" />
										<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
											<div class="form-group">
												<label>Hotel Details <span class="text-danger">*</span></label>
												<textarea class="form-control hotel_details" type="text" value="" name="hotel_details"></textarea>
											</div>
											<div class="form-group">
												<label>Check in Date <span class="text-danger">*</span></label>
												<input class="form-control commonAlphaNum datepicker"  placeholder="dd-mm-yy" type="text" value="" name="check_in_date">
											</div>   
										</div>
										
										
										
										<div class="col-12 col-md-4 col-lg-4 col-xl-4">
											<div class="form-group">
												<label>City <span class="text-danger">*</span></label>
												  <input class="form-control commonAlphaNum" type="text" value="" name="city">
											</div> 
											<div class="form-group">
											<br>
												<label>Check Out Date <span class="text-danger">*</span></label>
												<input class="form-control commonAlphaNum datepicker" placeholder="dd-mm-yy" type="text" value="" name="check_out_date">
											</div>  
											
										

										</div>
										<div class="col-12 col-md-4 col-lg-4 col-xl-4">
											<div class="form-group">
												<label>No.of. nights <span class="text-danger">*</span></label>
												 <input class="form-control commonAlphaNum" type="text" value="" name="number_of_nights">
											</div>
											<div class="form-group">
											<br>
												<label>	Booking instructions   <span class="text-danger">*</span></label>
												<textarea class="form-control booking_instructions" type="text" value="" name="booking_instructions"></textarea>
											</div>
											
											
										</div>
									</div>
									<ul class="vitals-links">
										<label>	Occupancy    <span class="text-danger">*</span></label>
										<li class="mob_fulfill">
										
											<label style="font-size: 12px !important;"></label>
											<div class="form-group has-search-right mar-bt8 wdt_100">
												<input type="radio" name="occupancy" value="Single" checked="Single" style="margin-right: 10px;">Single
											</div>
										</li>
										<li class="mob_fulfill">
											<label style="font-size: 12px !important;"></label>
											<div class="form-group has-search-right mar-bt8 wdt_100">
												<input type="radio" name="occupancy" value="Double" style="margin-right: 10px;">Double
											</div>
										</li>
									</ul>
                            </div>
                            </div>
							<?php /* <div id="flight_details_div">
								<div class="table_configcontentnew pad-bt0">
									<div class="tabpanel-title">
										<div class="row">
											<div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
												<ul class="milestone-links">
													<li class="">
														<a><i></i>&nbsp;Flight Details</a>
													</li>
												</ul>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
												<ul class="milestone-links">
													<li class="brd-left-onboard">
														<a href="javascript:void(0)" id="addFilghtMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>

								<div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
									<table id="travel_request_flight_form" class="table table-hover dt-responsive">
										<thead>
											<tr>
												<th width="18px" class="removeArrow" style="text-align: center"><!--<input class='master_check_all' type='checkbox' name='master_check_all' id='master_check_all'>--></th>
												<th width="20%">Flight Name <span class="text-danger">*</span></th>
												<th width="15%">From <span class="text-danger">*</span></th>
												<th width="15%">To <span class="text-danger">*</span></th>
												<th width="10%">Travel Date From <span class="text-danger">*</span></th>
												<th width="10%">Travel Date Return <span class="text-danger">*</span></th>
												<th width="15%">Flight Details <span class="text-danger">*</span></th>
												<th width="15%">Additional Comments </th>
												
											</tr>
										</thead>
										<tbody>
											<tr role="row" class="odd row_cls_0">
												<td class="sorting_1" tabindex="0">
													<!--<input type="hidden" name="edit_id[]" value="" ><input class="form-control master_check" data-attr="0" type="checkbox" name="master_check[1]">-->
												</td>
												<td id="set_user_type_0">
													<input class="form-control commonAlphaNum flight_name_0" type="text" value="" name="flight_name[]">
												</td>
												<td>
													<input class="form-control commonAlphaNum flight_from_0" type="text" value="" name="flight_from[]">
												</td>
												<td>
													<input class="form-control commonAlphaNum flight_to_0" type="text" value="" name="flight_to[]">
												</td>
												<td>
													<input class="form-control datepicker flight_travel_from_date_0" type="text" value="" placeholder="dd-mm-yy" name="flight_travel_from_date[]">
												</td>
												<td>
													<input class="form-control datepicker flight_travel_to_date_0" type="text" value="" placeholder="dd-mm-yy" name="flight_travel_to_date[]">
												</td>
												<td>
												   <textarea class="form-control flight_details_0" type="text" value="" name="flight_details[]"></textarea>
												</td>
												<td>
												   <textarea class="form-control flight_comments_0" type="text" value="" name="flight_comments[]"></textarea>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div> */ ?>
						<div id="train_details_div">
						<?php /* <div class="table_configcontentnew pad-bt0">
								<div class="tabpanel-title">
									<div class="row">
										<div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
											<ul class="milestone-links">
												<li class="">
													<a><i></i>&nbsp;Train Details</a>
												</li>
											</ul>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
											<ul class="milestone-links">
												<li class="brd-left-onboard">
													<a href="javascript:void(0)" id="addTrainMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							
						<div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                            <table id="travel_request_train_form" class="table table-hover dt-responsive">
                                <thead>
                                    <tr>
                                        <th width="5%" class="removeArrow" style="text-align: center"><!--<input class='master_check_all' type='checkbox' name='master_check_all' id='master_check_all'>--></th>
                                        <th width="20%">Train Name <span class="text-danger">*</span></th>
                                        <th width="15%">From <span class="text-danger">*</span></th>
                                        <th width="15%">To <span class="text-danger">*</span></th>
                                        <th width="10%">Travel Date From <span class="text-danger">*</span></th>
										<th width="10%">Travel Date Return <span class="text-danger">*</span></th>
                                        <th width="5%">Class<span class="text-danger">*</span></th>
                                        <th width="15%">Additional Comments</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="odd row_cls_0">
                                        <td class="sorting_1" tabindex="0">
                                            <!--<input type="hidden" name="edit_id[]" value="" ><input class="form-control master_check" data-attr="0" type="checkbox" name="master_check[1]">-->
                                        </td>
                                        <td id="set_user_type_0">
                                            <input class="form-control commonAlphaNum train_name_0" type="text" value="" name="train_name[]">
                                        </td>
                                        <td>
                                            <input class="form-control commonAlphaNum train_from_0" type="text" value="" name="train_from[]">
                                        </td>
										<td>
                                            <input class="form-control commonAlphaNum train_to_0" type="text" value="" name="train_to[]">
                                        </td>
                                        <td>
                                            <input class="form-control datepicker train_travel_from_date_0" type="text" value="" placeholder="dd-mm-yy" name="train_travel_from_date[]">
										</td>
										<td>
                                            <input class="form-control datepicker train_travel_to_date_0" type="text" value="" placeholder="dd-mm-yy" name="train_travel_to_date[]">
										</td>
										<td>
										   <input class="form-control datepicker train_class_0" type="text" value=""  name="train_class[]">
										</td>
										<td>
                                           <textarea class="form-control train_comments_0" type="text" value="" name="train_comments[]"></textarea>
										</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> */ ?>
                        </div>
						<div id="bus_details_div">
						<?php /* <div class="table_configcontentnew pad-bt0">
								<div class="tabpanel-title">
									<div class="row">
										<div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
											<ul class="milestone-links">
												<li class="">
													<a><i></i>&nbsp;Bus Details</a>
												</li>
											</ul>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
											<ul class="milestone-links">
												<li class="brd-left-onboard">
													<a href="javascript:void(0)" id="addBusMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
							
						<div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                            <table id="travel_request_bus_form" class="table table-hover dt-responsive">
                                <thead>
                                    <tr>
                                        <th width="5%" class="removeArrow" style="text-align: center"><!--<input class='master_check_all' type='checkbox' name='master_check_all' id='master_check_all'>--></th>
                                        <th width="20%">Bus Details <span class="text-danger">*</span></th>
                                        <th width="15%">From <span class="text-danger">*</span></th>
                                        <th width="15%">To <span class="text-danger">*</span></th>
                                        <th width="10%">Travel Date From <span class="text-danger">*</span></th>
										<th width="10%">Travel Date Return <span class="text-danger">*</span></th>
                                        <th width="15%">Additional Comments</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="odd row_cls_0">
                                        <td class="sorting_1" tabindex="0">
                                            <!--<input type="hidden" name="edit_id[]" value="" ><input class="form-control master_check" data-attr="0" type="checkbox" name="master_check[1]">-->
                                        </td>
                                        <td id="set_user_type_0">
											<textarea class="form-control bus_details_0" type="text" value="" name="bus_details[]"></textarea>
                                        </td>
                                        <td>
                                            <input class="form-control commonAlphaNum from_0" type="text" value="" name="from[]">
                                        </td>
										<td>
                                            <input class="form-control commonAlphaNum to_0" type="text" value="" name="to[]">
                                        </td>
                                        <td>
                                            <input class="form-control datepicker travel_from_date_0" type="text" value="" placeholder="dd-mm-yy" name="travel_from_date[]">
										</td>
										<td>
                                            <input class="form-control datepicker travel_to_date_0" type="text" value="" placeholder="dd-mm-yy" name="travel_to_date[]">
										</td>
										<td>
                                           <textarea class="form-control comments_0" type="text" value="" name="comments[]"></textarea>
										</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>*/ ?>
                        </div>
					 
                    
                </div>
				<div id="submit_btn_cls">
					<ul class="vitals-links">
						<li><input type="submit" id="submit_btn" class="vital_yellow_btn wdt_100" value="Send request">

						</li>
						<li><a href="" class="wdt_100 vital_bordered_btn">Cancel</a></li>
					</ul>
				</div>
						
			</form>
            </main>
        </div>
    </div>
</div>
</div>
</div>

<div class="modal" id="deletemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Are you sure you want to delete selected items?</h4>
                            <p>you are about to delete <span id="delCount"></span> selected row, you can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.js"></script>

<script type="text/javascript">
	
	$(document).ready(function () {
	 	getEmployeeType  = $('input[name="default_employee"]:checked').val();
		getRequireStay  = $('input[name="require_stay"]:checked').val();
		get_mode_of_transport  = $('input[name="mode_of_transport"]:checked').val();
		$(".user_name_text").css("display", "none");
		$(".user_name_select").css("display", "block");	
		if(employeeType =='No'){
			$(".user_name_text").css("display", "block");
			$(".user_name_select").css("display", "none");	
		}
		showHotel(getRequireStay);
		ShowTransportForm(get_mode_of_transport);
	});
	
	$("#mode_of_transport").on('change', function (e) {
		var getTransportType =  $(this).val();
		ShowTransportForm(getTransportType); 
	 });
	 
	 function ShowTransportForm(getTransportType){
		/* $("#bus_details_div").css("display", "none");
		$("#train_details_div").css("display", "none");
		$("#flight_details_div").css("display", "none");
		if(getTransportType=='Bus'){
			$("#bus_details_div").css("display", "block");
		}else if(getTransportType=='Train'){
			$("#train_details_div").css("display", "block");
		}else if(getTransportType=='Flight'){
			$("#flight_details_div").css("display", "block");	
		} */
	 }
	
	
	function employeeType(employeeType){
		
		$("#user_name").val("");
		$(".default_employee_div").css("display","block");
		//$("#travel_request_form :input").prop("disabled", false);
		$(".other_user_div").css("display", "block");
		var attr_res = 0;
		$(".user_name_" + attr_res).val('');
		$(".mobile_number_" + attr_res).val('');
		$(".dob_" + attr_res).val('');
		$(".nationality_" + attr_res).val('');
		$('#travel_request_form tbody').empty();
		if(employeeType =='No'){
			$(".default_employee_div").css("display","none");
			$(".other_user_div").css("display", "none");
			$(".user_name_text").css("display", "block");
			$(".user_name_select").css("display", "none");
			$('#addMore').trigger('click');
		}else if(employeeType =='Yes'){
			$(".user_name_text").css("display", "none");
			$(".user_name_select").css("display", "block");	
			$('#addMore').trigger('click');
		}
	} 
	
	function showHotel(requireStay){
		$(".hotel_details_div").css("display", "none");
		if(requireStay =='Yes'){
			$(".hotel_details_div").css("display", "block");
		}
	}
	
	
	 function getDonorList(id, val) { 
			
        if (id != '') {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/approval/getDonorNameList",
                type: 'POST',
                "data": {'program': val},
                success: function (msg) {
                    var output = [];
                    output.push('<option value="">--Select--</option>');
                    var split_arr = JSON.parse(msg);
                    var i = 0;

                    $('#pro_head').val(split_arr[i].emp_name);
                    $.each(split_arr, function (key, value) {
                        output.push('<option value="' + split_arr[i].donor_id + '">' + split_arr[i].master_name + '</option>');
                        i++;
                    });
                    $('#donor').html(output.join(''));
                }
            });
        }
    }
	
	 function getBudgetList(id, val) {
        if (id != '') {
            var program = $('#programme_id').val();
            var donor = $('#donor').val(); 
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/travel/getBudgetItemList",
                type: 'POST', 
                "data": {'program': program, 'donor': donor},
                success: function (msg) {
                    var output = [];
                    output.push('<option value="">--Select--</option>');
                    var split_arr = JSON.parse(msg);
                    var i = 0;
                    $.each(split_arr, function (key, value) {
                        output.push('<option value="' + split_arr[i].budget_id + '">' + split_arr[i].master_name + '</option>');
                        i++;
                    });
                    $('#budget').html(output.join(''));
                }
            });
        }
    }
	
	function getLineList(id, val) {
        if (id != '') {
            var program = $('#programme_id').val();
            var donor = $('#donor').val();
            var budget = $('#budget').val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/travel/getLineList",
                type: 'POST',
                "data": {'program': program, 'donor': donor,'budget': budget},
                success: function (msg) {
                    var output = [];
                    output.push('<option value="">--Select--</option>');
                    var split_arr = JSON.parse(msg);
                    var i = 0;
                    $.each(split_arr, function (key, value) {
                        output.push('<option value="' + split_arr[i].line_itemid + '">' + split_arr[i].master_name + '</option>');
                        i++;
                    });
                    $('#line_item').html(output.join(''));
                }
            });
        }
    }
	
	

    $('#travelrequest_form').validate({
        rules: {
            "name": "required",
            "destination_from[]": "required",
            "destination_to[]": "required",
            "travel_mode[]": "required",
            "travel_mode_return[]": "required",
            "user_name[]": "required",
            "flight_name[]": "required",
            "from[]": "required",
            "to[]": "required",
            "travel_from_date[]": "required",
            "travel_to_date[]": "required",
            "user_id[]": "required",
           
            "comments[]": "required",
			
            "purpose_of_travel": "required",
            "sector": "required",
            "programme": "required",
            "donor_list": "required",
            "budget_list": "required",
            "line_item": "required",
            "mode_of_transport": "required",
			
            "train_name[]": "required",
            "train_from[]": "required",
            "train_to[]": "required",
            "train_travel_from_date[]": "required",
            "train_travel_to_date[]": "required",
            "train_class[]": "required",
            "train_comments[]": "required",
			
			"flight_name[]": "required",
            "flight_from[]": "required",
            "flight_to[]": "required",
            "flight_travel_from_date[]": "required",
            "flight_travel_to_date[]": "required",
            "flight_details[]": "required",
            "flight_comments[]": "required",
			
			"bus_details[]": "required",
            "from[]": "required",
            "to[]": "required",
            "travel_from_date[]": "required",
            "travel_to_date[]": "required",
            "comments[]": "required",
			
            "hotel_details": "required",
            "city": "required",
            "number_of_nights": "required",
            "check_in_date": "required",
            "check_out_date": "required",
            "booking_instructions": "required",
			
			
        },
        messages: {
			"user_id[]": "Select employee",
            "name": "Select employee",
			"user_name[]": "Enter Name",
            "destination_from[]": "Enter location",
            "destination_to[]": "Enter destination",
            "travel_mode[]": "Enter travel mode",
            "travel_mode_return[]": "Select travel mode",
			
			"purpose_of_travel": "Enter purpose of travel",
            "sector": "Select sector",
            "programme": "Select programme",
            "donor_list": "Select donor",
            "budget_list": "Select budget",
			 "line_item": "Select line item",
            "mode_of_transport": "Select mode of transport",
           
			"hotel_details": "Enter hotel details",
            "city": "Enter city",
            "number_of_nights": "Enter no of nights ",
            "check_in_date": "Enter check in date",
            "check_out_date": "Enter check out date",
            "booking_instructions": "Enter booking instructions",
			
			"bus_details[]": "Enter train name",
            "from[]": "Enter from",
            "to[]": "Enter to",
            "travel_from_date[]": "choose from date",
            "travel_to_date[]": "choose to date",
            "comments[]": "Enter comments",
			
			"train_name[]": "Enter train name",
            "train_from[]": "Enter from",
            "train_to[]": "Enter to",
            "train_travel_from_date[]": "choose from date",
            "train_travel_to_date[]": "choose to date",
            "train_class[]": "Enter class",
            "train_comments[]": "Enter comments",
			
            "flight_name[]": "Enter flight name",
            "flight_from[]": "Enter from",
            "flight_to[]": "Enter to",
            "flight_travel_from_date[]": "Enter travel from date",
            "flight_travel_to_date[]": "Enter travel to date",
            "flight_details[]": "Enter flight details",
            "flight_comments[]": "Enter comments",
			
			
        }
    });


    

    $(document).on('click', '#submit_btn', function (e) {
        console.log(err_count);
        $("#travelrequest_form").valid();
        if ($("#travelrequest_form").valid() == true && err_type == 0) {
            $("#travelrequest_form").submit()
        }
        return false;
    });

    function removeRow(div_id) {
        $('#add_tr_' + div_id).closest('tr').remove();
    }

    function removeRow_mf(div_id) {
        $('#add_tr_' + div_id).closest('tr').remove();
    }


   

    $(document).on('click', '.accomodation_cls', function () {
        var current_val = $(this).val();
        $("#accommodation_status").css('display', 'none');
        if (current_val == 'yes') {
            $("#accommodation_status").css('display', 'block');
        }
    });

    $(document).on('click', '.summaryEdit', function () {
        $("#edit_status").val("1");
        $(".edit_cls").attr("disabled", false);
        $(".multiselect").attr("disabled", false);
        $("#submit_btn_cls").css("display", "block");
        $(".edit").addClass("activeTabs");
    });

                                                //dof

												$('.datepicker').datepicker({
                                                    dateFormat: "dd-mm-yy",
                                                });	

                                                $('#date_from').datepicker({
                                                    dateFormat: "dd-mm-yy",
                                                    onSelect: function (startDate) {
                                                        $('#date_to').datepicker('option', 'minDate', startDate);
                                                    }
                                                });

                                                $('#date_to').datepicker({
                                                    dateFormat: "dd-mm-yy",
                                                    onSelect: function (startDate) {
                                                        $('#date_from').datepicker('option', 'maxDate', startDate);
                                                    }
                                                });

                                                $(document).on('change', '.user_name', function () {
													
													var current_attr = $(this).attr('data-attr'); 
													var attr_res = current_attr.replace('count_', '');
													var user_id = $(this).val()?.trim();
													let exists = false;
													$('[name="user_name[]"]').each(function () {
														let val = $(this).val()?.trim();
														if (val === user_id && this !== $('[data-attr="' + current_attr + '"]')[0]) {
															exists = true;
															return false;
															
														}
													});

													if (exists) {
														$(".row_cls_" + attr_res).remove();
														alert('This user is already selected.');
														$(this).val('');
														return;
													}
													
                                                    $(".mobile_number_" + attr_res).val('');
                                                    $(".dob_" + attr_res).val('');
                                                    $(".nationality_" + attr_res).val('');

                                                    if (user_id != '' && user_id != 'other') {
                                                        var id = $('#delete_ids').val();
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "<?php echo base_url(); ?>index.php/travel/ajax_get_data",
                                                            data: {
                                                                user_id: user_id,
                                                                current_attr: current_attr,
                                                            },
                                                            dataType: 'json',
                                                            success: function (resp) {
                                                                if (resp.response == 1) {
                                                                    var user_name = resp.data.emp_name;
                                                                    var attr_val = resp.data.attr_val;
                                                                    var gender = resp.data.gender;
                                                                    var mobile_number = resp.data.mobile_number;
                                                                    var nationality = resp.data.nationality;
                                                                    var emp_dob = resp.data.emp_dob;
								
																	$(".mobile_number_" + attr_val).val(mobile_number);
																	$(".dob_" + attr_val).val(emp_dob);
																	$(".nationality_" + attr_val).val(parseInt(nationality));
                                                                    //$("#travel_request_form :input").prop("disabled", true);
                                                                
                                                                }
                                                            }
                                                        });
                                                    } else {
                                                       
                                                    }
                                                });

                                                $(document).on('click', '#deleteRecord', function () {
                                                    var common_ids = [];
                                                    $(".master_check").each(function (index) {
                                                        if ($(this).is(":checked")) {
                                                            var attr_val = $(this).attr('data-attr');
                                                            $('.row_cls_' + attr_val).remove();
                                                        }
                                                        $('.deleteMsg').removeClass('display-hide');
                                                    });
                                                    $('#deletemodal').modal('hide');
                                                    var no_data_append = '<tr class="odd no_data" style="text-align: center;"><td valign="top" colspan="5" class="dataTables_empty none-pointer">No data available in table</td></tr>';
                                                    if ($('input:checkbox.master_check:checked').length == 0) {
                                                        //$("#travel_request_form tbody").append(no_data_append);
                                                    } else {
                                                        $(".no_data").remove();
                                                    }
                                                });

                                                $(document).on('click', '.master_check', function () {
                                                    if (!$(this).is(":checked")) {
                                                        $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                                                        $(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled", true);
                                                    } else {
                                                        $(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
                                                        $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
                                                    }
                                                    if ($('input:checkbox.master_check').length > 0) {
                                                        if ($('input:checkbox.master_check').length != $('input:checkbox.master_check:checked').length) {
                                                            console.log('1');
                                                            $('.master_check_all').prop('checked', false);
                                                            $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
                                                        } else if ($('input:checkbox.master_check').length == $('input:checkbox.master_check:checked').length) {
                                                            console.log('2');
                                                            $('.master_check_all').prop('checked', true);
                                                        }
                                                    }
                                                    if ($('input:checkbox.master_check:checked').length == 0) {
                                                        console.log('3');
                                                        $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                                                    }
                                                });

                                                $(document).on('click', '.master_check_all', function () {
                                                    if (!$(this).is(":checked")) {
                                                        $('.master_check').prop('checked', false);
                                                        $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                                                        $(".master_check").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled", true);

                                                    } else {
                                                        $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
                                                        $('.master_check').prop('checked', true);
                                                        $(".master_check").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
                                                    }
                                                    $(".new_field").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled", false);

                                                    if ($(".new_field").length > 0) {
                                                        $("#save_btn").removeClass("opacity5 none-pointer");
                                                    }
                                                });

                                                $(document).on('click', '.new_field', function () {
                                                    $(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled", false);
                                                    $("#save_btn").removeClass("opacity5 none-pointer");
                                                });

                                             

$(document).on('click', '#addMore', function () {
    $(".dataTables_empty").css('display', 'none');
    var i, travel_request_count;
    i = travel_request_count = $('#travel_request_form tr').length + 1;
	getFormCount =  $('#travel_request_form tr').length-2;
	if(!$('.user_name_'+getFormCount).val()){
		/* $(".user_name_"+getFormCount).valid();
		return false; */
	}
													
	var nationalityOptions = '';
	<?php foreach ($nationality as $list): ?>
		nationalityOptions += '<option value="<?php echo $list['id']; ?>"><?php echo addslashes($list['nationality']); ?></option>';
	<?php endforeach; ?>
	nationalityOptions += '<option value="other">Other</option>';
	
	getEmployeeType  = $('input[name="default_employee"]:checked').val();
	user_name_field ='';
	if(getEmployeeType =='Yes'){
		var userListOptions = '';
		<?php foreach ($userList as $list): ?>
			userListOptions += '<option value="<?php echo $list['id']; ?>"><?php echo addslashes($list['user_name']); ?></option>';
		<?php endforeach; ?>
		user_name_field = '<select  class="form-control user_name user_name_select user_name_' + travel_request_count + '" data-attr="count_' + travel_request_count + '" name="user_name[]"><option value="">--Select--</option>' + userListOptions + '</select>';
	}else if(getEmployeeType =='No'){
		user_name_field = '<input class="form-control commonAlphaNum user_name_text user_name_' + travel_request_count + '" type="text" value="" name="user_name[]" >'
	}
    var datas = '<tr id="add_tr_' + i + '" class="add_more remove_more row_cls_'+travel_request_count+'"><td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeRow(' + i + ');" aria-hidden = "true" ></i></td>';
    datas += '<td id="set_user_type_' + travel_request_count + '" >'+user_name_field+'</td>';
    datas += '<td><input class="form-control commonAlphaNum mobile_number_' + travel_request_count + '" type="text" value="" name="mobile_number[]" ></td><td><input placeholder="dd-mm-yy"  class="form-control datepicker dob_' + travel_request_count + '" type="text" value="" name="dob[]" ></td><td><select  class="form-control nationality_' + travel_request_count + '" name="nationality[]"><option value="">--Select--</option>' + nationalityOptions + '</select></td></tr>';
    $("#travel_request_form tbody").prepend(datas);
	$('.datepicker').datepicker({
		dateFormat: "dd-mm-yy",
	});	
    $("#save_btn").removeClass("opacity5 none-pointer");

  
});
$(document).on('click', '#addFilghtMore', function () {
    $(".dataTables_empty").css('display', 'none');
    var i, travel_request_count;
    i = travel_request_count = $('#travel_request_flight_form tr').length + 1;
	getFormCount =  $('#travel_request_flight_form tr').length-2;
	if(!$('.flight_name_'+getFormCount).val()){
		/* $(".flight_name_"+getFormCount).valid();
		$(".from_"+getFormCount).valid();
		$(".to_"+getFormCount).valid();
		$(".travel_from_date_"+getFormCount).valid();
		$(".travel_to_date_"+getFormCount).valid();
		$(".flight_details_"+getFormCount).valid();
		$(".comments_"+getFormCount).valid();
		return false; */
	}							
	
    var datas = '<tr id="add_tr_' + i + '" class="add_more remove_more"><td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeRow(' + i + ');" aria-hidden = "true" ></i></td>';
    datas += '<td id="set_flight_name_' + travel_request_count + '" ><input class="form-control commonAlphaNum flight_name_' + travel_request_count + '" type="text" value="" name="flight_name[]" ></td>';
    datas += '<td id="set_from_' + travel_request_count + '" ><input class="form-control commonAlphaNum from_' + travel_request_count + '" type="text" value="" name="from[]" ></td>';
    datas += '<td id="set_to_' + travel_request_count + '" ><input class="form-control commonAlphaNum to_' + travel_request_count + '" type="text" value="" name="to[]" ></td>';
    datas += '<td id="set_travel_from_date_' + travel_request_count + '" ><input placeholder="dd-mm-yy" class="form-control datepicker commonAlphaNum to_' + travel_request_count + '" type="text" value="" name="travel_from_date[]" ></td>';
    datas += '<td id="set_travel_to_date_' + travel_request_count + '" ><input placeholder="dd-mm-yy" class="form-control datepicker commonAlphaNum to_' + travel_request_count + '" type="text" value="" name="travel_to_date[]" ></td>';
    datas += '<td id="set_flight_details_' + travel_request_count + '" ><textarea class="form-control  to_' + travel_request_count + '" type="text" value="" name="flight_details[]" ></textarea></td>';
    datas += '<td id="set_comments_' + travel_request_count + '" ><textarea class="form-control  to_' + travel_request_count + '" type="text" value="" name="comments[]" ></textarea></td>';
    $("#travel_request_flight_form tbody").prepend(datas);
	$('.datepicker').datepicker({
		dateFormat: "dd-mm-yy",
	});	
    $("#save_btn").removeClass("opacity5 none-pointer");
});

$(document).on('click', '#addTrainMore', function () {
    $(".dataTables_empty").css('display', 'none');
    var i, travel_request_count;
    i = travel_request_count = $('#travel_request_train_form tr').length + 1;
	getFormCount =  $('#travel_request_train_form tr').length-2;
	if($(".train_name_"+getFormCount).valid() || $(".train_from_"+getFormCount).valid() || $(".train_to_"+getFormCount).valid() || (".train_travel_from_date_"+getFormCount).valid() || $(".train_travel_to_date_"+getFormCount).valid() || $(".train_class_"+getFormCount).valid() || $(".train_comments_"+getFormCount).valid()){
		//return false;
	}							
	
    var datas = '<tr id="add_tr_' + i + '" class="add_more remove_more"><td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeRow(' + i + ');" aria-hidden = "true" ></i></td>';
    datas += '<td id="set_train_name_' + travel_request_count + '" ><input class="form-control commonAlphaNum train_name_' + travel_request_count + '" type="text" value="" name="train_name[]" ></td>';
    datas += '<td id="set_from_' + travel_request_count + '" ><input class="form-control commonAlphaNum train_from_' + travel_request_count + '" type="text" value="" name="train_from[]" ></td>';
    datas += '<td id="set_to_' + travel_request_count + '" ><input class="form-control commonAlphaNum train_to_' + travel_request_count + '" type="text" value="" name="train_to[]" ></td>';
    datas += '<td id="set_travel_from_date_' + travel_request_count + '" ><input placeholder="dd-mm-yy" class="form-control datepicker commonAlphaNum train_travel_from_date_' + travel_request_count + '" type="text" value="" name="train_travel_from_date[]" ></td>';
    datas += '<td id="set_travel_to_date_' + travel_request_count + '" ><input placeholder="dd-mm-yy" class="form-control datepicker commonAlphaNum train_travel_to_date_' + travel_request_count + '" type="text" value="" name="train_travel_to_date[]" ></td>';
    datas += '<td id="set_class_' + travel_request_count + '" ><input class="form-control  train_class_' + travel_request_count + '" type="text" value="" name="train_class[]" ></td>';
    datas += '<td id="set_comments_' + travel_request_count + '" ><textarea class="form-control  train_comments_' + travel_request_count + '" type="text" value="" name="train_comments[]" ></textarea></td>';
    $("#travel_request_train_form tbody").prepend(datas);
	$('.datepicker').datepicker({
		dateFormat: "dd-mm-yy",
	});	
    $("#save_btn").removeClass("opacity5 none-pointer");
});



$(document).on('click', '#addBusMore', function () {
    $(".dataTables_empty").css('display', 'none');
    var i, travel_request_count;
    i = travel_request_count = $('#travel_request_bus_form tr').length + 1;
	getFormCount =  $('#travel_request_bus_form tr').length-2;
		
	if($(".bus_details_"+getFormCount).valid() || $(".from_"+getFormCount).valid() || $(".to_"+getFormCount).valid() || (".from_"+getFormCount).valid() || $(".travel_from_date"+getFormCount).valid() || $(".travel_to_date"+getFormCount).valid() || $(".comments_"+getFormCount).valid()){
		//return false;
	}
	
    var datas = '<tr id="add_tr_' + i + '" class="add_more remove_more"><td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeRow(' + i + ');" aria-hidden = "true" ></i></td>';
    datas += '<td id="set_bus_details_' + travel_request_count + '" ><textarea class="form-control commonAlphaNum bus_details_' + travel_request_count + '" type="text" value="" name="train_name[]" ></textarea></td>';
    datas += '<td id="set_from_' + travel_request_count + '" ><input class="form-control commonAlphaNum from_' + travel_request_count + '" type="text" value="" name="from[]" ></td>';
    datas += '<td id="set_to_' + travel_request_count + '" ><input class="form-control commonAlphaNum to_' + travel_request_count + '" type="text" value="" name="to[]" ></td>';
    datas += '<td id="set_travel_from_date_' + travel_request_count + '" ><input placeholder="dd-mm-yy" class="form-control datepicker commonAlphaNum travel_from_date_' + travel_request_count + '" type="text" value="" name="travel_from_date[]" ></td>';
    datas += '<td id="set_travel_to_date_' + travel_request_count + '" ><input placeholder="dd-mm-yy" class="form-control datepicker commonAlphaNum travel_to_date_' + travel_request_count + '" type="text" value="" name="travel_to_date[]" ></td>';
    datas += '<td id="set_comments_' + travel_request_count + '" ><textarea class="form-control  comments_' + travel_request_count + '" type="text" value="" name="comments[]" ></textarea></td>';
    $("#travel_request_bus_form tbody").prepend(datas);
	$('.datepicker').datepicker({
		dateFormat: "dd-mm-yy",
	});	
    $("#save_btn").removeClass("opacity5 none-pointer");
});






$(document).on('click', '#delUser', function () {
    $('#delCount').val('');
    var sel_item = $(".master_check:checkbox:checked").length;
    $('#delCount').html(sel_item);
    if (sel_item > 0)
        $('#deletemodal').modal('show');
});

function submit_fields() {
    $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
    $('#insertEditDocument_type').submit();
}

$(document).on('input', '.commonAlphaNum', function () {
    if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
        this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
    }
});

</script>

<style type="text/css">
    .dataTables_scrollBody {
        margin-top: -15px;
    }
</style>

</body>
</html>