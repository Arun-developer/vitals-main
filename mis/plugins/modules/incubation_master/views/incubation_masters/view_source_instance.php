<?php ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Villgro MIS</title>
</head>

<body>
    <?php   $this->load->view('incubation_masters/header.php', array('page' => 'source_instance_master')); ?>
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
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 pad-none display-flex">
                                    <h4>Source Master</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-12 text-right">
                                </div>
                            </div>
                            <div class="plan-structure-vital vital_windowScroll">
                                <div class="tab-slider--container">
                                    <div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
                                        <main class="page-content">
                                            <div class="inputplan-structureall plan-structure-new pad-none">
											<div style="height: 10px;"></div>
                                                <form method="post" id="job_search" autocomplete="off">
													<div class="row v_m_e_search">
														<div class="col-xl-12 col-lg-2 col-md-4 col-4">
															<ul class="vitals-links spec-label">
															
																<li class="mob_fulfill">
																	<label class="form-group">Date From</label>
																	<div class="form-group mar-bt8  wdt_180">
																		<input type="text" id="date_from" name="date_from" class="form-control" placeholder="dd-mm-yyyy">
																	</div>
																	<div id="criteria_err"></div>
																</li>
																<li class="mob_fulfill">
																	<label class="form-group">Date To</label>
																	<div class="form-group mar-bt8  wdt_180">
																		<input type="text" id="date_to" name="date_to" class="form-control" placeholder="dd-mm-yyyy">
																	</div>
																</li>
																
																<li class="pad-lt15px mob_fulfill">
																	<label class="form-group">Instance Name</label>
																	<div class="form-group has-search-right mar-bt8 wdt_180">
																		<a class="form-control-feedback" id="search_btn"><span class="fa fa-search"></span></a>
																		<input type="text" class="form-control" name="source_name" id="source_name" value="" placeholder="Search">
																	</div>
																	<div id="label_err"></div>
																</li>
																<li class="cursor" id="reset_search"><span class="vitals_clearSearch">Clear search</span></li>
																
																<li style="margin-left: 440px;">
																	<a href="<?php echo base_url() . 'index.php/incubation_master/addEdit_source_instance/'.$this->uri->segment(3); ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add Instance</a>
																</li>
																<?php if($isAuth){?>
																<li >
																	<a  href="<?php echo base_url() . 'index.php/incubation_master/ajax_incubation_pm_export'; ?>" id="export" class="master_aduser"><span><i class="fas fa-download"></i></span> Export</a>
																</li>
																<?php } ?>
																<li>
																	<a href="javascript:void(0)" class="master_deluser none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
																</li>
															</ul>
														</div>
													</div>
												</form>
												<div style="height: 10px;"></div>
										
                                                <div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                        <table class="table table-hover dt-responsive dataTable" id="master_table" style="margin-top: 0">
                                                            <thead>
                                                                <tr>
																	<th width="5%" class="removeArrow"><input class='form-control master_check_all' type='checkbox' name='master_check_all' id='master_check_all' onchange="selectall_chk();"></th>
                                                                    <th width="18%">Source Name</th>
                                                                    <th width="10%">Instance Name</th>
                                                                    <th width="10%">Date</th>
                                                                    <th width="10%">Remarks</th>
                                                                    <th width="10%">Document</th>
                                                                    <th width="5%">status</th>
                                                                    <th width="5%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="delete_ids" id="delete_ids" />
                                                <input type="hidden" name="master_type" id="master_type" value="<?php echo $master_type; ?>" />
                                                <!-- </div> -->
                                                <!-- </div> -->
                                            </div>
                                            <div  style="display:none;"  id="load_print"></div>
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

    <style>
        div.dataTables_scrollHead table thead tr th:first-child, .vitalMasterDataTbl table.dataTable tbody tr td:first-child{
            min-width:20px !important;
            max-width:20px !important;
        }
        table.dataTable thead .sorting_desc:after {
        position: absolute;
        top: 10px;
        right: -3px;
        display: block;
        font-family: 'Glyphicons Halflings';
        opacity: 0.5;
    }
    table.dataTable thead .sorting_asc:after,table.dataTable thead .sorting:after{
        top: 10px;
        right: 0px;
    }
    div.dataTables_scrollHead table{
                margin-bottom: 10px !important;
            }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
			$('.scrollsideMenu').scrollTop($('.scrollsideMenu').scrollTop()+250);
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
			$('#filter_form').validate({
				rules: {
					sector_type: "required"
				},
				messages: {
					sector_type: "Select Sector Type"
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
		$(document).on('change', '#source,#source_type', function() {
			master_trigger();
		});

		$('#source_name').keypress(function (e) {
			if (e.which == 13) {
				master_trigger();
				return false;
			}	
		});
		function filter_check(){
			filter_err = 0;
			$("#criteria_err").html('');$("#label_err").html('');
			var criteria = $('#criteria').val();
			if(criteria ==''){
				filter_err = 1;
				$("#criteria_err").html('<label class="error" id="txt_error">Select criteria</label>');
			}
			console.log(filter_err);
			if(filter_err > 0){
				return false;
			}else{
				master_trigger();
			}
		}
			
		$(document).on('click', '#reset_search', function() {
            $('#date_from').val('');
            $('#date_to').val('');
            $('#source_name').val('');
            master_trigger();
        });
		
		
		function master_trigger() {
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
            var source_name = $('#source_name').val();
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
                //"ordering": true,
                "responsive":false,
                "info": false,
                "searching": false,
                "lengthChange": false,
                "bServerSide": true,
                "stateSave": false,
                "autoWidth": false,
				"scrollY":'333px',
				"scrollCollapse": true,
                "pageLength": 10,
				"scrollY":'333px',
				"scrollCollapse": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>index.php/incubation_master/DTview_source_instance",
                    "type": "POST",
                    "data": {
                        "date_from": date_from,
                        "date_to": date_to,
                        "source_name": source_name,
                        "id":'<?php echo $this->uri->segment(3); ?>',
                    }
                },
                drawCallback: function(settings) {
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
					$("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                },
                'columnDefs': [{
                    'orderable': false,
                    'targets': [0,5,7]
                }],
                //"order": [1, 'desc']
            });
        }
	
		$(document).on('click', '#deleteRecord', function() {
			common_ids = [];
			$(".master_check").each(function(index) {
				if ($(this).is(":checked")) {
					if (this.value != '' && this.value != undefined && this.value !='on') {
						common_ids[index] = this.value;
					}
				}
			});
			
			var id = $('#delete_ids').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/incubation_master/commonDelete",
                data: {
                    id: common_ids,
                    table:'instance_master',
                },
                dataType: 'json',
                success: function(msg) { console.log(msg);
                    $('#deletemodal').modal('hide');
                    $('.deletetoast').toast('show');
					$("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                    //$('.deleteMsg').removeClass('display-hide');
                    setTimeout(function() {
						location.reload();
                    }, 1000);
                }
            });
		});
		
		$(document).on('click', '.master_check', function() {
			if (!$(this).is(":checked")) {
				$("#delUser").addClass("opacity5 none-pointer");
				$(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled",true);
				$("#delUser").removeClass("clr_red");
			} else { 
				$(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled",false);
				$("#delUser").removeClass("opacity5 none-pointer");
				$("#delUser").addClass("clr_red");
			}
			if ($('input:checkbox.master_check').length > 0){
				if ($('input:checkbox.master_check').length != $('input:checkbox.master_check:checked').length) { console.log('1');
						$('.master_check_all').prop('checked', false);
						$("#save_btn ,#delUser").removeClass("opacity5 none-pointer");
						$("#delUser").addClass("clr_red");
					} else if ($('input:checkbox.master_check').length == $('input:checkbox.master_check:checked').length) {  console.log('2');
						$('.master_check_all').prop('checked', true);
				}	
			}
			if($('input:checkbox.master_check:checked').length ==0){ console.log('3');
				$("#save_btn ,#delUser").addClass("opacity5 none-pointer");
				$("#delUser").removeClass("clr_red");
				
			}
		});
		$(document).on('click', '.master_check_all', function() {
			if (!$(this).is(":checked")) {
				$('.master_check').prop('checked', false);
				$("#delUser").addClass("opacity5 none-pointer");
				$("#delUser").removeClass("clr_red");
				$(".master_check").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled",true);
				
			} else { 
				$("#delUser").removeClass("opacity5 none-pointer");
				$("#delUser").addClass("clr_red");
				$('.master_check').prop('checked', true);
				$(".master_check").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled",false);
			} 
			$(".new_field").parents("tr").find('input[type="text"],input[type="hidden"],select').prop("disabled",false);
			
			if($(".new_field").length > 0){
				$("#save_btn").removeClass("opacity5 none-pointer");
				$("#delUser").addClass("clr_red");
			}
		});
		$(document).on('click', '.new_field', function() {
			$(this).closest('tr').find('input[type="text"],input[type="hidden"],select').prop("disabled",false);
			$("#save_btn").removeClass("opacity5 none-pointer");
			$("#delUser").addClass("clr_red");
		});
		
		$(document).on('click', '#delUser', function() {
            $('#delCount').val('');
            var sel_item = $(".master_check:checkbox:checked").length;
            $('#delCount').html(sel_item);
            if (sel_item > 0)
                $('#deletemodal').modal('show');
        });
		
        function submit_fields() {
			$("#save_btn ,#delUser").addClass("opacity5 none-pointer");
			$("#delUser").removeClass("clr_red");
            $('#insertEditReason').submit();
        }
		
		$(document).on('input', '.commonAlphaNum', function() {
            if (this.value.match(/[^a-zA-Z0-9.,:\-&\/() ]/g)) {
                this.value = this.value.replace(/[^a-zA-Z0-9.,:\-&\/() ]/g, '');
            }
        });
    </script>
</body>

</html>