<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Villgro MIS</title>
</head>
<?php $master_menu = $this->uri->segment(3);?>
<body>
    <div class="vi-dashboard-vital onboardtabmenu wdt-100">
    <?php  $this->load->view('asset/header.php', array('page' => 'requestlist')); ?>
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
            <?php } if ($errorMsg != '') { ?>
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
                            <?php $this->load->view('report/master_sidemenu.php', array('page' => 'requestlist')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                                    <h4>Innovation Archives</h4>
                                </div>
                            </div>
							
							<div class="plan-structure-vital vital_windowScroll">
								<div class="display-hide" id="navLoad">
                                    <div class="newCLickTabs">
                                        <div>
											<?php $type = $this->uri->segment(3); ?>
                                            <ul class="nav nav-tabs" role="tablist" style="margin-left:5px;">
                                                <li role="presentation" class="<?php if($type =='1')echo"active"; ?>"><a  href="<?php echo base_url() . 'index.php/report/old_innovations/1' ?>">Fy 11-12</a></li>
												<!--<li role="presentation" class="<?php if($type =='2')echo"active"; ?>"><a  href="<?php echo base_url() . 'index.php/report/old_innovations/2' ?>">Fy 09-10</a></li>
												<li role="presentation" class="<?php if($type =='3')echo"active"; ?>"><a  href="<?php echo base_url() . 'index.php/report/old_innovations/3' ?>">Fy 05-08</a></li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
								<div class="tab-slider--container tab-content">
                                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new">
											
												<form id="filter_job"  class="pad-lt15px " method="POST" autocomplete="off">
													<div class="col-xl-12 col-lg-8 col-md-7 col-12" style="margin-left:-25px; ">
														<ul class="vitals-links leaveLabel">
							
															<li class="mob_fulfill">
																<label class="form-group" >Name of the Enterprise</label>
																<div class="form-group mar-bt8  wdt_180">
																	<input type="text" id="name_of_enterprise"  name="name_of_enterprise" class="form-control" placeholder="Search">
																</div>
															</li>
															<li class="mob_fulfill">
																<label class="form-group" >Summary of the Business</label>
																<div class="form-group mar-bt8  wdt_180">
																	<input type="text" id="summary_business"  name="summary_business" class="form-control" placeholder="Search">
																</div>
															</li>
															<li class="mob_fulfill">
																<label class="form-group" >Website</label>
																<div class="form-group mar-bt8  wdt_180">
																	<input type="text" id="website"  name="website" class="form-control" placeholder="Search">
																</div>
															</li>
															<li class="mob_fulfill">
																<label class="form-group" >Name of the Entrepreuner</label>
																<div class="form-group mar-bt8  wdt_180">
																	<input type="text" id="name_of_entrepreneur"  name="name_of_entrepreneur" class="form-control" placeholder="Search">
																</div>
															</li>
															
															<li class="mob_fulfill">
																<label class="form-group" >Status</label>
																	<select class="form-control wdt_180"  name="status" id="status">
																		<option value="">--Select--</option>
																		<option value="rejected" <?php echo ($status == 'rejected') ? 'selected="selected"' : ''; ?>>
																			Rejected</option>
																		<option value="Follow up" <?php echo ($status == 'Follow up') ? 'selected="selected"' : ''; ?>>
																			Follow up</option>
																		<option value="Response" <?php echo ($status == 'Response') ? 'selected="selected"' : ''; ?>>
																			Response</option>
																		<option value="Hold" <?php echo ($status == 'Hold') ? 'selected="selected"' : ''; ?>>Hold</option>
																	</select>
															</li>
															
															<li class="mob_fulfill">
																<div class="form-group mar-bt8">
																	<li><a href="javascript:" id="search_btn" class="vital_yellow_btn pad-hr15 wdt_100">Search</a></li>
																	<li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
																</div>
															</li>
															
														</ul>
													</div>
													<div class="col-xl-5 col-lg-5 col-md-5 col-12 text-right">
														<ul class="vitals-links"></ul>
													</div>
												</form>
												
												<div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                        <table class="table table-hover dt-responsive" id="master_table" style="margin-top: 0">
                                                            <thead>
                                                                <tr>
                                                                    <th width="10%">Name of the Promoter</th>
                                                                    <th width="5%">Name of Enterprise</th>
                                                                    <th width="5%">Phone Number</th>
                                                                    <th width="5%">Summary</th>
                                                                    <th width="5%">Business Plan</th>
                                                                    <th width="5%">Email Address</th>
                                                                    <th width="5%">Website</th>
                                                                    <th width="5%">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
												
												<input type="hidden" name="delete_ids" id="delete_ids" />
												 
                                            </div>
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
			
			$('#transfer_form').validate({
				rules: {
					emp_id:{
						required:true
					},
					issue_date:{
						required:true
					},
				},
				messages: {
					emp_id: "Select Employee",
					issue_date: "Select Date",
				}
			});
			
			$(document).on('change', '#emp_id', function() {
				$("#other_employee").css('display','none');
				$("#other_employee").css('display','none');
				$("#other_employee_id").val('');
				if($(this).val() == 'others'){
					$("#other_employee").css('display','contents');
				}
			});

			$(document).on('click', '.cancel_at', function() {
				$("#emp_id").val('');
				$("#issue_date").val('');
			});			
			$(document).on('click', '#transfer', function() {
				if($("#transfer_form").valid() == true){
					$("#transfer_form").submit();
				}
				return false;
			});
			
			
        });

        $(document).ready(function() {
			
			$(document).on('click', '.transfer_cls', function() {
				var asset_number = $(this).attr('data-attr-an');
				var asset_code = $(this).attr('data-attr-ac');
				var asset_id = $(this).attr('data-attr-aid');
				
				$("#vendor_asset_id").val(asset_id);	
				$("#asset_num").val(asset_number);	
				$("#asset_co").val(asset_code);
				$('#transfermodal').modal('show');
			});
			$('#author').keypress(function (e) {
                if (e.which == 13) {
					filter_check();
					return false;
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
			master_trigger();
        });
		$(document).on('click', '#search_btn', function() {
            filter_check();
        });
		$(document).on('click', '#reset_search', function() {
			$("#category_err").html('');$("#book_name_err").html('');$("#author_err").html('');
		
			$('#vendor').val('');
			$('#asset_number').val('');
			$('#asset_name').val('');
			$('#asset_code').val('');
			$('#employee_id').val('');
			$('#date_from').val('');
			$('#date_to').val('');
			$('#available_status').val('');
            master_trigger();
			
        });
		
		function filter_check(){
			filter_err = 0;
			$("#category_err").html('');$("#book_name_err").html('');$("#author_err").html('');
			
			var master_id = $('#master_id').val();
			var book_name = $('#book_name').val();
			var author = $('#author').val();
			
			if(master_id ==''){
				filter_err = 1;
				$("#category_err").html('<label class="error" id="txt_error">Select category</label>');
			}
			if(filter_err > 0){
				return false;
			}else{
				master_trigger();
			}
		}	
		
		function master_trigger(){
			
			var name_of_enterprise = $('#name_of_enterprise').val();
			var summary_business = $('#summary_business').val();
			var website = $('#website').val();
			var name_of_entrepreneur = $('#name_of_entrepreneur').val();
			var status = $('#status').val();
			
			var action = '<?php echo $this->uri->segment(3); ?>';
			
            $('#master_table').DataTable({
				"scrollX": true,
                "initComplete": function(settings, json) {
                    $('.dataTables_scrollBody thead tr').css({visibility:'collapse'});
                },
                "bProcessing": true,
                "bSortable": true,
                "destroy": true,
                "bDestroy": true,
                "paging": true,
                // "ordering": true,
                "responsive":false,
                "info": false,
                "searching": false,
                "lengthChange": false,
                "bServerSide": true,
                "stateSave": false,
                "autoWidth": false,
                "pageLength": 20,
				"scrollY":'333px',
				"scrollCollapse": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>index.php/report/DTold_innovation",
                    "type": "POST",
                    "data": {
                        "name_of_enterprise": name_of_enterprise,
                        "summary_business": summary_business,
                        "website": website,
                        "name_of_entrepreneur": name_of_entrepreneur,
                        "status": status
                    }
                },
				'columnDefs': [{
                    'orderable': false,
                    'targets': [0,1,2,3,4,5,6,7],
                }],
				fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
					
				},
                drawCallback: function(settings){
					var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                    pagination.toggle(this.api().page.info().pages > 1);

                    var table = $('#master_table').dataTable();
                    var data_len = table.fnGetData().length;
                    if (data_len == 0) {
                        $('.master_check_all').hide();
                        $('tr td:first-child').addClass('none-pointer');
                    }
                },
            }); 
        }
		
					
		$(document).on('input', '.commonAlphaNum', function() {
            if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
                this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
            }
        });
    </script>
</html>