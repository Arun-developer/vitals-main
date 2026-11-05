<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Vendor - Bank Details', 'page_table' => 'datatable')); ?>

<style>
.page-content{
	height: 100vh;
}
.fileUpload {
        width: 80%;
    }
</style>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
    <div class="row">
        <div class="col-lg-3 col-xl-3 col-md-3 col-12">
           <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'approve','page' => 'vendor_bank_details')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                <div class="row dataconfig d_v_d_c">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4>Vendor Details</h4>
                    </div>
					 <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                        <h4><div id="type_name"> Status :  </div></h4>
						<?php 
							if(isset($vendorDetails) && $vendorDetails!=''){ 
								if($vendorDetails->status =='1'){
									echo " Pending"; 
								}else if($vendorDetails->status =='2'){
									echo " Approved"; 
								}else if($vendorDetails->status =='3'){
									echo " Amend"; 
								}else if($vendorDetails->status =='4'){
									echo " Deleted"; 
								}
							}
						?>
						
                    </div>
                </div>
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
                                <form id="vendor_form" action="<?php echo base_url() . 'index.php/vendor/insertEditVendorBank' ?>"  enctype=multipart/form-data method="POST" autocomplete="off">
								
								<div class="inputplan-structureall plan-structure-new tabpanel-details">
								
								 	<div class="row">
								
									 <input type="hidden" class="form-control" name="vendor_id" id="vendor_id" value="<?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->id;} ?>" />
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
											<label>Vendor Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="vendorName" id="vendorName" value="<?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->name;} ?>" />
                                        </div>
										
										<br>
										<div class="form-group">
                                            <label>GST <span class="text-danger">*</span></label>
                                             <select class="form-control amountInput ai" name="gst_status" id="gst_status" <?= $disabled; ?> >
                                                <option value="">--Select--</option>
                                                <option <?php if(isset($vendorDetails) && $vendorDetails!=''){ if($vendorDetails->gst_status =='Yes'){ echo "selected"; } } ?>  value="Yes" >Yes</option>
												<option <?php if(isset($vendorDetails) && $vendorDetails!=''){if($vendorDetails->gst_status =='No'){ echo "selected"; }} ?>  value="No" >No</option>
                                            </select>
										</div>
										
                                        <div class="form-group">
                                            <label>MSME <span class="text-danger">*</span></label>
                                            <select class="form-control amountInput ai" name="msme_status" id="msme_status" <?= $disabled; ?>>
                                                <option value="">--Select--</option>
                                                <option <?php if(isset($vendorDetails) && $vendorDetails!=''){ if($vendorDetails->msme_status =='Yes'){ echo "selected"; } } ?> value="Yes" >Yes</option>
												<option <?php if(isset($vendorDetails) && $vendorDetails!=''){ if($vendorDetails->msme_status =='No'){ echo "selected"; } } ?> value="No" >No</option>
                                            </select>
										</div>
										<?php if($user_status =='1' && $vendorDetails->status =='3'){ ?>
											<div id="comment_div" style="<?php if(isset($vendorDetails) && $vendorDetails!=''){ if($vendorDetails->amend =='1'){ echo "display:block"; }else { echo"display:none"; } } ?>" >  
												<label>Amend Report <span class="text-danger"></span></label>
												<textarea readonly type="text" class="form-control"  name="comment_text" id="comment_text"  /> <?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->comment;} ?></textarea>
											</div>
											<br>
										<?php } ?>
										<?php if($user_status =='2'){ ?>
											<div class="form-group">
												<label>Amend<span class="text-danger"></span></label>
												<input <?php if(isset($vendorDetails) && $vendorDetails!=''){ if($vendorDetails->amend =='1'){ echo "checked"; } } ?>  type='checkbox' name='amend_status' id='amend_status'>
											</div>
											<div id="comment_div" style="<?php if(isset($vendorDetails) && $vendorDetails!=''){ if($vendorDetails->amend =='1'){ echo "display:block"; }else { echo"display:none"; } } ?>" >  
												<label>Comment <span class="text-danger">*</span></label>
												<textarea type="text" class="form-control"  name="comment" id="comment"  /> <?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->comment;} ?></textarea>
											</div>
											<br>
										<?php } ?>
										
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
                                            <label>Address <span class="text-danger">*</span></label>
                                            <textarea type="text" class="form-control"  name="address" id="address"  /> <?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->address;} ?></textarea>
                                        </div>
										
										<div class="form-group"  style="<?php if(isset($vendorDetails) && $vendorDetails!=''){ if($vendorDetails->gst_status =='Yes'){ echo "display:block"; }else { echo"display:none"; } } ?>" id="gst_number_div">
											<label>GST Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="gst_number" id="gst_number" value="<?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->gst_number;} ?>" />
                                        </div>
										<div class="form-group"  style="<?php if(isset($vendorDetails) && $vendorDetails!=''){ if($vendorDetails->msme_status =='Yes'){ echo "display:block"; }else { echo"display:none"; } } ?>" id="msme_div">
											<label>MSME Registered <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="msme_registered" id="msme_registered" value="<?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->msme_registered;} ?>" />
                                        </div>
										
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
										 <div class="form-group">
											<label>PAN <span class="text-danger">*</span></label>
											<input maxLength="10" type="text" class="form-control"  name="pan" id="pan" value="<?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->pan;} ?>" />
											<div id="pan_error"></div>
											<input type="hidden" name="pan_error_val" id="pan_error_val">
										</div>
										<br>
                                    </div>
									
                                </div>
								
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
													$supprt_doc = $vendorDetails->supporting_documents;
													$expld_doc = explode(',', $supprt_doc);
													#echo'<pre>';print_r($vendorDetails->upload_invoice);die;
													if (count(unserialize($vendorDetails->upload_invoice))) {
														foreach (unserialize($vendorDetails->upload_invoice) as $key => $value) {
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
																		echo base_url() . '/uploads/vendor_documents/' . $value;
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
										<input type="hidden" name="account_number_err" id="account_number_err">
										
							
									
                                    <div style="height: 20px;"></div>
                                        <div class="table_configcontentnew pad-bt0">
                                            <div class="tabpanel-title">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-9 col-sm-6 col-12">
                                                        <h4>Bank Details</h4>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-right">
                                                        <ul class="milestone-links">
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" id="addMore" class="edit-btnconfig mar-tp15"><i class="fas fa-plus-circle"></i>&nbsp;Add New</a>
                                                            </li>
                                                            <li class="brd-left-onboard">
                                                                <a href="javascript:void(0)" class="edit-btnconfig mar-tp15  opacity5 none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </li>
                                                            <?php /* <li class="brd-left-onboard"><a id="save_btn" href="javascript:void(0)" class="saveContinue master_submit <?php if (count($donor) > 0) { ?> opacity5 none-pointer <?php } ?>" onclick="submit_fields();">Save</a></li> */  ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" table_configcontentnew quatermetric_forma" id="quatermetric_forma">
                                            <table class="table table-hover" id="master_table" style="margin-top: 0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%"><input class='form-control master_check_all' type='checkbox' name='master_check_all' id='master_check_all'></th>
                                                        <th width="20%">Account Number</th>
														<th width="20%">Bank Name</th>
                                                        <th width="20%">Branch Name</th>
                                                        <th width="20%">IFSC Code</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
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

<div class="modal" id="deleteInvoicemodal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content delete-alert">
            <div class="modal-body text-center">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="col-10">
                            <h4>Are you sure you want to delete the upload invoice?</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"><input type="hidden" name="delCount" id="delCount" />
                <button type="button" class="btn btn-default"><a class="close portfolioclose" data-dismiss="modal" aria-label="Close">Cancel</a></button>
                <button type="button" class="btn btn-success" id="deleteInvoice"> Delete </button>
            </div>
        </div>
    </div>
</div>
<!-- Model (Delete and select) -->
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
                            <p>you are about delete <span id="delCount"></span> selected information fields, you
                                can't undo this</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="deleteRecord"> Delete Selected</button>
            </div>
        </div>
    </div>
</div>

<style>
    .plan-structure-vital .plan-structure-new{
        overflow-y: auto !important;
    }
</style>

<?php $this->load->view('vitals_footer.php', array('page_name' => 'datatable')); ?>

<script type="text/javascript">

    $(document).ready(function () {
		
		  $(document).ready(function () {
            $('.nav-tabs').scrollingTabs({enableSwiping: true}).on('ready.scrtabs', function () {
                $('.tab-content').show();
            });

            $('#navLoad').removeClass('display-hide');

            $('.vital_windowScroll').css({
                'height': (($(window).height()) - 190) + 'px'
            });

        });
		
		var $textInput = $('#pan');
		$textInput.on('input change', function() {
			if($(this).val()!=''){
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>index.php/vendor/checkPanNumerExist",
					data: {panNumber: $(this).val(),vendorId: '<?php echo $vendorId; ?>'},
					dataType: 'json',
					success: function (msg) {
						$("#pan_error").html('');
						$("#pan_error_val").val('');
						if(msg.status=='1'){
							$("#pan_error_val").val('1');
							$("#pan_error").html('<label for="pan" style="color: #FF0000 !important;">PAN number already exits</label>')
						}
					}
				});
			}
		});
		
		$(document).ready(function() {
			
			 $(document).on('input', 'input[name="account_number[]"]', function() {
				 console.log('dfghgfhfgh');
				 $("#account_number_err").val('');
				 var currentId = this.id;
				 var currentVal = $(this).val();
				  $.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>index.php/vendor/checkAccountNumberExist",
					data: {
						account_number: $(this).val(),
						id: '<?php echo $vendorId; ?>',
					},
					dataType: 'json',
					success: function (msg) {
						$('label[for="' + currentId + '"]').remove();
						if(msg.status=='1'){
							var errorMessage = "Account number already exists";
							$("#account_number_err").val('1');
							var errorLabel = $('<label>').attr('for', currentId).text(errorMessage).css('color', 'red');;
							$('#' + currentId).after(errorLabel);
							return false;
						}else {
							$('.account_number').each(function() { 
								var currentAccId = this.id;
								if(currentId!=currentAccId){
									console.log(currentAccId);
									$('label.error[for="' + currentId + '"]').remove();;
									$('label.error[for="' + currentAccId + '"]').remove();;
									if(currentVal==$(this).val()){
										var inputId = currentId;
										$("#account_number_err").val('1');
										var errorMessage = "Account number already exists";
										var errorLabel = $('<label>').attr('for', inputId).text(errorMessage).css('color', 'red');;
										$('#' + inputId).after(errorLabel);
										return false;
									}else{
										var inputId = currentId;
										$('label[for="' + inputId + '"]').remove();
									}
								}
							});
						}
						
					}
				});	
			});
		});
		
		 $(document).on('click', '#removeDoc', function () {
			$('#deleteInvoicemodal').modal('show');
		});
		$(document).on('change', '#gst_status', function (e) {
			$("#gst_number_div").css("display","block")
			$("#gst_number").val("")
			if($(this).val()=='No' || $(this).val()==''){
				$("#gst_number_div").css("display","none")
			}
		});
		$(document).on('change', '#msme_status', function (e) {
			$("#msme_div").css("display","block")
			$("#msme_registered").val("")
			if($(this).val()=='No' || $(this).val()==''){
				$("#msme_div").css("display","none")
			}
		});
		$(document).on('change', '#amend_status', function (e) { 
			$("#comment_div").css("display","none");
			$("#comment").val("");
			if($(this).prop('checked')){
				$("#comment_div").css("display","block");
				
			}
		});
		
		
        $('.plan-structure-new').css({
            'height': (($(window).height()) - 250) + 'px'
        });

        setTimeout(function () {
            $('.success').addClass('display-hide');
        }, 3000);

        master_trigger();

    });

    function master_trigger() {
        var filter_search = $('#filter_search').val();
        var master_type = $('#master_type').val();
        var vendorId = '<?php echo $vendorId; ?>';
		if(vendorId!=''){
        $('#master_table').DataTable({
            "bProcessing": true,
            "bSortable": true,
            "destroy": true,
            "bDestroy": true,
            "paging": true,
            // "ordering": true,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "bServerSide": true,
            "stateSave": false,
            "autoWidth": false,
            "pageLength": 10,
            "scrollY": '288px',
			"scrollX": true,
            "scrollCollapse": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>index.php/vendor/DTVendorBankDetails",
                "type": "POST",
                "data": {
                    "search_field": filter_search,
                    "master_type": master_type,
                    "vendorId": vendorId
                }
            },
            drawCallback: function (settings) {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);

                var table = $('#master_table').dataTable();
                var data_len = table.fnGetData().length;
                if (data_len == 0) {
                    $('.master_check_all').hide();
                    $('tr td:first-child').addClass('none-pointer');
                }
                $('.master_check_all').prop('checked', false);
                $('#delete_ids').val('');
                selectall_chk();
            },
            'columnDefs': [{
                    'orderable': false,
                    'targets': [0],
                }],
            "order": [2, 'asc']
        });
		}
		
    }

    function enableEdits() {
        var store = $('#delete_ids').val();
        var arr = store.split(',');
        var len = arr.length;
        for (var a = 0; a < len; a++) {
        }
    }

    $(document).on('click', '#search_btn', function () {
        master_trigger();
    });

    $(document).on('click', '#reset_search', function () {
        $('#filter_search').val('');
        $('#donor_search').val('');
        master_trigger();
    });

    $(document).on('click', '#delUser', function () {
        $('#delCount').val('');
        var sel_item = $(".master_check:checkbox:checked").length;
        $('#delCount').html(sel_item);
        if (sel_item > 0)
            $('#deletemodal').modal('show');
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


    function deleteids(checkid) {
        var store = $('#delete_ids').val();
        var arr = store.split(',');
        var paylen = $('.master_check').length;
        var payinput = $('.master_check:checked').length;
        var delete_id = $('#master_edit_id_' + checkid).val();

        if (paylen != payinput) {
            $('.master_check_all').prop('checked', false);
        } else {
            $('.master_check_all').prop('checked', true);
        }
        if ($('#master_check_' + checkid).prop('checked') == true) {
            // $(".master_deluser").addClass("clr_red");
            $("#delUser").removeClass("opacity5 none-pointer");
            $('.master_submit').removeClass("opacity5 none-pointer");
            var idx = $.inArray(delete_id, arr);
            if (idx === -1) {
                arr.push(delete_id)
                arr.join(',')
                $('#delete_ids').val(arr);
            }
            $('.inline_field_' + delete_id).attr('readonly', false);
            $('.inline_field_' + delete_id).removeClass('opacity5 none-pointer');
        } else {
            var idx = $.inArray(delete_id, arr);
            if (idx === -1) {
            } else {
                $('.inline_field_' + delete_id).attr('readonly', true);
                $('.inline_field_' + delete_id).addClass('opacity5 none-pointer');
                arr.splice(arr.indexOf(delete_id), 1);
                arr.join(',')
                $('#delete_ids').val(arr);
            }
            if (arr == '') {
                var new_f = $(".new_field").length;
                if (new_f > 0) {
                    $('.master_submit').removeClass("opacity5 none-pointer");
                } else {
                    $('.master_submit').addClass("opacity5 none-pointer");
                }
                // $(".master_deluser").removeClass("clr_red");
                $("#delUser").addClass("opacity5 none-pointer");
            }
        }
    }
	
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

    $(document).on('click', '#deleteInvoice', function () {
		
        var id = $('#delete_ids').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/vendor/vendorDelete",
            data: {
                id: '<?php echo $vendorId; ?>',
                table: 'vendor',
				file: '<?php echo $vendorDetails->upload_invoice; ?>',
            },
            dataType: 'json',
            success: function (msg) {
                console.log(msg);
                $('#deleteInvoicemodal').modal('hide');
                $('.deletetoast').toast('show');
                $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                //$('.deleteMsg').removeClass('display-hide');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        });
		
    }); 
	
	$(document).on('click', '#approved', function () {
		let ament ='0';
		let comment ='';
 		if($("#amend_status").prop('checked')){
			ament = '1';
			comment = $('#comment').val();
		}
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/vendor/updateAmendStatus",
            data: {
                id: '<?php echo $vendorId; ?>',
                type: 'approved',
                ament: ament,
                comment: comment,
            },
            dataType: 'json',
            success: function (msg) {
               /*  console.log(msg);
                $('#deleteInvoicemodal').modal('hide');
                $('.deletetoast').toast('show');
                $("#save_btn ,#delUser").addClass("opacity5 none-pointer"); */
                //$('.deleteMsg').removeClass('display-hide');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        });
		
    }); 
	$(document).on('click', '#amend', function () {
		let amend ='0';
		let comment ='';
 		if($("#amend_status").prop('checked')){
			amend = '1';
			comment = $('#comment').val();
		}
		if(!$("#amend_status").prop('checked')){
			alert("Please check the amend")
			return;
		}

		if($('#comment').val().trim()==''){
			alert("Please add Comment")
			return;
		}
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/vendor/updateAmendStatus",
            data: {
                id: '<?php echo $vendorId; ?>',
                type: 'amend',
				amend: amend,
                comment: comment,
            },
            dataType: 'json',
            success: function (msg) {
               /*  console.log(msg);
                $('#deleteInvoicemodal').modal('hide');
                $('.deletetoast').toast('show');
                $("#save_btn ,#delUser").addClass("opacity5 none-pointer"); */
                //$('.deleteMsg').removeClass('display-hide');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        });
		
    }); 
	
	
	
	
	$(document).on('click', '#deleteRecord', function () {
		
		var common_ids = [];
        $(".master_check").each(function (index) {
            if ($(this).is(":checked")) {
                if (this.value != '' && this.value != undefined && this.value != 'on') {
                    common_ids[index] = this.value;
                }
            }
        });

        var id = $('#delete_ids').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/vendor/vendorBankDelete",
            data: {
                id: common_ids,
                table: 'vendor_bank_details',
            },
            dataType: 'json',
            success: function (msg) {
                console.log(msg);
                $('#deletemodal').modal('hide');
                $('.deletetoast').toast('show');
                $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                //$('.deleteMsg').removeClass('display-hide');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        });
		
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
                $('.master_check_all').prop('checked', false);
                $("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
            } else if ($('input:checkbox.master_check').length == $('input:checkbox.master_check:checked').length) {
                $('.master_check_all').prop('checked', true);
            }
        }
        if ($('input:checkbox.master_check:checked').length == 0) {
            $("#save_btn ,#delUser").addClass("opacity5 none-pointer");
        }
    });

    function selectall_chk() {
        if ($('input[name="master_check_all"]:checked').length > 0) {
            $('.master_check').prop('checked', true);
            // var favorite = [];
            $.each($(".master_check:checked"), function () {
                // favorite.push($(this).val());
                deleteids($(this).val());
            });
        } else {
            $('.master_check').prop('checked', false);
            $.each($(".master_check"), function () {
                // favorite.push($(this).val());
                deleteids($(this).val());
            });
        }
    }

    function submit_fields() {
        $('#master_form').submit();
    }

    $(document).on('input', '.commonAlphaNum', function () {
        if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
        }
    });

    $(document).on('click', '#addMore', function () {
		 $(".dataTables_empty").css('display', 'none');
        var dyn = $('#master_table tr').length + 1;
        var empty_dT = $(".dataTables_empty").length;
        var i = parseInt(dyn) + 1;
        var datas = '<tr id="master_tr_' + i + '" class="master_more"><input type="hidden" name="master_edit_id[]" id="master_edit_id_' + i + '" value="0"><td class="valign-center"><input class="form-control master_check new_field" type="checkbox" name="master_check" id="master_check_' + i + '" onchange="deleteids(this.value);" value="' + i + '"></td>';
        datas += '<td><input type="text" data-attr="attr' + i + '"  class="form-control account_number commonAlphaNum inline_field_' + i + '" name="account_number[]" id="account_number' + i + '" value="" placeholder="Account Number" /></td>';
        datas += '<td><input type="text" class="form-control commonAlphaNum inline_field_' + i + '" name="bank_name[]" id="bank_name_' + i + '" value="" placeholder="Bank Name" /></td>';
		datas += '<td><input type="text" class="form-control commonAlphaNum inline_field_' + i + '" name="branch_name[]" id="branch_name_' + i + '" value="" placeholder="Branch Name" /></td>';
        datas += '<td><input type="text" class="form-control commonAlphaNum inline_field_' + i + '" name="ifsc_code[]" id="ifsc_code_' + i + '" value="" placeholder="FSC Code" /></td>';
        
		//datas += '<td><select class="form-control inline_field_' + i + '" name="status[]" id="master_status_' + i + '" ><option value="">--Select--</option><option value="1">Active</option><option value="2" >Inactive</option></select></td></tr>';
        // $(datas).insertBefore($('#paygrade_tr_1'));
        $("#master_table tbody").prepend(datas);
        $('.master_submit').removeClass("opacity5 none-pointer");
       
        if (empty_dT = 1) {
            $(".dataTables_empty").parent('tr').remove();
        }
    });
	
  $(document).on("click", ".submitMultiple", function (e) {
	var  checkPan = $("#pan_error_val").val();
	var  account_number_err = $("#account_number_err").val();
	 
	$('#vendor_form').valid();
	e.preventDefault()
	var g = 1;
	var err = 0;
	$(".uploadlogo").each(function () {
		var doc_desc = $('#meet_desc_' + g).val();
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
	});
	if(err == 0 && checkPan!='1' && account_number_err!='1'){
		 $('#vendor_form').submit();
	} 
  });

   $('#vendor_form').validate({
		rules: {
			vendorName: "required",
			address: "required",
			pan: {
				required: true,
				minlength: 10,
				maxlength: 10,
				alphanumeric: true
			},
			gst_status: "required",
			gst_number: "required",
			msme_status: "required",
			msme_registered: "required",
			finance_user: "required",
			comment: "required",
			"account_number[]": "required",
			"bank_name[]": "required",
			"branch_name[]": "required",
			"ifsc_code[]": "required"
		},
		messages: {
			vendorName: "required",
			address: "required",
			 pan: {
				required: "Please enter your PAN number",
				minlength: "PAN number must be exactly 10 characters long",
				maxlength: "PAN number must be exactly 10 characters long",
				alphanumeric: "PAN number must contain only alphanumeric characters"
			},
			gst_status: "required",
			gst_number: "required",
			msme_status: "required",
			msme_registered: "required",
			finance_user: "required",
			comment: "required",
			"account_number[]": "required",
			"bank_name[]": "required",
			"branch_name[]": "required",
			"ifsc_code[]": "required",
		}
    });
	$(document).ready(function () {
		if($("#master_table tr").length <=1){
			$('#addMore').trigger('click'); 
			
		}
	})
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
        data += '<td width="30%"><input type="text" class="form-control meet_desc" name="supporting_documents[]" id="meet_desc_' + i + '" maxlength="100" placeholder="Enter Description" value="" /><label class="error" id="meet_desc_' + i + '_error"></label></td>';
        data += '<td width="30%"><div class="fileUpload blue-btn btn width100"><span><i class="fas fa-upload"></i> Upload</span><input type="file" class="uploadlogo" name="meet_doc[]" id="meet_doc_' + i + '" /></div>';
        data += '<span>&nbsp;<i title="Remove" class = "fas fa-minus-circle cursor" onclick = "removeDocRow(' + i + ');" aria-hidden = "true" ></i></span><label class="sow_msg error" id="meet_doc_' + i + '_error"></label></td><td></td></tr>';
         if (dyn == 0) {
            $('.support_doc_body').html(data);
        } else {
            $(data).insertAfter($('#document_tr_' + dyn));
        }
    });

	$(document).on('change', '.uploadlogo', function () {
		var filename = readURL(this);
		var reslt = filename.split('|*|');
		$(this).parent().children('span').html(reslt[0]);
		if (reslt[1] != '1') {
			$(this).parent().parent().children('.sow_msg').show();
			$(this).parent().parent().children('.sow_msg').text(reslt[1]);
		} else {
			$(this).parent().parent().children('.sow_msg').text('');
			$(this).parent().parent().children('.sow_msg').hide();
		}
	});
	
	
function readURL(input) {
    var url = input.value;
    var path, filename;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
	//                                                                                    var bsize = input.files[0].size;
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


	//$('#addMore').trigger('click'); 

</script>

</body>
</html>