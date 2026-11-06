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
                    <form method="post" id="travelrequest_form" name="travelrequest_form" action="<?php echo base_url() . 'index.php/traveladmin/add_edit_travel_request'; ?>" class="form" novalidate autocomplete="off">
                        <div style="height: 20px;"></div>
						
						 <div >
							<div class="tab-slider--container">
								<div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
									<main class="page-content">
										
										<div class="inputplan-structureall plan-structure-new tabpanel-details">
											<div class="row">
												 <input type="hidden" class="form-control" name="travel_request_id" id="travel_request_id" value="<?php echo $this->uri->segment(3); ?>" />
												<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
													<div class="form-group">
														<input  <?php if ($get_travel_request[0]['default_employee_type'] == 'Yes') { echo 'checked'; } ?>
														type="radio" name="default_employee" onclick="employeeType('Yes')" value="Yes" checked="checked" style="margin-right: 10px;">Yes, Villgro has all my details
													</div>
												</div>
												<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
													<div class="form-group">
														<input <?php if ($get_travel_request[0]['default_employee_type'] == 'No') { echo 'checked'; } ?> type="radio" name="default_employee" value="No" onclick="employeeType('No')" style="margin-right: 10px;">No, I'd like to specify traveller details for this request  
													</div>
												</div>
												<div class="col-12 col-md-4 col-lg-4 col-xl-4">
													<div class="form-group">
														<label>Reporting Manager<span>*</span></label>
														<select class="form-control" name="to_RO" readonly>
															<option value=''>--Select--</option>
															<?php foreach ($reporting_list as $ro) { ?>
																<option selected value='<?= $ro['emp_id']; ?>' ><?= $ro['emp_name']; ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
													<div class="form-group">
														Ro Status : <?php
														 
														if (php72_cmp($get_travel_request[0]['ro_status']) == 1) {
															$status = 'Pending';
														} else if (php72_cmp($get_travel_request[0]['ro_status']) == 2) {
															$status = 'Cancel';
														} else if (php72_cmp($get_travel_request[0]['ro_status']) ==3) {
															$status = 'Confirm';
														} else if (php72_cmp($get_travel_request[0]['ro_status']) == 4) {
															$status = 'Reject';
														}

														echo $status; 
														
														?>
													</div>
												</div>
											</div>
										<div class="table_configcontentnew pad-bt0"></div>
												
												<input type="hidden" name="account_number_err" id="account_number_err">
												<input type="hidden" name="delete_ids" id="delete_ids" />
												<input type="hidden" name="master_type" id="master_type" value="<?php echo $master_type; ?>" />
											
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
                                           <?php  /*  <li class="brd-left-onboard">
                                                <a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                            </li> */ ?>
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
									<?php if (php72_count($get_travel_personal_details) > 0) {
											foreach ($get_travel_personal_details as $dataList) {
										?>
										 <tr role="row" class="odd row_cls_0">
											<td class="sorting_1" tabindex="0">
												<!--<input type="hidden" name="edit_id[]" value="" ><input class="form-control master_check" data-attr="0" type="checkbox" name="master_check[1]">-->
											</td>
											<td id="set_user_type_0">
												<input class="form-control commonAlphaNum user_name_0 user_name_text" type="text" value="<?php echo $dataList['user_name']; ?>" name="user_name[]">
												<select class="form-control user_name user_name_0 user_name_select" data-attr="count_0" name="user_id[]">
													<option value="">--Select--</option>
													<?php foreach ($userList as $list) { ?>
														<option <?php
															if ($list['id'] == $dataList['user_id']) {
																echo 'selected';
															}
															?> value="<?php echo $list['id']; ?>"><?php echo $list['user_name']; ?></option>
													<?php } ?>
													<option value="other">Other</option>
												</select>
										   
											</td>
											<td>
												<input class="form-control commonAlphaNum mobile_number_0" type="text" value="<?php echo $dataList['mobile_number']; ?>" name="mobile_number[]">
											</td>
											<td>
												<input class="form-control datepicker dob_0" type="text" value="<?php echo date('d-m-Y',strtotime($dataList['dob'])); ?>" placeholder="dd-mm-yy" name="dob[]">
											</td>
											<td>
												<select class="form-control nationality_0" data-attr="count_0" name="nationality[]">
													<option value="">--Select--</option>
														<?php foreach ($nationality as $nation) { ?>
															<option value="<?= $nation['id']; ?>" <?php
															if ($nation['id'] == $dataList['nationality']) {
																echo 'selected';
															}
															?>><?= $nation['nationality']; ?></option>
														<?php } ?>
												</select>
														
											</td>
										</tr>
										
											<?php } }else{ ?>
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
									<?php } ?>
									
									
										
										
                                   
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
												<textarea class="form-control purpose_of_travel" type="text" name="purpose_of_travel"><?php echo $get_travel_request[0]['purpose_of_travel']; ?></textarea>
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
														<option
															<?php
																if ($list->id == $get_travel_request[0]['sector']) {
																echo 'selected'; 
																} ?> 
															value="<?php echo $list->id; ?>"><?php echo $list->sector; ?></option>
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
														<option 
														<?php if ($program['programme_id'] == $get_travel_request[0]['programme']) {
																echo 'selected';
															} ?>  value='<?= $program['programme_id']; ?>'><?= $program['programme']; ?></option>
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
													<option <?php if ($get_travel_request[0]['mode_of_transport'] == 'Bus') { echo 'selected'; } ?> value="Bus">Bus</option>
													<option <?php if ($get_travel_request[0]['mode_of_transport'] == 'Train') { echo 'selected'; } ?> value="Train">Train</option>
													<option <?php if ($get_travel_request[0]['mode_of_transport'] == 'Flight') { echo 'selected'; } ?> value="Flight">Flight</option>
												</select>
											</div>
										</div>
										
									</div>
									<ul class="vitals-links">
										<label>Do you require stay   <span class="text-danger">*</span></label>
										<li class="mob_fulfill">
										
											<label style="font-size: 12px !important;"></label>
											<div class="form-group has-search-right mar-bt8 wdt_100">
												<input  <?php if ($get_travel_request[0]['require_stay'] == 'Yes') { echo 'checked'; } ?> type="radio" name="require_stay" onclick="showHotel('Yes')" value="Yes" checked="checked" style="margin-right: 10px;">Yes
											</div>
										</li>
										<li class="mob_fulfill">
											<label style="font-size: 12px !important;"></label>
											<div class="form-group has-search-right mar-bt8 wdt_100">
												<input <?php if ($get_travel_request[0]['require_stay'] == 'No') { echo 'checked'; } ?>  type="radio" name="require_stay" value="No" onclick="showHotel('No')" style="margin-right: 10px;">No
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
												<textarea class="form-control hotel_details" type="text" value="" name="hotel_details"><?php if ($get_travel_request[0]['hotel_details']) { echo $get_travel_request[0]['hotel_details']; } ?></textarea>
											</div>
											<div class="form-group">
												<label>Check in Date <span class="text-danger">*</span></label>
												<input class="form-control commonAlphaNum datepicker"  placeholder="dd-mm-yy" type="text" value="<?php if ($get_travel_request[0]['check_in_date']) { echo date('d-m-Y',strtotime($get_travel_request[0]['check_in_date'])); } ?>" name="check_in_date">
											</div> 
											<div class="form-group">											
												<ul class="vitals-links">
													<label>	Occupancy    <span class="text-danger">*</span></label>
													<li class="mob_fulfill">
													
														<label style="font-size: 12px !important;"></label>
														<div class="form-group has-search-right mar-bt8 wdt_100">
															<input <?php if ($get_travel_request[0]['occupancy'] == 'Single') { echo 'checked'; } ?> type="radio" name="occupancy" value="Single" checked="Single" style="margin-right: 10px;">Single
														</div>
													</li>
													<li class="mob_fulfill">
														<label style="font-size: 12px !important;"></label>
														<div class="form-group has-search-right mar-bt8 wdt_100">
															<input <?php if ($get_travel_request[0]['occupancy'] == 'Double') { echo 'checked'; } ?> type="radio" name="occupancy" value="Double" style="margin-right: 10px;">Double
														</div>
													</li>
												</ul>
											</div> 
										</div>
										<div class="col-12 col-md-4 col-lg-4 col-xl-4">
											<div class="form-group">
												<label>City <span class="text-danger">*</span></label>
												  <input class="form-control commonAlphaNum" type="text" value="<?php if ($get_travel_request[0]['city']) { echo $get_travel_request[0]['city']; } ?>" name="city">
											</div> 
											<div class="form-group">
											<br>
												<label>Check Out Date <span class="text-danger">*</span></label>
												<input class="form-control commonAlphaNum datepicker" placeholder="dd-mm-yy" type="text" value="<?php if ($get_travel_request[0]['check_out_date']) { echo  date('d-m-Y',strtotime($get_travel_request[0]['check_out_date'])); } ?>" name="check_out_date">
											</div>  
											
											<div class="form-group">
											
												<label>	Additional comments   <span class="text-danger"></span></label>
												<textarea class="form-control" type="text" value="" name="additional_comments"><?php if ($get_travel_request[0]['additional_comments']) { echo $get_travel_request[0]['additional_comments']; } ?></textarea>
											</div>
										

										</div>
										<div class="col-12 col-md-4 col-lg-4 col-xl-4">
											<div class="form-group">
												<label>No.of. nights <span class="text-danger">*</span></label>
												 <input class="form-control commonAlphaNum" type="text" value="<?php if ($get_travel_request[0]['no_of_nights']) { echo $get_travel_request[0]['no_of_nights']; } ?>" name="number_of_nights">
											</div>
											<div class="form-group">
											<br>
												<label>	Booking instructions</label>
												<textarea class="form-control booking_instructions" type="text" name="booking_instructions"><?php if ($get_travel_request[0]['booking_instructions']) { echo $get_travel_request[0]['booking_instructions']; } ?></textarea>
											</div>

											
											
										</div>
									</div>
									

                            </div>
                            </div>
							<div id="flight_details_div">
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
												<th width="1px" class="removeArrow" style="text-align: center"><!--<input class='master_check_all' type='checkbox' name='master_check_all' id='master_check_all'>--></th>
												<th width="25%">Flight Details <span class="text-danger"></span></th>
												<th width="25%">From /To<span class="text-danger">*</span></th>
												<th width="25%">Travel Date <span class="text-danger">*</span></th>
												<th width="30%">Additional Comments </th>
												
												
											</tr>
										</thead>
										<tbody>
											<?php if (php72_count($get_travel_flight_details) > 0) {
										    foreach($get_travel_flight_details as $dataList){ ?>
												<tr role="row" class="odd row_cls_0">
												<td class="sorting_1" tabindex="0">
													<!--<input type="hidden" name="edit_id[]" value="" ><input class="form-control master_check" data-attr="0" type="checkbox" name="master_check[1]">-->
												</td>
												<td id="set_user_type_0">
													<input class="form-control commonAlphaNum flight_name_0" type="text" value="<?php echo $dataList['flight_name']; ?>" name="flight_name[<?php echo $dataList['id']; ?>]">
												</td>
												<td>
													<select class="form-control flight_from_to_type_0" data-attr="flight_from_to_type_0" name="flight_from_to_type[<?php echo $dataList['id']; ?>]">
														<option value="">--Select--</option>
														<option value="From" <?php if($dataList['flight_from_to_type']=='From'){ echo "selected"; } ?>>From</option>
														<option value="To" <?php if($dataList['flight_from_to_type']=='To'){ echo "selected"; } ?>>To</option>
													</select>
												</td>
										
												<?php /* <td>
													<input class="form-control commonAlphaNum flight_from_0" type="text" value="<?php echo $dataList['flight_from']; ?>" name="flight_from[<?php echo $dataList['id']; ?>]">
												</td>
												<td>
													<input class="form-control commonAlphaNum flight_to_0" type="text" value="<?php echo $dataList['flight_to']; ?>" name="flight_to[<?php echo $dataList['id']; ?>]">
												</td> */ ?>
												<td>
													<input class="form-control datepicker flight_travel_from_date_0" type="text" value="<?php if($dataList['flight_travel_from_date']){ echo date('d-m-Y',strtotime($dataList['flight_travel_from_date']));  }; ?>" placeholder="dd-mm-yy" name="flight_travel_from_date[<?php echo $dataList['id']; ?>]">
												</td>
												<td>
												   <textarea class="form-control flight_comments_0" type="text"  name="flight_comments[<?php echo $dataList['id']; ?>]"><?php echo $dataList['comments']; ?></textarea>
												</td>
											</tr>
											 
											<?php }
									}else{  ?>
									
									<tr role="row" class="odd row_cls_0">
												<td class="sorting_1" tabindex="0">
													<!--<input type="hidden" name="edit_id[]" value="" ><input class="form-control master_check" data-attr="0" type="checkbox" name="master_check[1]">-->
												</td>
												<td id="set_user_type_0">
													<input class="form-control commonAlphaNum flight_name_0" type="text" value="" name="flight_name[]">
												</td>
												<td>
													<select class="form-control flight_from_to_type_0" data-attr="flight_from_to_type_0" name="flight_from_to_type[]">
														<option value="">--Select--</option>
														<option value="From" >From</option>
														<option value="To" >To</option>
													</select>
												</td>
												<?php /* <td>
													<input class="form-control commonAlphaNum flight_from_0" type="text" value="" name="flight_from[]">
												</td>
												<td>
													<input class="form-control commonAlphaNum flight_to_0" type="text" value="" name="flight_to[]">
												</td> */ ?>
												<td>
													<input class="form-control datepicker flight_travel_from_date_0" type="text" value="" placeholder="dd-mm-yy" name="flight_travel_from_date[]">
												</td>
												<td>
												   <textarea class="form-control flight_comments_0" type="text" value="" name="flight_comments[]"></textarea>
												</td>
											</tr>
											
									
								<?php  }?>
										</tbody>
									</table>
								</div>
							</div>
						<div id="train_details_div">
						<div class="table_configcontentnew pad-bt0">
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
                                         <th width="1%" class="removeArrow" style="text-align: center"><!--<input class='master_check_all' type='checkbox' name='master_check_all' id='master_check_all'>--></th>
                                        <th width="18%">Train Name <span class="text-danger"></span></th>
                                        <th width="10%">From /To<span class="text-danger">*</span></th>
                                        <th width="10%">Travel Date <span class="text-danger">*</span></th>
                                        <th width="5%">Class<span class="text-danger"></span></th>
                                        <th width="15%">Additional Comments</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
								<?php if (php72_count($get_travel_train_details) > 0) {
										foreach($get_travel_train_details as $dataList){ ?>
										
										<tr role="row" class="odd row_cls_0">
											<td class="sorting_1" tabindex="0">
												<!--<input type="hidden" name="edit_id[]" value="" ><input class="form-control master_check" data-attr="0" type="checkbox" name="master_check[1]">-->
											</td>
											<td id="set_user_type_0">
												<input class="form-control commonAlphaNum train_name_0" type="text" value="<?php echo $dataList['train_name']; ?>" name="train_name[<?php echo $dataList['id']; ?>]">
											</td>
											<td>
													<select class="form-control train_from_to_type_0" data-attr="train_from_to_type_0" name="train_from_to_type[<?php echo $dataList['id']; ?>]">
														<option value="">--Select--</option>
														<option value="From" <?php if($dataList['train_from_to_type']=='From'){ echo "selected"; } ?>>From</option>
														<option value="To" <?php if($dataList['train_from_to_type']=='To'){ echo "selected"; } ?>>To</option>
													</select>
												</td>
												
											<?php /* <td>
												<input class="form-control commonAlphaNum train_from_0" type="text" value="<?php echo $dataList['train_from']; ?>" name="train_from[]">
											</td>
											<td>
												<input class="form-control commonAlphaNum train_to_0" type="text" value="<?php echo $dataList['train_to']; ?>" name="train_to[]">
											</td> */ ?>
											<td>
												<input class="form-control datepicker train_travel_from_date_0" type="text" value="<?php if($dataList['train_travel_from_date']){ echo date('d-m-Y',strtotime($dataList['train_travel_from_date']));  }; ?>" placeholder="dd-mm-yy" name="train_travel_from_date[<?php echo $dataList['id']; ?>]">
											</td>
											
											<td>
											   <input class="form-control train_class_0" type="text" value="<?php echo $dataList['train_class']; ?>"  name="train_class[<?php echo $dataList['id']; ?>]">
											</td>
											<td>
											   <textarea class="form-control train_comments_0" type="text" value="" name="train_comments[<?php echo $dataList['id']; ?>]"><?php echo $dataList['comments']; ?></textarea>
											</td>
										</tr>
										<?php }
									}else{  ?>
											
										<tr role="row" class="odd row_cls_0">
											<td class="sorting_1" tabindex="0">
												<!--<input type="hidden" name="edit_id[]" value="" ><input class="form-control master_check" data-attr="0" type="checkbox" name="master_check[1]">-->
											</td>
											<td id="set_user_type_0">
												<input class="form-control commonAlphaNum train_name_0" type="text" value="" name="train_name[]">
											</td>
											<td>
												<select class="form-control train_from_to_type_0" data-attr="train_from_to_type_0" name="train_from_to_type[]">
													<option value="">--Select--</option>
													<option value="From">From</option>
													<option value="To" >To</option>
												</select>
											</td>
											
											<?php /* <td>
												<input class="form-control commonAlphaNum train_from_0" type="text" value="" name="train_from[]">
											</td>
											<td>
												<input class="form-control commonAlphaNum train_to_0" type="text" value="" name="train_to[]">
											</td> */ ?>
											<td>
												<input class="form-control datepicker train_travel_from_date_0" type="text" value="" placeholder="dd-mm-yy" name="train_travel_from_date[]">
											</td>
											
											<td>
											   <input class="form-control train_class_0" type="text" value=""  name="train_class[]">
											</td>
											<td>
											   <textarea class="form-control train_comments_0" type="text" value="" name="train_comments[]"></textarea>
											</td>
										</tr>
									
									
									<?php }  ?>
										
										
										
                                </tbody>
                            </table>
                        </div>
                        </div>
						<div id="bus_details_div">
						<div class="table_configcontentnew pad-bt0">
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
                                        <th width="1%" class="removeArrow" style="text-align: center"><!--<input class='master_check_all' type='checkbox' name='master_check_all' id='master_check_all'>--></th>
                                        <th width="18%">Bus Details <span class="text-danger"></span></th>
                                        <th width="10%">From /To <span class="text-danger">*</span></th>
                                        <th width="10%">Travel Date <span class="text-danger">*</span></th>
                                        <th width="15%">Additional Comments</th>
                                        
                                    </tr>
                                </thead>
                                 <tbody>
								<?php if (php72_count($get_travel_bus_details) > 0) {
										foreach($get_travel_bus_details as $dataList){ ?>
										
										<tr role="row" class="odd row_cls_0">
											
											<input type="hidden" name="edit_bus_details_id[]" value="<?php echo $dataList['id']; ?>" >
											<td class="sorting_1" tabindex="0">
												<!--<input type="hidden" name="edit_id[]" value="" ><input class="form-control master_check" data-attr="0" type="checkbox" name="master_check[1]">-->
											</td>
											<td id="set_user_type_0">
												<textarea class="form-control bus_details_0" type="text"  name="bus_details[<?php echo $dataList['id']; ?>]" > <?php echo $dataList['bus_details']; ?></textarea>
											</td>
											<td>
												<select class="form-control bus_from_to_type_0" data-attr="bus_from_to_type_0" name="bus_from_to_type[<?php echo $dataList['id']; ?>]">
													<option value="">--Select--</option>
													<option value="From" <?php if($dataList['bus_from_to_type']=='From'){ echo "selected"; } ?>>From</option>
													<option value="To"  <?php if($dataList['bus_from_to_type']=='To'){ echo "selected"; } ?>>To</option>
												</select>
											</td>
											
											<td>
												<input class="form-control datepicker travel_from_date_0" type="text"  name="travel_from_date[<?php echo $dataList['id']; ?>]"  value="<?php if($dataList['travel_from_date']){ echo date('d-m-Y',strtotime($dataList['travel_from_date']));  }; ?>" placeholder="dd-mm-yy" >
											</td>
											<td>
											   <textarea class="form-control comments_0" type="text" value="" name="comments[<?php echo $dataList['id']; ?>]"><?php echo $dataList['comments']; ?></textarea>
											</td>
										</tr>
									
										<?php }
									}else{  ?>
										
										
                                    <tr role="row" class="odd row_cls_0">
                                        <td class="sorting_1" tabindex="0">
                                            <!--<input type="hidden" name="edit_id[]" value="" ><input class="form-control master_check" data-attr="0" type="checkbox" name="master_check[1]">-->
                                        </td>
                                        <td id="set_user_type_0">
											<textarea class="form-control bus_details_0" type="text" value="" name="bus_details[]"></textarea>
                                        </td>
										<td>
													<select class="form-control bus_from_to_type_0" data-attr="bus_from_to_type_0" name="bus_from_to_type[]">
														<option value="">--Select--</option>
														<option value="From" >>From</option>
														<option value="To" >To</option>
													</select>
												</td>
                                       
                                        <td>
                                            <input class="form-control datepicker travel_from_date_0" type="text" value="" placeholder="dd-mm-yy" name="travel_from_date[]">
										</td>
										<td>
                                           <textarea class="form-control comments_0" type="text" value="" name="comments[]"></textarea>
										</td>
                                    </tr>
									
								<?php  }?>
								<tbody>
								
								
								
								
								
								
                                </tbody>
                            </table>
                        </div>
                        </div>
                        </div>
					 
                    
                </div>
				<div id="submit_btn_cls">
					<ul class="vitals-links">
						<?php if($get_travel_request[0]['status']=='1' && $this->session->userdata('isAdmin')=='Yes'){ ?>
							<li><input type="submit" id="submit_btn" class="vital_yellow_btn wdt_100" value="Save"></li>
						<?php } ?>
						<?php if($get_travel_request[0]['status']=='1' && $this->session->userdata('isAdmin')=='Yes'){ ?>
							<li><input type="button" id="confirm_request" class="vital_yellow_btn wdt_100" value="Confirm"></li>
						<?php } ?>
						<?php if($get_travel_request[0]['status']=='1' && $this->session->userdata('isAdmin')=='Yes'){ ?>
							<li><input type="button" id="reject_request" class="vital_yellow_btn wdt_100" value="Reject"></li>
						<?php } ?>
						<?php if($get_travel_request[0]['status']=='1' && $this->session->userdata('isAdmin')=='Yes'){ ?>
						<li><a href="javascript:void(0)" id="cancel_request" class="vital_yellow_btn wdt_100">Cancel</a></li>
						<?php } ?>
						
						<?php if($get_travel_request[0]['status']=='3' && $this->session->userdata('isAdmin')=='Yes'){ ?>
							<li><input type="button" id="export_pdf" class="vital_yellow_btn wdt_100" value="Export Pdf"></li>
						<?php } ?>
					</ul>
				</div>
						
			</form>
            </main>
        </div>
    </div>
</div>
</div>
</div>
 
 <form name="an_close_form" id="export_pdf_form" method="post" action="<?php echo base_url(); ?>index.php/traveladmin/exportPdf/<?= $this->uri->segment(3); ?>">

</form>

 
<div class="modal" id="cancel_request_model" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Are you want to cancel this travel request.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form name="an_close_form" id="cancel_request_form" method="post" action="<?php echo base_url(); ?>index.php/travel/cancelRequest/<?= $this->uri->segment(3); ?>">
                    <br>
                    <div class="text-right">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose an_close_model_btn" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="submit" class="btn btn-success" id="cancel_travel_request">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



 
<div class="modal" id="confirm_request_model" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Are you want to confirm this travel request.</h5>
                
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form name="an_close_form" id="confirm_request_form" method="post" action="<?php echo base_url(); ?>index.php/traveladmin/confirmRequest/<?= $this->uri->segment(3); ?>">
                        <div class="form-group">
							<label for="comments">Comments </label>
							<textarea class="form-control comments" name="comments" id="comments" rows="3"></textarea>
						</div>
					<br>
                    <div class="text-right">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose an_close_model_btn" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="submit" class="btn btn-success" id="confirm_request_submit">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="reject_request_model" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="justify-content-center wdt100"><i class="fas fa-exclamation-alt text-warning"></i> Are you want to reject this travel request.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <form name="an_close_form" id="reject_request_form" method="post" action="<?php echo base_url(); ?>index.php/traveladmin/rejectRequest/<?= $this->uri->segment(3); ?>">
                    <br>
                    <div class="text-right">
                        <button type="button" class="btn btn-default"><a class="close portfolioclose an_close_model_btn" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                        <button type="submit" class="btn btn-success" id="reject_request_submit">OK</button>
                    </div>
                </form>
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


	$(document).on('click', '#confirm_request', function () {
		$('#confirm_request_model').modal('show');
	});
	$(document).on('click', '#export_pdf', function () {
		$('#export_pdf_form').submit();
	});
	
	$(document).on('click', '#confirm_request_submit', function () {
		$('#cancel_request_form').submit();
	});
	
	$(document).on('click', '#reject_request', function () {
		$('#reject_request_model').modal('show');
	});
	$(document).on('click', '#reject_request_submit', function () {
		$('#reject_request_form').submit();
	});

	
	$(document).ready(function () {
	 	getEmployeeType  = $('input[name="default_employee"]:checked').val();
		getRequireStay  = $('input[name="require_stay"]:checked').val();
		get_mode_of_transport  = $('#mode_of_transport').val();
		
		//$(".other_user_div").css("display", "block");
		$(".user_name_text").css("display", "none");
		$(".user_name_select").css("display", "block");	
		if(getEmployeeType =='No'){
			$(".user_name_text").css("display", "block");
			$(".user_name_select").css("display", "none");	
			//$(".other_user_div").css("display", "none");	
		}
		showHotel(getRequireStay);
		ShowTransportForm(get_mode_of_transport);
		
		programme_id = $("#programme_id").val(); 
		getDonorList('<?php echo $get_travel_request[0]['donor']; ?>',programme_id);
		getBudgetList('<?php echo $get_travel_request[0]['budget']; ?>',programme_id);
		getLineList('<?php echo $get_travel_request[0]['line_item']; ?>',programme_id);
		
		
	});

	
	$("#mode_of_transport").on('change', function (e) {
		var getTransportType =  $(this).val();
		ShowTransportForm(getTransportType); 
	 });
	 
	 function ShowTransportForm(getTransportType){
		$("#bus_details_div").css("display", "none");
		$("#train_details_div").css("display", "none");
		$("#flight_details_div").css("display", "none");
		if(getTransportType=='Bus'){
			$("#bus_details_div").css("display", "block");
		}else if(getTransportType=='Train'){
			$("#train_details_div").css("display", "block");
		}else if(getTransportType=='Flight'){
			$("#flight_details_div").css("display", "block");	
		}
	 }
	
	
	function employeeType(employeeType){
		
		$("#user_name").val("");
		$(".default_employee_div").css("display","block");
		//$("#travel_request_form :input").prop("disabled", false);
		//$(".other_user_div").css("display", "block");
		var attr_res = 0;
		$(".user_name_" + attr_res).val('');
		$(".mobile_number_" + attr_res).val('');
		$(".dob_" + attr_res).val('');
		$(".nationality_" + attr_res).val('');
		$('#travel_request_form tbody').empty();
		if(employeeType =='No'){
			$(".default_employee_div").css("display","none");
			//$(".other_user_div").css("display", "none");
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
						var selected = (split_arr[i].donor_id == id) ? 'selected' : '';
                        output.push('<option value="' + split_arr[i].donor_id + '"'+selected+'>' + split_arr[i].master_name + '</option>');
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
            var donor = $('#donor').val()?$('#donor').val():'<?php echo $get_travel_request[0]['donor']; ?>'; 
			
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
						var selected = (split_arr[i].budget_id == id) ? 'selected' : '';
                        output.push('<option value="' + split_arr[i].budget_id + '"'+selected+'>' + split_arr[i].master_name + '</option>');
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
			var donor = $('#donor').val()?$('#donor').val():'<?php echo $get_travel_request[0]['donor']; ?>'; 
			var budget = $('#budget').val()?$('#budget').val():'<?php echo $get_travel_request[0]['budget']; ?>'; 
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
						var selected = (split_arr[i].line_itemid == id) ? 'selected' : '';
                        output.push('<option value="' + split_arr[i].line_itemid + '"'+selected+'>' + split_arr[i].master_name + '</option>');
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
            "user_name[]": "required",
            "from[]": "required",
            "to[]": "required",
            "user_id[]": "required",
           
            "purpose_of_travel": "required",
            "sector": "required",
            "programme": "required",
            "donor_list": "required",
            "budget_list": "required",
            "line_item": "required",
			
            "travel_from_date[]": "required",
			"bus_from_to_type[]": "required",
			
            "train_travel_from_date[]": "required",
			"train_from_to_type[]": "required",
			
            "flight_travel_from_date[]": "required",
			"flight_from_to_type[]": "required",
     
            "hotel_details": "required",
            "city": "required",
            "number_of_nights": "required",
            "check_in_date": "required",
            "check_out_date": "required",
			
			
        },
        messages: {
			"user_id[]": "Select employee",
            "name": "Select employee",
			"user_name[]": "Enter Name",
			
			"purpose_of_travel": "Enter purpose of travel",
            "sector": "Select sector",
            "programme": "Select programme",
            "donor_list": "Select donor",
            "budget_list": "Select budget",
			 "line_item": "Select line item",
           
			"hotel_details": "Enter hotel details",
            "city": "Enter city",
            "number_of_nights": "Enter no of nights ",
            "check_in_date": "Enter check in date",
            "check_out_date": "Enter check out date",
			
            "travel_from_date[]": "choose from date",
			"bus_from_to_type[]": "choose type",
			
            "train_travel_from_date[]": "choose from date",
			"train_from_to_type[]": "choose type",
			
            "flight_travel_from_date[]": "Enter travel from date",
			"traflight_from_to_type[]": "choose type",
			
        }
    });

    $(document).on('click', '#submit_btn', function (e) {

        $("#travelrequest_form").valid();
		$('#submit_btn').prop('disabled', false);
        if ($("#travelrequest_form").valid() == true && err_type == 0) {
			$('#submit_btn').prop('disabled', true);
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
		user_name_field = '<select  class="form-control user_name user_name_select user_name_' + travel_request_count + '" data-attr="count_' + travel_request_count + '" name="user_id[]"><option value="">--Select--</option>' + userListOptions + '</select>';
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
	from_to_type_dropdown = '<select  class="form-control flight_from_to_type_' + travel_request_count + '" data-attr="count_' + travel_request_count + '" name="flight_from_to_type[]"><option value="">--Select--</option><option value="From">From</option><option value="To">To</option></select>';
	
   var i, travel_request_count;
    i = travel_request_count = $('#travel_request_flight_form tbody tr').length;
	var getFormCount = ($('#travel_request_flight_form tbody tr').length == 1) 
    ? 0 
    : $('#travel_request_flight_form tbody tr').length - 1;

	if(!$(".flight_name_"+getFormCount).valid()   || !$(".flight_travel_from_date_"+getFormCount).valid()  ){
		$(".flight_name_"+getFormCount).valid();
		$(".flight_from_to_type_"+getFormCount).valid();
		$(".flight_travel_from_date_"+getFormCount).valid();
		return false;
	}
							
    var datas = '<tr id="add_tr_' + i + '" class="add_more remove_more"><td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeRow(' + i + ');" aria-hidden = "true" ></i></td>';
    datas += '<td id="set_flight_name_' + travel_request_count + '" ><input class="form-control commonAlphaNum flight_name_' + travel_request_count + '" type="text" value="" name="flight_name[]" ></td>';
    datas += '<td id="from_to_type_' + travel_request_count + '" >'+from_to_type_dropdown+'</td>';
	datas += '<td id="set_travel_from_date_' + travel_request_count + '" ><input placeholder="dd-mm-yy" class="form-control datepicker commonAlphaNum travel_from_date_' + travel_request_count + '" type="text" value="" name="travel_from_date[]" ></td>';
    datas += '<td id="set_comments_' + travel_request_count + '" ><textarea class="form-control  comments_' + travel_request_count + '" type="text" value="" name="comments[]" ></textarea></td>';
    $("#travel_request_flight_form tbody").append(datas);
	$('.datepicker').datepicker({
		dateFormat: "dd-mm-yy",
	});	
    $("#save_btn").removeClass("opacity5 none-pointer");
});

$(document).on('click', '#addTrainMore', function () {
    $(".dataTables_empty").css('display', 'none');
   var i, travel_request_count;
    i = travel_request_count = $('#travel_request_train_form tbody tr').length;
	var getFormCount = ($('#travel_request_train_form tbody tr').length == 1) 
    ? 0 
    : $('#travel_request_train_form tbody tr').length - 1;

	if(!$(".train_name_"+getFormCount).valid()  || !$(".train_from_to_type_"+getFormCount).valid()){
		$(".train_name_"+getFormCount).valid();
		$(".train_travel_from_date_"+getFormCount).valid();
		$(".train_travel_to_date_"+getFormCount).valid();
		$(".train_from_to_type_"+getFormCount).valid();
		return false;
	}

	
	from_to_type_dropdown = '<select  class="form-control train_from_to_type_' + travel_request_count + '"" data-attr="count_' + travel_request_count + '" name="train_from_to_type[]"><option value="">--Select--</option><option value="From">From</option><option value="To">To</option></select>';
	
    var datas = '<tr id="add_tr_' + i + '" class="add_more remove_more"><td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeRow(' + i + ');" aria-hidden = "true" ></i></td>';
    datas += '<td id="set_train_name_' + travel_request_count + '" ><input class="form-control commonAlphaNum train_name_' + travel_request_count + '" type="text" value="" name="train_name[]" ></td>';
    datas += '<td id="from_to_type_' + travel_request_count + '" >'+from_to_type_dropdown+'</td>';
	//datas += '<td id="set_from_' + travel_request_count + '" ><input class="form-control commonAlphaNum train_from_' + travel_request_count + '" type="text" value="" name="train_from[]" ></td>';
    //datas += '<td id="set_to_' + travel_request_count + '" ><input class="form-control commonAlphaNum train_to_' + travel_request_count + '" type="text" value="" name="train_to[]" ></td>';
    datas += '<td id="set_travel_from_date_' + travel_request_count + '" ><input placeholder="dd-mm-yy" class="form-control datepicker commonAlphaNum train_travel_from_date_' + travel_request_count + '" type="text" value="" name="train_travel_from_date[]" ></td>';
   datas += '<td id="set_class_' + travel_request_count + '" ><input class="form-control  train_class_' + travel_request_count + '" type="text" value="" name="train_class[]" ></td>';
    datas += '<td id="set_comments_' + travel_request_count + '" ><textarea class="form-control  train_comments_' + travel_request_count + '" type="text" value="" name="train_comments[]" ></textarea></td>';
    $("#travel_request_train_form tbody").append(datas);
	$('.datepicker').datepicker({
		dateFormat: "dd-mm-yy",
	});	
    $("#save_btn").removeClass("opacity5 none-pointer");
});



$(document).on('click', '#addBusMore', function () {
    $(".dataTables_empty").css('display', 'none');
    var i, travel_request_count;
    i = travel_request_count = $('#travel_request_bus_form tbody tr').length;
	var getFormCount = ($('#travel_request_bus_form tbody tr').length == 1) 
    ? 0 
    : $('#travel_request_bus_form tbody tr').length - 1;

	from_to_type_dropdown = '<select  class="form-control bus_from_to_type_' + travel_request_count + '" data-attr="count_' + travel_request_count + '" name="bus_from_to_type[]"><option value="">--Select--</option><option value="From">From</option><option value="To">To</option></select>';
	
	 
	if(!$(".bus_details_"+getFormCount).valid()  ||  !$(".travel_from_date_"+getFormCount).valid() ){
	
		$(".travel_to_date_"+getFormCount).valid();
		$(".bus_from_to_type_"+getFormCount).valid();
		$(".travel_from_date_"+getFormCount).valid();
		return false;
	}
	
    var datas = '<tr id="add_tr_' + i + '" class="add_more remove_more"><td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeRow(' + i + ');" aria-hidden = "true" ></i></td>';
    datas += '<td id="set_bus_details_' + travel_request_count + '" ><textarea class="form-control commonAlphaNum bus_details_' + travel_request_count + '" type="text" value="" name="train_name[]" ></textarea></td>';
    datas += '<td id="from_to_type_' + travel_request_count + '" >'+from_to_type_dropdown+'</td>';
	
	//datas += '<td id="set_from_' + travel_request_count + '" ><input class="form-control commonAlphaNum from_' + travel_request_count + '" type="text" value="" name="from[]" ></td>';
    //datas += '<td id="set_to_' + travel_request_count + '" ><input class="form-control commonAlphaNum to_' + travel_request_count + '" type="text" value="" name="to[]" ></td>';
    datas += '<td id="set_travel_from_date_' + travel_request_count + '" ><input placeholder="dd-mm-yy" class="form-control datepicker commonAlphaNum travel_from_date_' + travel_request_count + '" type="text" value="" name="travel_from_date[]" ></td>';
    datas += '<td id="set_comments_' + travel_request_count + '" ><textarea class="form-control  comments_' + travel_request_count + '" type="text" value="" name="comments[]" ></textarea></td>';
    $("#travel_request_bus_form tbody").append(datas);
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