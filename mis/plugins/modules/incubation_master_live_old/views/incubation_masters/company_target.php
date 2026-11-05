<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Villgro MIS</title>
</head>
<?php $master_menu = $this->uri->segment(3);?>
<body>
    <?php  $this->load->view('incubation_masters/header.php', array('page' => 'portfolio_settings')); ?>
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
                            <?php $this->load->view('incubation_masters/master_sidemenu.php', array('page' => 'portfolio_settings')); ?>
                        </div>
                        <div class="footer-link">
                            <p>copyright &copy; mis.villgroapps.org</p>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
                        <main class="page-content">
                            <div class="row dataconfig d_v_d_c">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
                                    <h4><?php echo $titles; ?> Settings</h4>
                                </div>
                            </div>
							
							<div class="plan-structure-vital vital_windowScroll">
								<div class="display-hide" id="navLoad">
                                    <div class="newCLickTabs">
                                        <div>
                                            <ul class="nav nav-tabs" role="tablist" style="margin-left: 5px;" >
                                                <li role="presentation" class="<?php if($master_menu =='designation')echo"active"; ?>"><a  href="<?php echo base_url() . 'index.php/incubation_master/portfolio_settings/designation' ?>">Designation settings</a></li>
                                                <li role="presentation" class="<?php if($master_menu =='partnership_type')echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/incubation_master/portfolio_settings/partnership_type' ?>">Non Tap settings</a></li>
                                                <li role="presentation" class="<?php if($master_menu =='units')echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/incubation_master/portfolio_settings/units' ?>">Units settings</a></li>
												<li role="presentation" class="<?php if($master_menu =='donor')echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/incubation_master/portfolio_settings/donor' ?>">Donor settings</a></li>
                                                <li role="presentation" class="<?php if($master_menu =='service')echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/incubation_master/portfolio_settings/service' ?>" >Service settings</a></li>
												<li role="presentation" class="<?php if($master_menu =='company_target')echo"active"; ?>"><a href="<?php echo base_url() . 'index.php/incubation_master/portfolio_settings/company_target' ?>" >Sector Target settings </a></li>
												
                                            </ul>
                                        </div>
                                    </div>
                                </div>
								<div class="tab-slider--container tab-content">
                                    <div id="tab1" class="tab-slider--body pad-none tab-pane active tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme" role="tabpanel">
                                        <main class="page-content">
                                                <div class="row justify-content-end">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12 text-right">
                                                        <ul class="vitals-links ">
                                                            <li>
                                                                <a href="<?php echo base_url() . 'index.php/incubation_master/add_company_target/'; ?>" class="master_aduser"><i class="fas fa-plus-circle"></i> Add New</a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" class="master_deluser none-pointer" id="delUser"><i class="fas fa-trash-alt"></i> Delete</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
												
												<div class="row">
                                                    <div class="col-12 col-lg-12 col-md-12 vitalMasterDataTbl">
                                                        <table class="table table-hover dt-responsive dataTable" id="master_table" style="margin-top: 0">
                                                            <thead>
                                                                <tr>
                                                                    <th width="5%" style="text-align: center;" class="removeArrow"><input class='master_check_all' type='checkbox' name='master_check_all' id='master_check_all' ></th>
                                                                    <th width="10%"><?php echo $titles; ?></th>
                                                                    <th width="10%">Financial Year</th>
                                                                    <th width="10%">Partner Type</th>
                                                                    <th width="10%">Application</th>
                                                                    <th width="10%">PA/RD</th>
                                                                    <th width="5%">Deals at IIC</th>
                                                                    <th width="5%">Deals at EIC</th>
                                                                    <th width="10%">Total Inc</th>
                                                                    <th width="5%">New Inc</th>
                                                                    <th width="5%">Exit Inc</th>
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
        div.dataTables_scrollHead table{
            margin-bottom: 10px !important;
        }
    </style>
    <script type="text/javascript">
	
        $(document).ready(function() {
			$('.scrollsideMenu').scrollTop($('.scrollsideMenu').scrollTop()+100);
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
            master_trigger();
        });
		$(document).on('click', '#reset_search', function() {
            $('#filter_search').val('');
			$('#branch').val('');
            master_trigger();
        });
		
		
		function master_trigger() {
            var filter_search = $('#filter_search').val();
			var branch = $('#branch').val();
            var table_name = $('#table_name').val();
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
				"scrollY":'333px',
				"scrollCollapse": true,
                "pageLength": 5,
                "ajax": {
                    "url": "<?php echo base_url(); ?>index.php/incubation_master/DTcompany_target",
                    "type": "POST",
                    "data": {
                        "search_field": filter_search,
                        "branch": branch,
                    }
                },
				
				fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
					$('#master_table tbody').on('click', 'tr', function (e) {
						if (!$(e.target).is("input")) {
							var edited_id = $(":checkbox:eq(0)", this).val();
							$(nRow).attr("href", '<?= base_url(); ?>' + 'index.php/incubation_master/view_company_target/' + edited_id);
							window.location = $(this).attr('href');
							return false;
						}
					});
				},
                drawCallback: function(settings) {
                    $('.master_check_all').prop('checked', false);
                    $('#delete_ids').val('');
					$("#save_btn ,#delUser").addClass("opacity5 none-pointer");
                },
                'columnDefs': [{
                    'orderable': false,
                    'targets': [0,1,2,3,4,5,6,7,8,9,10,11],
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
                    table:'port_dashboard_master',
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
		
		var adminType = '<?php echo $admin_type; ?>';
		$(document).on('click', '#addMore', function() {
			var i = master_table_count = $('#master_table tr').length + 1;
			var datas = '<tr id="master_tr_' + i + '" class="master_more"><input type="hidden" name="reason_edit_id['+i+']" disabled><td class="valign-center"><input class="form-control master_check new_field" type="checkbox" name="master_check" ></td>';
			datas += '<td><input class="form-control commonAlphaNum" type="text"  name="name['+i+']" ></td>';
			if(adminType == 0){
				datas += '<td><select class="form-control" name="branch['+i+']" ><?php echo $options; ?></select></td>'; 
			}
			datas += '<td><select class="form-control"  name="status['+i+']" ><option value="">--Select--</option><option value="1" >Approved</option><option value="0">Disapproved </option></td>';
			datas += '<td></td>';
			datas += '<td></td></tr>';
            $("#master_table tbody").prepend(datas);
			$("#save_btn").removeClass("opacity5 none-pointer");
			
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