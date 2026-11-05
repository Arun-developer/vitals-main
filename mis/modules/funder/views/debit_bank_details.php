<?php $this->load->view('vitals_header.php', array('main_menu' => 'funder', 'page_title' => 'Funds/Grants List', 'page_table' => 'datatable', 'module' => 'leave_summary'));
$currency = $this->session->userdata['currency']; ?>

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
           <?php $this->load->view('vitals_leftmenu.php', array('left_menu' => 'funder', 'page' => 'debit_bank_list')); ?>
        </div>
        <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
            <main class="page-content">
                
                <div class="plan-structure-vital vital_windowScroll">
                    <div class="tab-slider--container">
                        <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                            <main class="page-content">
								<div class="row dataconfig d_v_d_c">
									<div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
										<h4><div id="type_name">Add Edit Bank Details</div></h4>
									</div>
								</div>
                                <form id="debit_bank_form" action="<?php echo base_url() . 'index.php/funder/insertEditBank' ?>"  enctype=multipart/form-data method="POST" autocomplete="off">
								<div class="inputplan-structureall plan-structure-new tabpanel-details">
									<div class="row">
									 <input type="hidden" class="form-control" name="bank_id" id="bank_id" value="<?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->id;} ?>" />
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="form-group">
											<label>Account Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="account_number" id="account_number" value="<?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->account_number;} ?>" />
											<div id="account_number_error"></div>
											<input type="hidden" name="account_number_error_val" id="account_number_error_val">
										</div>
										<div class="form-group">
											<label>	IFSC Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" value="<?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->ifsc_code;} ?>" />
                                        
										</div>
										
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
										
										<div class="form-group">
											<label>Bank Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->bank_name;} ?>" />
                                        </div>
										
										
										<div class="form-group">
                                            <label>Donor type <span class="text-danger">*</span></label>
                                            <select class="form-control amountInput ai" name="donor_type" id="donor_type" <?= $disabled; ?>>
                                                <option value="">--Select--</option>
                                                <option <?php if(isset($vendorDetails) && $vendorDetails!=''){ if($vendorDetails->donor_type =='FCRA'){ echo "selected"; } } ?> value="FCRA" >FCRA</option>
												<option <?php if(isset($vendorDetails) && $vendorDetails!=''){ if($vendorDetails->donor_type =='Non FCRA'){ echo "selected"; } } ?> value="Non FCRA" >Non FCRA</option>
												<option <?php if(isset($vendorDetails) && $vendorDetails!=''){ if($vendorDetails->donor_type =='Revenue'){ echo "selected"; } } ?> value="Revenue" >Revenue</option>
                                            </select>
											</div>
                                    </div>
									 <div class="col-12 col-md-4 col-lg-4 col-xl-4">
									 <div class="form-group">
											<label>	Branch Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="branch_name" id="branch_name" value="<?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->branch_name;} ?>" />
                                        </div>
										
										<br>
									
                                </div>
                                </div>
								
									  <div class="row">
                                        <div class="col-12 col-sm-4  col-md-4 ">
                                            <div class="text-left">
                                                <ul class="vitals-links saveLinkView">
													<li><input type="submit" id="submit_btn"  value="Save" class="wdt_100 vital_yellow_btn submitMultiple"></li>
													<li><a href="" class="wdt_100 vital_bordered_btn">Cancel</a></li>
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
	$('.plan-structure-new').css({
	'height': (($(window).height()) - 250) + 'px'
	});
		var $textInput = $('#account_number');
		$textInput.on('input change', function() {
			if($(this).val()!=''){
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>index.php/funder/checkAccountNumerExist",
					data: {accountNumer: $(this).val(),bankId: '<?php if(isset($vendorDetails) && $vendorDetails!=''){ echo $vendorDetails->id;} ?>'},
					dataType: 'json',
					success: function (msg) {
						$("#account_number_error").html('');
						$("#account_number_error_val").val('');
						if(msg.status=='1'){
							$("#account_number_error_val").val('1');
							$("#account_number_error").html('<label for="pan" style="color: #FF0000 !important;">Account number already exits</label>')
						}
					}
				});
			}
		});
		
	
	
});

$(document).on("click", ".submitMultiple", function (e) {
	$('#debit_bank_form').valid();
	e.preventDefault();
	if($('#debit_bank_form').valid() && $("#account_number_error_val").val()!='1'){
		$('#debit_bank_form').submit();
	}
});

$('#debit_bank_form').validate({
	rules: {
		donor_type: "required",
		account_number: "required",
		bank_name: "required",
		branch_name: "required",
		ifsc_code: "required"
	},
	messages: {
		donor_type: "required",
		account_number: "required",
		bank_name: "required",
		branch_name: "required",
		ifsc_code: "required"
	}
});
	
</script>

</body>
</html>