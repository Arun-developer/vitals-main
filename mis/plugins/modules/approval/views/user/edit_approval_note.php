<?php $this->load->view('vitals_header.php', array('main_menu' => 'request', 'page_title' => 'Edit My Approval Note', 'page_table' => 'datatable')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent ">
	<div class="row">
		<div class="col-lg-3 col-xl-3 col-md-3 col-12 position-relative">
			<?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve', 'page' => 'new_approval_note')); ?>
		</div>
		<div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
			<main class="page-content">
				<div class="row dataconfig d_v_d_c">
					<div class="col-xl-6 col-lg-6 col-md-12 col-12 pad-none display-flex">
						<span><a href="<?php echo base_url() . 'index.php/approval/approval_note_details/' . $approvalNoteDetails[0]['approval_id']; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
						<h4>Edit Approval Note <?php
						if (isset($approvalNoteDetails[0]['approval_no']) && $approvalNoteDetails[0]['approval_no'] != '') {
							echo '- ' . $approvalNoteDetails[0]['approval_no'];
						}
						?></h4>
					</div>
				</div>
				<div class="plan-structure-vital vital_windowScroll">
					<div class="tab-slider--container">
						<div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
							<main class="page-content">
								<form name="addApproval" id="addApproval" enctype="multipart/form-data" action="<?php echo base_url() . 'index.php/approval/insert_approval_note'; ?>" method="post" autocomplete="off">
									<div class="inputplan-structureall plan-structure-new">
										<div class="row leaveLabel">
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
												<div class="form-group">
													<label>Approval Number</label>
													<input class="form-control" name="approval_no" type="text" name="approval_no" readonly="" value="<?php
													if (isset($approvalNoteDetails[0]['approval_no']) && $approvalNoteDetails[0]['approval_no'] != '') {
														echo $approvalNoteDetails[0]['approval_no'];
													}
													?>">
												</div>
											</div>
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
												<div class="form-group">
													<label>Date of Seeking Approval<span>*</span></label>
													<input class="form-control" name="date_of_seeking_approval" type="text" name="approval_no" readonly="" value="<?php
													if (isset($approvalNoteDetails[0]['date_of_seeking_approval']) && $approvalNoteDetails[0]['date_of_seeking_approval'] != '') {
														echo date("d-m-Y", strtotime($approvalNoteDetails[0]['date_of_seeking_approval']));
													}
													?>">
												</div>
											</div>
											<?php
											if ($approvalNoteDetails[0]['to_RO'] == $reporting_list[0]['emp_id'] && count($reporting_list) == 1) {
												$ro_field = 'readonly';
												$ro_class = 'none-pointer';
											} else {
												$ro_field = $ro_class = '';
											}
											?>
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
												<div class="form-group">
													<label>Reporting Manager<span>*</span></label>
													<select class="form-control <?= $ro_class; ?>" name="to_RO" <?= $ro_field; ?>>
														<option value=''>--Select--</option>
														<?php foreach ($reporting_list as $ro) { ?>
															<option value='<?= $ro['emp_id']; ?>' <?php
															if ($ro['emp_id'] == $approvalNoteDetails[0]['to_RO']) {
																echo 'selected';
															}
															?>><?= $ro['emp_name']; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div>
										<div class="row leaveLabel">
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
												<div class="form-group">
													<label>Purpose</label>
													<textarea class="form-control" name="purpose" rows="3" placeholder="Enter Purpose"><?php
													if (isset($approvalNoteDetails[0]['purpose']) && $approvalNoteDetails[0]['purpose'] != '') {
														echo trim($approvalNoteDetails[0]['purpose']);
													}
													?></textarea>
												</div>
											</div>
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
												<div class="form-group">
													<label>Programme<span>*</span></label>
													<select class="form-control" name="programme" id='programme_id' onchange="getDonorList('1', this.value); removeAddMore();">
														<option value=''>--Select--</option>
														<?php foreach ($programmeList as $lists) { ?>
															<option <?php
															if ($approvalNoteDetails[0]['programme'] == $lists['programme_id']) {
																echo "selected";
															}
															?> value="<?php echo $lists['programme_id']; ?>" ><?php echo $lists['programme']; ?></option>
														<?php } ?>
													</select>
													<input name="program_id"  type="hidden" value="<?php echo $approvalNoteDetails[0]['programme']; ?>" >
												</div>
											</div>
											<div class="col-12 col-md-4 col-lg-4 col-xl-4">
												<div class="form-group">
													<label>Programme Head</label>
													<input class="form-control" type="text" readonly="" id="pro_head" value="" placeholder="--Select--">
												</div>
											</div>
										</div>
										<input type="hidden" name="approval_id" value="<?php echo $approvalNoteDetails[0]['approval_id']; ?>" >
										<div style="height:20px"></div>
										<div class="table_configcontentnew pad-bt0">
											<div class="tabpanel-title">
												<div class="row">
													<div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
														<h4>Request Details</h4>
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
											<table class="table" id="detail_table" style="margin-top: 0">
												<thead>
													<tr>
														<!--<th width="5%" class="removeArrow"><input class="form-control" type="checkbox"></th>-->
														<th width="2%"></th>
														<th width="13%">Donor<span class="clr-red">*</span></th>
														<th width="15%">Grant<span class="clr-red">*</span></th>
														<th width="15%">Budget Head<span class="clr-red">*</span></th>
														<th width="15%">Line Item<span class="clr-red">*</span></th>
														<th width="10%">Details</th>
														<th width="15%">Amt. Available (<?= $this->session->userdata['currency']; ?>)</th>
														<th width="15%">Amt. Required (<?= $this->session->userdata['currency']; ?>)<span class="clr-red">*</span></th>
													</tr>
												</thead>
												<tbody>
													<?php
													if (count($donorAN) > 0) {
														$j = 1;
														foreach ($donorAN as $dataList) {
															?>
															<tr id="add_tr_<?= $j; ?>" class="add_more">
																<td></td>
																<td>
																	<select class="form-control donorlists" name="donor_list[]" id="donor_<?= $j; ?>" data-grant="<?= $dataList['grant_id']; ?>" onchange="getGrantList('<?= $j; ?>', this.value);">
																		<option value="">--Select--</option>
																		<?php
																		foreach ($donorList as $rows) {
																			if (in_array($rows['master_id'], $donors)) {
																				?>
																				<option value="<?php echo $rows['master_id']; ?>" <?php
																				if ($rows['master_id'] == $dataList['donor']) {
																					echo"selected";
																				}
																				?> ><?php echo $rows['master_name']; ?></option>
																				<?php
																			}
																		}
																		?>
																	</select>
																</td>
																<td>
																	<select class="form-control" name="grant_list[]" id="grant_<?= $j; ?>" data-budget="<?= $dataList['budget_head']; ?>" onchange="getBudgetList('<?= $j; ?>', this.value);">
																		<option value="">--Select--</option>
																	</select>
																</td>
																<td>
																	<select class="form-control" name="budget_list[]" id="budget_<?= $j; ?>" data-line="<?= $dataList['line_item']; ?>" onchange="getLineList('<?= $j; ?>', this.value);">
																		<option value="">--Select--</option>
																	</select>
																</td>
																<td>
																	<select class="form-control" name="line_list[]" id="lineitem_<?= $j; ?>" data-additional="<?= $dataList['additionalinfo']; ?>" onchange="getAdditionalList('<?= $j; ?>', this.value); getAvailAmount('<?= $j; ?>', this.value);">
																		<option value="">--Select--</option>
																	</select>
																</td>
																<td>
																	<select class="form-control" name="additional_list[]" id="additional_1">
																		<option value="">--Select--</option>
																	</select>
																</td>
																<td><input class="form-control" readonly="" name="amt_available[]" id="amt_available_<?= $j; ?>" placeholder="Available Amount" value="<?= $dataList['amt_available'] ?>"></td>
																<td><input class="form-control currencyField" name="amt_required[]" id="amt_required_<?= $j; ?>" value="<?= $dataList['amt_required'] ?>" onkeyup="checkReqAmount('<?= $j; ?>');" placeholder="Enter Amount"></td>
															</tr>
															<?php
															$j++;
														}
													} else {
														?>
														<tr id="add_tr_1" class="add_more">
															<td></td>
															<td>
																<select class="form-control donorlists" name="donor_list[]" id="donor_1" data-grant="<?= $dataList['grant_id']; ?>" onchange="getGrantList('1', this.value);">
																	<option value="">--Select--</option>
																	<?php
																	foreach ($donorList as $rows) {
																		if (in_array($rows['master_id'], $donors)) {
																			?>
																			<option value="<?php echo $rows['master_id']; ?>" <?php
																			if ($rows['master_id'] == $dataList['donor']) {
																				echo"selected";
																			}
																			?> ><?php echo $rows['master_name']; ?></option>
																			<?php
																		}
																	}
																	?>
																</select>
															</td>
															<td>
																<select class="form-control" name="grant_list[]" id="grant_1" data-budget="<?= $dataList['budget_head']; ?>" onchange="getBudgetList('1', this.value);">
																	<option value="">--Select--</option>
																</select>
															</td>
															<td>
																<select class="form-control" name="budget_list[]" id="budget_1" data-line="<?= $dataList['line_item']; ?>" onchange="getLineList('1', this.value);">
																	<option value="">--Select--</option>
																</select>
															</td>
															<td>
																<select class="form-control" name="line_list[]" id="lineitem_1" data-additional="<?= $dataList['additionalinfo']; ?>" onchange="getAdditionalList('1', this.value); getAvailAmount('1', this.value);">
																	<option value="">--Select--</option>
																</select>
															</td>
															<td>
																<select class="form-control" name="additional_list[]" id="additional_1">
																	<option value="">--Select--</option>
																</select>
															</td>
															<td><input class="form-control" readonly="" name="amt_available[]" id="amt_available_1" placeholder="Available Amount" value="<?= $dataList['amt_available'] ?>"></td>
															<td><input class="form-control currencyField" name="amt_required[]" id="amt_required_1" onkeyup="checkReqAmount('1');" value="<?= $dataList['amt_required'] ?>" placeholder="Enter Amount"></td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
										<div style="height:20px"></div>
										<div class="table_configcontentnew pad-bt0">
											<div class="tabpanel-title">
												<div class="row">
													<div class="col-xl-6 col-lg-6 col-md-9 col-sm-9 col-9">
														<h4>Supporting Documents</h4>
													</div>
													<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
														<ul class="milestone-links">
															<li class="brd-left-onboard">
																<a href="javascript:void(0)" class="edit-btnconfig mar-tp15" id="docMore"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
											<table class="table" style="margin-top: 0">
												<thead>
													<tr>
														<th width="30%">Document Description</th>
														<th width="30%">Upload Document</th>
														<th></th>
													</tr>
												</thead>
												<tbody class="support_doc_body">

													<?php
													$i = 1;
													$s = 0;
													$supprt_doc = $approvalNoteDetails[0]['supporting_documents'];
													$expld_doc = explode(',', $supprt_doc);
													if (count(unserialize($approvalNoteDetails[0]['attachment']))) {
														foreach (unserialize($approvalNoteDetails[0]['attachment']) as $key => $value) {
                                                            //if (file_exists('uploads/support_docs/' . $value)){<tr id="document_tr_1" class="document_more remove_more"><td width="20%">
															?>

															<tr id="document_tr_<?php echo $i; ?>" class="document_more">
																<input type="hidden" name="exist_doc[]" class="exist_doc_<?php echo $i; ?>" id="exist_doc_<?php echo $i; ?>" value="<?= $value; ?>" />
																<td><input type="text" class="form-control meet_desc" name="supporting_documents[]" id="meet_desc_<?php echo $i; ?>" maxlength="100" placeholder="Enter Description" value="<?php echo $expld_doc[$s]; ?>">
																	<label class="error" id="meet_desc_<?php echo $i; ?>_error"></label>
																</td>
																<td>
																	<div class="fileUpload blue-btn btn width100">
																		<span><i ></i> <?php echo substr($value, -30); ?></span>
																		<input type="file" value="<?php echo $value; ?>" class="uploadlogo" name="meet_doc[]"  id="meet_doc_<?php echo $i; ?>" />
																	</div>
																	<span class="download-btn"><a href="<?php
																	if (isset($value) && $value != '') {
																		echo base_url() . '/uploads/support_docs/' . $value;
																	}
																	?>" title="View Document - <?= $value; ?>" target="_blank"><i class="fas fa-file-download"></i></a></span>

																	<span>&nbsp;<i title="Remove" class="fas fa-minus-circle cursor" onclick="removeDocRow(<?php echo $i; ?>);" aria-hidden="true"></i></span>

																	<label class="sow_msg error" id="meet_doc_<?php echo $i; ?>_error"></label>
																</td>
																<td></td>
															</tr>
															<?php
															$i++;
															$s++;
                                                        //}</td></tr>
														}
													} else {
														?>
														<tr id="document_tr_1" class="document_more">
															<td><input type="text" class="form-control meet_desc" name="supporting_documents[]" id="meet_desc_1" maxlength="100" placeholder="Enter Description" value="" /><label class="error" id="meet_desc_1_error"></label></td>
															<td>
																<div class="fileUpload blue-btn btn width100">
																	<span><i class="fas fa-upload"></i> Upload</span>
																	<input type="file" value="" class="uploadlogo" name="meet_doc[]"  id="meet_doc_1" />
																</div>

																<label class="sow_msg error" id="meet_doc_1_error"></label>
															</td>

														</tr>
													<?php } ?>

												</tbody>
											</table>
										</div>
										<div style="height:20px"></div>
										<div class="row ">
											<div class="col-12 col-sm-12  col-md-12 ">
												<ul class="vitals-links">
													<?php
													$button_name = 'Update';
													if ($approvalNoteDetails[0]['status'] == 'draft') {
														$button_name = 'Send Approval Note';
													}
													?>
													<li><input type="submit" name="submitForm" value="<?php echo $button_name; ?>" class="vital_yellow_btn wdt_100"></li>
												</ul>
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

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">
	$(document).ready(function () {
		$("input[name='amt_available[]']").each(function (i, elem) {
			$(this).val(inrFormat($(this).val()));
		});

		$("input[name='amt_required[]']").each(function (i, elem) {
			$(this).val(inrFormat($(this).val()));
		});

		$('#addApproval').validate({
			rules: {
				"programme": "required",
				"donor_list[]": "required",
				"grant_list[]": "required",
				"budget_list[]": "required",
				"line_list[]": "required",
				"amt_required[]": "required",
				"to_RO": "required",
				"date_of_seeking_approval": "required",
			},
			messages: {
				"programme": "Select Programme",
				"donor_list[]": "Select donor",
				"grant_list[]": "Select grant",
				"budget_list[]": "Select budget",
				"line_list[]": "Select line item",
				"amt_required[]": "Enter amount",
				"date_of_seeking_approval": "Select Date",
				"to_RO": "Select RO",
			}
		});

		$('.donorlists').each(function () {
			var id = $(this).attr('id');
			var donor_value = $(this).val();
			var selected_grant = $(this).attr('data-grant');
			var splt_id = id.split('_');
			getGrantList(splt_id[1], donor_value, selected_grant);

            // if it is an input/select/textarea field
            // TODO: do something with the value
        });
		PH_name();
	});

	$(document).on("focus", ".seeking_date", function () {
		if ($(this).hasClass('hasDatepicker') === false) {
			$(this).datepicker({dateFormat: 'dd-mm-yy'});
		}
	});

	function removeAddMore() {
		$(".remove_more").remove();
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
					$('#donor_' + id).html(output.join(''));
				}
			});
		}
	}

	function PH_name() {
		var prgm_val = $('#programme_id').val();
		$.ajax({
			url: "<?php echo base_url(); ?>index.php/approval/getDonorNameList",
			type: 'POST',
			"data": {'program': prgm_val},
			success: function (msg) {
				var output = [];
				output.push('<option value="">--Select--</option>');
				var split_arr = JSON.parse(msg);
				var i = 0;

				$('#pro_head').val(split_arr[i].emp_name);
			}
		});
	}

	function getGrantList(id, val, select) {
		if (id != '') {
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/approval/getGrantNameList",
				type: 'POST',
				"data": {'donor': val,'program': $("#programme_id").val()},
				success: function (msg) {
					var output = [];
					output.push('<option value="">--Select--</option>');
					var split_arr = JSON.parse(msg);
					var i = 0;
					var selected = "";
					var selected_value = "";
					$.each(split_arr, function (key, value) {
						if (select == split_arr[i].id) {
							selected = "selected";
							selected_value = split_arr[i].id;
						}
						output.push('<option value="' + split_arr[i].id + '"' + selected + '>' + split_arr[i].name + '</option>');
						i++;
					});
					$('#grant_' + id).html(output.join(''));
					$('#grant_' + id).val(selected_value);

					if (select != '') {
						var selected_budget = $('#grant_' + id).attr('data-budget');
						getBudgetList(id, select, selected_budget);
					}
				}
			});
		}
	}

	function getBudgetList(id, val, select) {
		if (id != '') {
			var program = $('#programme_id').val();
			var donor = $('#donor_' + id).val();
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/approval/getBudgetItemList",
				type: 'POST',
				"data": {'program': program, 'donor': donor, 'grant': val},
				success: function (msg) {
					var output = [];
					output.push('<option value="">--Select--</option>');
					var split_arr = JSON.parse(msg);
					var i = 0;
					var selected = "";
					var selected_value = "";
					$.each(split_arr, function (key, value) {
						if (select == split_arr[i].budget_id) {
							selected = "selected";
							selected_value = split_arr[i].budget_id;
						}
						output.push('<option value="' + split_arr[i].budget_id + '"' + selected + '>' + split_arr[i].master_name + '</option>');
						i++;
					});
					$('#budget_' + id).html(output.join(''));
					$('#budget_' + id).val(selected_value);
					if (select != '') {
						var selected_line = $('#budget_' + id).attr('data-line');
						getLineList(id, select, selected_line);
					}
				}
			});
		}
	}

	function getLineList(id, val, select) {

		if (id != '') {
			var program = $('#programme_id').val();
			var donor = $('#donor_' + id).val();
			var grant = $('#grant_' + id).val();
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/approval/getLineList",
				type: 'POST',
				"data": {'program': program, 'donor': donor, 'grant': grant, 'budget': val},
				success: function (msg) {
					var output = [];
					output.push('<option value="">--Select--</option>');
					var split_arr = JSON.parse(msg);
					var i = 0;
					var selected = "";
					var selected_value = "";
					$.each(split_arr, function (key, value) {
						if (select == split_arr[i].line_itemid) {
							selected = "selected";
							selected_value = split_arr[i].line_itemid;
						}
						output.push('<option value="' + split_arr[i].line_itemid + '"' + selected + '>' + split_arr[i].master_name + '</option>');
						i++;
					});
					$('#lineitem_' + id).html(output.join(''));
					$('#lineitem_' + id).val(selected_value);
					if (select != '') {
						var selected_additional = $('#lineitem_' + id).attr('data-additional');
						getAdditionalList(id, select, selected_additional);
						getAvailAmount('edit');
					}
				}
			});
		}
	}

	function getAdditionalList(id, val, select) {
		if (id != '') {
			var program = $('#programme_id').val();
			var donor = $('#donor_' + id).val();
			var budget = $('#budget_' + id).val();
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/approval/getAdditionalList",
				type: 'POST',
				"data": {'program': program, 'donor': donor, 'budget': budget, 'lineitem': val},
				success: function (msg) {
					var output = [];
					output.push('<option value="">--Select--</option>');
					var split_arr = JSON.parse(msg);
					var i = 0;
					var selected = "";
					$.each(split_arr, function (key, value) {
						if (select == split_arr[i].id) {
							var selected = "selected";
						}
						output.push('<option value="' + split_arr[i].id + '"' + selected + '>' + split_arr[i].additionalinfo + '</option>');
						i++;
					});
					$('#additional_' + id).html(output.join(''));
				}
			});
		}
	}

	function getAvailAmount(edit = '') {
		var donor = [];
		var grant_list = [];
		var budgethead = [];
		var lineitem = [];
		var amtavailable = [];
		var amtreq = [];
		var progid = $("#programme_id").val();

		$("select[name='donor_list[]']").each(function () {
			donor.push($(this).val());
		});
		$("select[name='grant_list[]']").each(function () {
			grant_list.push($(this).val());
		});
		$("select[name='budget_list[]']").each(function () {
			budgethead.push($(this).val());
		});
		$("select[name='line_list[]']").each(function () {
			lineitem.push($(this).val());
		});
		$("input[name='amt_available[]']").each(function () {
			amtavailable.push($(this).val());
		});
		$("input[name='amt_required[]']").each(function () {
			amtreq.push($(this).val());
		});
		if (edit == '') {
			editval = '';
		} else {
			editval = edit;
		}
		$.ajax({
			url: '<?php echo base_url(); ?>index.php/approval/check_calucalations',
			data: {donor: donor, budgethead: budgethead, lineitem: lineitem, amtavailable: amtavailable, amtreq: amtreq, progid: progid, grant_list: grant_list, edit: editval},
			dataType: "json",
			type: 'POST',
			success: function (msg) {
				$("input[name='amt_available[]']").each(function (i, elem) {
					$(this).val(msg[i]["amtavailable"]);
					$("input[name='amt_required[]']").eq(i).val(msg[i]["amtreq"]);
				});
			}
		});
	}

	function checkReqAmount(id) {
		var avail_amt = $('#amt_available_' + id).val();
		var req_amt = $('#amt_required_' + id).val();
		var tot_amt = avail_amt.replace(/,/g, '');
		var tot_required = req_amt.replace(/,/g, '');
		if (parseInt(tot_required) > parseInt(tot_amt)) {
			alert("You don't have enough amount in the selected donor");
			$('#amt_required_' + id).val('');
			$('#amt_required_' + id).focus();
		}
	}

	$(document).on('click', '#addMore', function () {
		var programme = $('#programme_id').val();
		if (programme == '') {
			alert('Please select a programme');
		} else {
			var empty_err = 0;
			$("input[name='amt_required[]']").each(function (i) {
				if ($(this).val() == '' || $(this).val() == 0)
					empty_err += 1;
			});
			if (empty_err > 0) {
				alert('Enter required amount value');
				return false;
			}

			var dyn = $(".add_more").length;
			var i = parseInt(dyn) + 1;
			var program_id = $('#programme_id').val();
			getDonorList(i, program_id);
			var datas = '<tr id="add_tr_' + i + '" class="add_more remove_more"><td><i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeRow(' + i + ');" aria-hidden = "true" ></i></td>';
			datas += '<td><select class="form-control" name="donor_list[]" id="donor_' + i + '" onchange="getGrantList(' + i + ', this.value);"><option value="">--Select--</option></td>';
			datas += '<td><select class="form-control" name="grant_list[]" id="grant_' + i + '" onchange="getBudgetList(' + i + ', this.value);"><option value="">--Select--</option></select></td>';
			datas += '<td><select class="form-control" name="budget_list[]" id="budget_' + i + '" onchange="getLineList(' + i + ', this.value);"><option value="">--Select--</option></select></td>';
			datas += '<td><select class="form-control" name="line_list[]" id="lineitem_' + i + '" onchange="getAdditionalList(' + i + ', this.value);getAvailAmount(' + i + ', this.value);"><option value="">--Select--</option></select></td>';
			datas += '<td><select class="form-control" name="additional_list[]" id="additional_' + i + '"><option value="">--Select--</option></select></td>';
			datas += '<td><input class="form-control" readonly="" name="amt_available[]" id="amt_available_' + i + '" placeholder="Available Amount"></td>';
			datas += '<td><input class="form-control currencyField" name="amt_required[]" id="amt_required_' + i + '" onkeyup="checkReqAmount(' + i + ')" placeholder="Enter Amount"></td></tr>';
			$(datas).insertAfter($('#add_tr_' + dyn));
		}
	});

	function removeRow(div_id) {
		$('#add_tr_' + div_id).closest('tr').remove();
	}

	function removeDocRow(div_id) {
		$('#document_tr_' + div_id).closest('tr').remove();
	}

	$(document).on('click', '#docMore', function () {
		var dyn = $(".document_more").length;
		var i = parseInt(dyn) + 1;
        //var data = '<tr id="document_tr_' + i + '" class="document_more">';
        var data = '<tr id="document_tr_' + i + '" class="document_more remove_more">';
        data += '<td width="30%"><input type="text" class="form-control meet_desc" name="supporting_documents[]" id="meet_desc_' + i + '" maxlength="100" placeholder="Enter Description" value=""><label class="error" id="meet_desc_' + i + '_error"></label></td><td width="30%"><div class="fileUpload blue-btn btn width100"><span><i class="fas fa-upload"></i> Upload</span><input type="file" class="uploadlogo" name="meet_doc[]" id="meet_doc_' + i + '" /></div>';
        data += '<span>&nbsp;<i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeDocRow(' + i + ');" aria-hidden = "true" ></i></span><label class="sow_msg error" id="meet_doc_' + i + '_error"></label></td><td></td></tr>';
        if (dyn == 0) {
        	$('.support_doc_body').html(data);
        } else {
        	$(data).insertAfter($('#document_tr_' + dyn));
        }
    });

	$(document).on("click", ".vital_yellow_btn", function () {
		if ($('#addApproval').valid() == true) {
			var result = formValidate();
			if (result == 1) {
				return false;
			} else {
				$('.vital_yellow_btn').css('pointer-events', 'none');
				return true;
			}
            //                                                                                        $('#addApproval').submit();
        } else {
        	return false;
        }
    });

    //                                                                                $(document).on('submit', '#addApproval', function (e) {
    //                                                                                    $('#addApproval').valid();
    //                                                                                    var result = formValidate();
    //                                                                                    if (result == 1) {
    //                                                                                        return false;
    //                                                                                    } else {
    //                                                                                        return true;
    //                                                                                    }
    //                                                                                });

    function formValidate() {
    	var err = 0;
    	var cmnt_arr = [];
    	var hid_docarr = [];
    	var cmnt_descarr = [];
    	var cmnt_dyn = document.getElementsByName("meet_doc[]").length;
    	var cmnt_desc = document.getElementsByName("supporting_documents[]").length;
    	for (var r = 0; r < cmnt_dyn; r++) {
    		var dyn_id = document.getElementsByName("meet_doc[]")[r].id;
    		var hdoc_id = document.getElementsByName("exist_doc[]")[r].id;
    		cmnt_arr.push(dyn_id);
    		hid_docarr.push(hdoc_id);
    	}
    	for (var t = 0; t < cmnt_desc; t++) {
    		var desc_id = document.getElementsByName("supporting_documents[]")[t].id;
    		cmnt_descarr.push(desc_id);
    	}

    	var s = 1;
    	for (var q = 0; q < cmnt_arr.length; q++) {
    		var cmnt_desc = $('#meet_desc_' + s).val();
    		var doc = $('#' + cmnt_arr[q]).val();
    		var hid_doc = $('#' + hid_docarr[q]).val();
    		if (hid_doc == '') {
    			if (cmnt_desc != '' && doc == '') {
    				$('#' + cmnt_arr[q] + '_error').css('display', 'block');
    				$('#' + cmnt_arr[q] + '_error').text('Upload document');
    				err = 1;
    			} else if (cmnt_desc == '' && doc != '') {
    				$('#' + cmnt_descarr[q] + '_error').css('display', 'block');
    				$('#' + cmnt_descarr[q] + '_error').text('Enter description');
    				err = 1;
    			} else {
    				$('#' + cmnt_arr[q] + '_error').css('display', 'none');
    				$('#' + cmnt_arr[q] + '_error').text('');
    				$('#' + cmnt_descarr[q] + '_error').css('display', 'none');
    				$('#' + cmnt_descarr[q] + '_error').text('');
    			}
    		} else if (hid_doc != '' && cmnt_desc == '') {
    			$('#' + cmnt_descarr[q] + '_error').css('display', 'block');
    			$('#' + cmnt_descarr[q] + '_error').text('Enter description');
    			err = 1;
    		} else {
    			$('#' + cmnt_arr[q] + '_error').css('display', 'none');
    			$('#' + cmnt_arr[q] + '_error').text('');
    			$('#' + cmnt_descarr[q] + '_error').css('display', 'none');
    			$('#' + cmnt_descarr[q] + '_error').text('');
    		}
    		s++;
    	}
    	var g = 1;
    	$(".uploadlogo").each(function () {
    		var doc_desc = $('#meet_desc_' + g).val();
    		var inputid = $(this).attr('id');
    		var sprid = inputid.split('_');
    		var hid_doc = $('#exist_doc_' + sprid[2]).val();
    		if (typeof hid_doc == undefined || hid_doc == '') {
    			var filename = readURL(this);

    			if (filename) {
    				var result = filename.split('|*|');
    				if (result[1] != 2 && doc_desc != '') {
    					$(this).parent().children('span').html(result[0]);
    					if (result[1] != '1') {
    						$(this).parent().parent().children('.sow_msg').show();
    						$(this).parent().parent().children('.sow_msg').text(result[1]);
    						err = 1;
    					} else {
    						$(this).parent().parent().children('.sow_msg').text('');
    						$(this).parent().parent().children('.sow_msg').hide();
    					}
    				}
    			}
    			g++;
    		}

    	});
    	return err;
    }

    $(document).on('change', '.uploadlogo', function () {
    	var inputid = $(this).attr('id');
    	var sprid = inputid.split('_');
    	var hid_doc = $('#exist_doc_' + sprid[2]).val();
    	var filename = readURL(this);

    	var reslt = filename.split('|*|');
    	$(this).parent().children('span').html(reslt[0]);
    	if (reslt[1] != '1') {
    		$(this).parent().parent().children('.sow_msg').show();
    		$(this).parent().parent().children('.sow_msg').text(reslt[1]);
    	} else {
    		$('#exist_doc_' + sprid[2]).val('');
    		$(this).parent().parent().children('.sow_msg').text('');
    		$(this).parent().parent().children('.sow_msg').hide();
    	}
    });

    function readURL(input) {
    	var url = input.value;
    	var path, filename;
    	var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        //var bsize = input.files[0].size;
        var bsize = (input.files.length && input.files[0].size) || '';
        var fsize = Math.round(bsize / 1024);
        if (fsize <= 10000) {
        	if (fsize != 0) {
        		if (input.files && input.files[0] && (ext == "pdf" || ext == "doc" || ext == "docx" || ext == "ppt" || ext == "pptx" || ext == "jpg" || ext == "jpeg" || ext == "gif" || ext == "png" || ext == "xls" || ext == "xlsx" || ext == "csv")) {
        			path = $(input).val();
        			filename = path.replace(/^.*\\/, "");
        			return filename + '|*|1';
        		} else {
        			filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file';
        			return filename;
        		}
        	} else {
        		filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|2';
        		return filename;
        	}
        } else {
        	filename = '<span><i class="fas fa-upload"></i> Upload</span>|*|Invalid file size';
        	return filename;
        }
    }

</script>

</body>
</html>