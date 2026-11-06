<?php $this->load->view('vitals_header.php', array('main_menu' => 'travellist', 'page_title' => 'Approval Note Details')); ?>
<?php #$this->load->view('travel/header.php', array('main_menu' => 'request', 'page_title' => 'Approval Note Details')); ?>
<?php 
$currentTab = $this->uri->segment(3);
$requestId = $this->uri->segment(4);
?>
<?php $this->load->view('vitals_header.php', array('main_menu' => 'travellist', 'page_title' => 'Raise new Approval Note', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">

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
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
            <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'travellist')); ?>
        </div>
		
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                        <span><a href="<?php echo base_url() . 'index.php/travel/requestlist/' . $row['status']; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
                        <h4><?php echo 'Travel Booking Details - '.$this->uri->segment(4); ?></h4>
                    </div>
                    <div class="col-xl-8 col-lg-6 col-md-12 col-12 text-right">
                        <ul class="vitals-links">
						<?php  foreach ($requestListInfo as $row) { ?>
							<?php if (php72_in_array($row['employee_id'], $subUsers)) {
									switch ($row['reporting_approval']) {
									case 'pending':
								?>
							<li class="edit">
							<a href="javascript:" data-toggle="modal" data-target="#confirmed" class="master_aduser summaryEdit"><span><i class="far fa-check-circle"></i></span>Confirm</a>
							 <a href="javascript:" data-toggle="modal" data-target="#cancelrequest" class="master_aduser summaryEdit"><span><i class="far fa-check-circle"></i></span>Cancel Request</a>
							  <a href="javascript:" data-toggle="modal" data-target="#deferrequest" class="master_aduser summaryEdit"><span><i class="far fa-check-circle"></i></span>Defer</a>
							  
							<?php }}?>
							
							
						<?php  if ($row["employee_id"] == $this->session->userdata('user')) { ?>
							<?php if ($row['status'] == 'pending'){?>
							 <li class="edit"><a  href="<?php echo base_url() . 'index.php/travel/edit_request_from/'.$currentTab.'/' . $requestId; ?>" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span> Edit</a></li>
							<?php } ?>	
							<?php  if ($row['status'] != 'cancelled') {?>
								<a href="javascript:" data-toggle="modal" data-target="#approveModel" class="master_aduser summaryEdit"><span><i class="far fa-check-circle"></i></span> Cancel Request</a>
							<?php } ?>					
						<?php } ?>	
						
						<?php  if ($row["cancel_request"] == 'pending') { ?>
							<?php if ($row["reporting_approval"] == 'pending' && php72_in_array($row['employee_id'], $subUsers)) { ?>
								<li class="edit"><a  href="<?php echo base_url() . 'index.php/approval/edit_approval_note/' . $requestId; ?>" class="master_aduser summaryEdit"><span><i class="fas fa-pencil-alt"></i></span>Confirm</a></li>
							<?php } ?>
						<?php } ?>
		
                        <li class="edit"><a  href="<?php echo base_url() . 'index.php/travel/requestlist/' . $row['status']; ?>" class="master_aduser summaryEdit"><span><i class="far fa-times-circle"></i></span> Back</a></li>
                    
                        </ul>
                    </div>
                </div>

                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <div class="inputplan-structureall plan-structure-new">
									<?php if ($row["cancel_request"] == 'pending') { ?>
									<div class="row approvalLabel">
										<div class="col-12 col-md-4 col-lg-4 col-xl-4">
											<div class="display-flex">
												<label>Cancel Request :</label>
												<p>
													<?php echo $row["cancel_request"]; ?>
												</p>
											</div>
										</div>
										<div class="col-12 col-md-4 col-lg-4 col-xl-4">
											<div class="display-flex">
												<label>Cancel Request Date :</label>
												<p><?php
												if(isset($row["cancel_request_date"]) && $row["cancel_request_date"]!=''){
													echo date('Y-m-d',strtotime($row["cancel_request_date"]));
													
												} ?></p>
											</div>
										</div>

									</div>
									<?php } ?>
										
                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                            <div class="display-flex">
                                                <label>Status :</label>
                                                <p>
                                                    <?php
													if (isset($row["status"]) && $row["status"] != '') {
                                                        echo ucfirst($row["status"]);
                                                    }
													if (isset($row["confirmed_date"]) && $row["confirmed_date"] != '') {
                                                        echo date('Y-m-d', strtotime($row["confirmed_date"]));
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
										
                                        <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                            <div class="display-flex">
                                                <label>Reporting Authority Approval :</label>
                                                <p><?php
													if (isset($row["reporting_approval"]) && $row["reporting_approval"] != '') {
                                                        echo ucfirst($row["reporting_approval"]).' ';
                                                    }
													if (isset($row["RO_date"]) && $row["RO_date"] != '') {
                                                        echo date('Y-m-d', strtotime($row["RO_date"]));
                                                    }
                                                    ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div style="height: 15px;"></div>
                                    <div class="newApprovalNoteViewTbl">
                                        <table class="table" style="margin-top: 0">
                                            <thead>
                                                <tr>
                                                    <th width="10%">Date of Travel</th>
                                                    <th width="10%">Destination From:</th>
                                                    <th width="10%">To:</th>
                                                    <th width="10%">Time</th>
                                                    <th width="10%">Train/Flight/Cab/Bus</th>
                                                    <th width="10%">Any preferred Train/Flight</th>
                                                    <th width="10%">Date of Accommodation</th>
                                                    <th width="10%">Location Preference</th>
													<th width="10%">Tickets Status</th>
													<th width="20%">Tickets Info</th>
                                                </tr>
                                            </thead>
                                            <tbody>
											
												<?php $ticket_count=1; foreach ($journeyList as $row_jur) {  ?>
													<tr class="metric_more">
														<td><?php  if(isset($row_jur["date_of_travel"]) && $row_jur["date_of_travel"]!=''){
															echo date('Y-m-d',strtotime($row_jur["date_of_travel"]));
															
														}  ?></td>
														<td><?= $row_jur["destination_from"] ?></td>
														<td><?= $row_jur["destination_to"] ?></td>
														<td><?= $row_jur["travel_time"] ?></td>
														<td><?php  
														
														if ($row_jur["travel_mode"] == '') { 
															echo '-';
														}else{ 
															$condition = array('master_id'=>$row_jur["travel_mode"]);
															$get_masterName = $this->Common_model->get_all_details('master_settings', $condition,array(),'','','',true, 'ais');
															
															echo $get_masterName[0]->master_name;
														}
														?></td>
														<td><?= $row_jur["preferred_train_flight"] ?></td>
														<td><?php  
														$date1 =  $date2 ='';
														
														if(isset($row["date_of_accomodation"]) && $row["date_of_accomodation"]!=''){
															
															if($row_jur["date_of_accomodation"] !='0000-00-00 00:00:00'){
																$date1 =  date('Y-m-d', strtotime($row_jur["date_of_accomodation"])); 
															}
															
														} 
														if(isset($row["date_of_accomodation_to"]) && $row["date_of_accomodation_to"]!=''){
															if($row_jur["date_of_accomodation_to"] !='0000-00-00'){
																$date2 =  date('Y-m-d', strtotime($row_jur["date_of_accomodation_to"])); 
															}
														} 
														echo $date1.' - '.$date2;
														?></td>
														<td><?= $row_jur["location_preference"] ?></td>
														<td><?= $row_jur["ticket"] ?></td>
														<td><?php  if ($row_jur['ticket'] == 'confirmed' && $row['status'] == 'confirmed') {  ?> 
															 <a href="javascript:void(0);" onClick="showDialogForm('<?php echo $ticket_count; ?>')" class="button" >View Tickets</a>
															 
															 
														<div class="modal" id="view_ticket_<?php echo $ticket_count; ?>" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
															<div class="modal-dialog modal-dialog-centered modal-md" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title">Ticket Information</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body text-center">
																		<form id="confirmed_form" action="<?php echo base_url() . 'index.php/travel/confirm/'.$requestId.'/' . $currentTab; ?>" cancel="" method="post">
																			<div class="container-fluid">
																				<table width="400" cellspacing="5" cellpadding="5">
																					<tr>
																						<td><strong>Bill No</strong></td>
																						<td><?= $row_jur["bill_no"] ?></td>
																					</tr>
																					<tr>
																						<td><strong>Bill Date</strong></td>
																						<td><?php 
																						if($row_jur["bill_date"]!=''){
																							echo date('Y-m-d',strtotime($row_jur["bill_date"]));
																						}
																						 ?></td>
																					</tr>
																					<tr>
																						<td><strong>Amount</strong></td>
																						<td><?= $row_jur["amount"] ?></td>
																					</tr>
																					<tr>
																						<td><strong>Vendor</strong></td>
																						<td><?= $row_jur["vendor_name"] ?></td>
																					</tr>
																					<tr>
																						<td><strong>e-Ticket</strong></td>
																						<td><a class="vital_yellow_btn wdt-100" href="<?= base_url() ?>uploads/tickets/<?php echo $row_jur['e_ticket'] ?>">
																								Download
																							</a>
																						</td>
																					</tr>
																				</table>	
																				<div style="height:15px"></div>
																				<div class="row ">
																					<div class="col-12 col-sm-12  col-md-12 text-left ">
																						<ul class="vitals-links">
																							<li><a href="javascript:" data-dismiss="modal" aria-label="Close" class="vital_bordered_btn wdt-100">Cancel</a></li>
																						</ul>
																					</div>
																				</div>
																			</div>
																		</form>
																	</div>                    
																</div>
															</div>
														</div>


														<?php  } elseif ($row_jur['ticket'] == 'cancelled') { 
														echo'<br>';
														?>
														
															<a href="javascript:void(0);" onClick="showDialogForm_ticket('<?php echo $ticket_count; ?>')" class="link_button" >Cancelld Tickets Info</a>
															
															
															
															<div class="modal" id="cancel_ticket_<?php echo $ticket_count; ?>" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
															<div class="modal-dialog modal-dialog-centered modal-md" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 class="modal-title">Ticket Information</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body text-center">
																		<form id="confirmed_form" action="<?php echo base_url() . 'index.php/travel/confirm/'.$requestId.'/' . $currentTab; ?>" cancel="" method="post">
																			<div class="container-fluid">
																				<table width="400" cellspacing="5" cellpadding="5">
																					<tr>
																						<td><strong>Bill No</strong></td>
																						<td><?= $row_jur["bill_no"] ?></td>
																					</tr>
																					<tr>
																						<td><strong>Bill Date</strong></td>
																						<td><?php if($row_jur["bill_date"]!=''){
																							echo date('Y-m-d',strtotime($row_jur["bill_date"]));
																						} ?></td>
																					</tr>
																					<tr>
																						<td><strong>Amount</strong></td>
																						<td><?= $row_jur["amount"] ?></td>
																					</tr>
																					<tr>
																						<td><strong>Vendor</strong></td>
																						<td><?= $row_jur["vendor_name"] ?></td>
																					</tr>
																					<tr>
																						<td><strong>Credit Note Number</strong></td>
																						<td><?= $row_jur["credit_note_no"] ?></td>
																					</tr>
																					<tr>
																						<td><strong>Credit Amount</strong></td>
																						<td><?= $row_jur["credit_amount"] ?></td>
																					</tr>
																					<tr>
																						<td><strong>e-Ticket</strong></td>
																						<td><a class="vital_yellow_btn wdt-100" href="<?= base_url() ?>uploads/tickets/<?php echo $row_jur['e_ticket'] ?>">
																								Download
																							</a>
																						</td>
																					</tr>
																				</table>	
																				<div style="height:15px"></div>
																				<div class="row ">
																					<div class="col-12 col-sm-12  col-md-12 text-left ">
																						<ul class="vitals-links">
																							<li><a href="javascript:" data-dismiss="modal" aria-label="Close" class="vital_bordered_btn wdt-100">Cancel</a></li>
																						</ul>
																					</div>
																				</div>
																			</div>
																		</form>
																	</div>                    
																</div>
															</div>
														</div>
														<?php  }  ?>
														</td>
													</tr>
												
												<?php $ticket_count++; } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="height: 15px;"></div>
                                    <div class="row approvalLabel">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Request Number :</label>
                                                <p>
                                                    <?php
                                                    if (isset($row["travel_request_id"]) && $row["travel_request_id"] != '') {
                                                        echo $row["travel_request_id"];
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Journey Type:</label>
                                                <p><?= ucfirst($row["journey_type"]) ?></p>
                                            </div>
                                        </div>
                                    </div>
									<div class="row approvalLabel">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Date of Requisition :</label>
                                                <p>
                                                    <?php
                                                    if (isset($row["date_of_requisition"]) && $row["date_of_requisition"] != '') {
                                                        echo date('Y-m-d',strtotime($row["date_of_requisition"]));
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Compliance with HR manual (YES/NO)</label>
                                                <p><?php
                                                    if (isset($row["compliance_with_hr_manual"]) && $row["compliance_with_hr_manual"] != '') {
                                                        echo $row["compliance_with_hr_manual"];
                                                    }
                                                    ?></p>
                                            </div>
                                        </div>
                                    </div>
									<div class="row approvalLabel">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Is booking 5 days prior to travel. If not, reasons for the same</label>
                                                <p>
                                                    <?php
                                                    if (isset($row["prior_booking"]) && $row["prior_booking"] != '') {
                                                        echo $row["prior_booking"];
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Purpose</label>
                                                <p><?php
                                                    if (isset($row["purpose"]) && $row["purpose"] != '') {
                                                        echo $row["purpose"];
                                                    }
                                                    ?></p>
                                            </div>
                                        </div>
                                    </div>
									<div class="row approvalLabel">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Donor</label>
												
                                                <p><?php 
													if(php72_cmp($row["donor"]) ==0){
														echo $row["other_donor"];
													}else{
														$condition = array('master_id'=>$row["donor"]);
														$get_masterNames = $this->Common_model->get_all_details('master_settings', $condition,array(),'','','',true, 'ais');
														echo $get_masterNames[0]->master_name;
													}
												?></p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Budget Head</label>
                                                <p><?php 
													if(php72_cmp($row["budget_head"]) ==0){
														echo $row["other_budget_head"];
													}else{
														$condition = array('master_id'=>$row["budget_head"]);
														$get_masterNames = $this->Common_model->get_all_details('master_settings', $condition,array(),'','','',true, 'ais');
														echo $get_masterNames[0]->master_name;
													}
												?></p>
                                            </div>
                                        </div>
                                    </div>
									
									<div class="row approvalLabel">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Line Item</label>
												
                                                <p><?php 
													if(php72_cmp($row["line_item"]) ==0){
														echo $row["other_line_item"];
													}else{
														$condition = array('master_id'=>$row["line_item"]);
														$get_masterNames = $this->Common_model->get_all_details('master_settings', $condition,array(),'','','',true, 'ais');
														echo $get_masterNames[0]->master_name;
													}
												?></p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Sub-line Item</label>
                                                <p><?php 
													if(php72_cmp($row["cost_centre"]) ==0){
														echo $row["other_cost_centre"];
													}else{
														$condition = array('master_id'=>$row["cost_centre"]);
														$get_masterNames = $this->Common_model->get_all_details('master_settings', $condition,array(),'','','',true, 'ais');
														echo $get_masterNames[0]->master_name;
													}
												?></p>
                                            </div>
                                        </div>
                                    </div>
									
									<div class="row approvalLabel">
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Programme</label>
												
                                                <p> <?php
                                                    if (isset($row["programme"]) && $row["programme"] != '') {
                                                        echo $row["programme"];
                                                    }
                                                    ?></p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Reporting Officers  Approval</label>
                                                <p><?php
                                                    if (isset($row["reporting_approval"]) && $row["reporting_approval"] != '') {
                                                        echo $row["reporting_approval"];
                                                    }
                                                    ?></p>
                                            </div>
                                        </div>
                                    </div>
									<div class="row approvalLabel">
									 <?php if ($row["cancel_reason"] != '') { ?>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Cancel Request Reason by Employee</label>
												
                                                <p> <?php
                                                    if (isset($row["cancel_reason"]) && $row["cancel_reason"] != '') {
                                                        echo $row["cancel_reason"];
                                                    }
                                                    ?></p>
                                            </div>
                                        </div>
									 <?php } ?>
									 
									 <?php if ($row["cancel_reason_RO"] != '') { ?>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Cancel Reason by Reporting Officers</label>
												
                                                <p> <?php
                                                    if (isset($row["cancel_reason_RO"]) && $row["cancel_reason_RO"] != '') {
                                                        echo $row["cancel_reason_RO"];
                                                    }
                                                    ?></p>
                                            </div>
                                        </div>
									 <?php } ?>
                                       
                                    </div>
									
									
									
									<div class="row approvalLabel">
									 <?php if ($row["cancel_reason_admin"] != '') { ?>
                                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                            <div class="display-flex">
                                                <label>Cancel Reason by Admin</label>
												
                                                <p> <?php
                                                    if (isset($row["cancel_reason_admin"]) && $row["cancel_reason_admin"] != '') {
                                                        echo $row["cancel_reason_admin"];
                                                    }
                                                    ?></p>
                                            </div>
                                        </div>
									 <?php } ?>
                                       
                                    </div>
									
									<div style="height: 15px;"></div>
                                    <div class="newApprovalNoteViewTbl">
                                        <table class="table" style="margin-top: 0">
                                            <thead>
                                                <tr>
                                                    <th width="15%">Name</th>
                                                    <th width="15%">Age</th>
                                                    <th width="15%">Sex</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php foreach ($personsList as $row1) { ?>
													<tr class="metric_more">
														<td><?php  echo $this->Mtravel->getEmployeeName($row1['name']); ?></td>
														<td><?= $row1['age'] ?></td>
														<td><?php if($row1['sex']!=''){ if($row1['sex'] =='1'){ echo 'Male'; }else{ echo 'Female';} }  ?></td>
													</tr>
												<?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
									
                                </div>
                            </main>
                        </div>
                    </div>
                </div>
            </main>
		<?php } ?>
        </div>
    </div>
</div>


<div class="modal" id="cancelrequest" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Travel Booking - Cancel Confirmation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<form id="auth_cancel_form" action="<?php echo base_url() . 'index.php/travel/auth_cancel/'.$requestId.'/' . $currentTab; ?>" cancel="" method="post">
					<div class="container-fluid">
						<div class="row leaveLabel">
							<div class="col-12 col-md-12 col-lg-10 col-xl-10">
								<div class="form-group text-left">
									<label>Enter Comments</label>
									<textarea name="reasons" class="form-control" type="text"></textarea>
								</div>
							</div>
						</div>
						<div style="height:15px"></div>
						<div class="row ">
							<div class="col-12 col-sm-12  col-md-12 text-left ">
								<ul class="vitals-links">
									<li><a href="javascript:" data-toggle="modal" data-target="#approveSuccessModel" id="closeModal_cancel" class="vital_yellow_btn wdt-100">Send</a></li>
									<li><a href="javascript:" data-dismiss="modal" aria-label="Close" class="vital_bordered_btn wdt-100">Cancel</a></li>
								</ul>
							</div>
						</div>
					</div>
				</form>
			</div>                    
		</div>
	</div>
</div>


<div class="modal" id="deferrequest" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Approval Note - defered form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<form id="roaction_form" action="<?php echo base_url() . 'index.php/travel/roaction/'.$requestId.'/defered'; ?>" cancel="" method="post">
					<div class="container-fluid">
						<div class="row leaveLabel">
							<div class="col-12 col-md-12 col-lg-10 col-xl-10">
								<div class="form-group text-left">
									<label>Enter Comments</label>
									<textarea name="comments_RO" class="form-control" type="text"></textarea>
									<input type="hidden" name="from_employee" value="<?= $this->session->userdata('user'); ?>"/>
								</div>
							</div>
						</div>
						<div style="height:15px"></div>
						<div class="row ">
							<div class="col-12 col-sm-12  col-md-12 text-left ">
								<ul class="vitals-links">
									<li><a href="javascript:" data-toggle="modal" data-target="#approveSuccessModel" id="closeModal_deferrequest" class="vital_yellow_btn wdt-100">Send</a></li>
									<li><a href="javascript:" data-dismiss="modal" aria-label="Close" class="vital_bordered_btn wdt-100">Cancel</a></li>
								</ul>
							</div>
						</div>
					</div>
				</form>
			</div>                    
		</div>
	</div>
</div>


<div class="modal" id="approveModel" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Travel Booking - Cancel Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<form id="cancel_form" action="<?php echo base_url() . 'index.php/travel/cancel/'.$requestId.'/' . $currentTab; ?>" cancel="" method="post">
					<div class="container-fluid">
						<div class="row leaveLabel">
							<div class="col-12 col-md-12 col-lg-10 col-xl-10">
								<div class="form-group text-left">
									<label>Enter Comments</label>
									<textarea name="reasons" class="form-control" type="text"></textarea>
								</div>
							</div>
						</div>
						<div style="height:15px"></div>
						<div class="row ">
							<div class="col-12 col-sm-12  col-md-12 text-left ">
								<ul class="vitals-links">
									<li><a href="javascript:" data-toggle="modal" data-target="#approveSuccessModel" id="closeModal" class="vital_yellow_btn wdt-100">Send</a></li>
									<li><a href="javascript:" data-dismiss="modal" aria-label="Close" class="vital_bordered_btn wdt-100">Cancel</a></li>
								</ul>
							</div>
						</div>
					</div>
				</form>
			</div>                    
		</div>
	</div>
</div>

<div class="modal" id="confirmed" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirmation Box</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<form id="confirmed_form" action="<?php echo base_url() . 'index.php/travel/confirm/'.$requestId.'/' . $currentTab; ?>" cancel="" method="post">
					<div class="container-fluid">
						<div class="row leaveLabel">
							<div class="col-12 col-md-12 col-lg-10 col-xl-10">
								<div class="form-group text-left">
									<label>Are you sure want to confirm?</label>
								</div>
							</div>
						</div>
						<div style="height:15px"></div>
						<div class="row ">
							<div class="col-12 col-sm-12  col-md-12 text-left ">
								<ul class="vitals-links">
									<li><a href="javascript:" data-toggle="modal" data-target="#approveSuccessModel" id="closeModal_confirmed" class="vital_yellow_btn wdt-100">Send</a></li>
									<li><a href="javascript:" data-dismiss="modal" aria-label="Close" class="vital_bordered_btn wdt-100">Cancel</a></li>
								</ul>
							</div>
						</div>
					</div>
				</form>
			</div>                    
		</div>
	</div>
</div>


	
<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '#closeModal', function () {
            $('#cancel_form').submit();
        });
		$(document).on('click', '#closeModal_confirmed', function () {
            $('#confirmed_form').submit();
        });
		$(document).on('click', '#closeModal_cancel', function () {
            $('#auth_cancel_form').submit();
        });
		$(document).on('click', '#closeModal_deferrequest', function () {
            $('#roaction_form').submit();
        });

        $('#author').keypress(function (e) {
            if (e.which == 13) {
                filter_check();
                return false;
            }
        });
		
    });
	function showDialogForm(ticket_count){
		$('#view_ticket_'+ticket_count).modal('show');
	}
	function showDialogForm_ticket(ticket_count){
		$('#cancel_ticket_'+ticket_count).modal('show');
	}

    $(document).on('click', '#search_btn', function () {
        filter_check();
    });

    $(document).on('click', '#reset_search', function () {
        $('#purpose').val('');
        $('#approval_no').val('');
    });

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

</script>

</body>
</html>