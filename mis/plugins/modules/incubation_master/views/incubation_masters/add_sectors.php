<?php $this->load->view('vitals_header.php', array('main_menu' => 'admin', 'page_title' => 'Master - Sectors')); ?>
<div class="dataconfig-content page-wrapper vitals_mainContent position-relative">
	<div class="row">
		<div class="col-lg-3 col-xl-3 col-md-3 col-12">
			<div id="leftMenuLoad">
				<?php $this->load->view('vitals_leftmenu.php', array('page' => 'incubation_masters')); ?>
			</div>
		</div>
		<div class="col-lg-9 col-xl-9 col-md-9 col-12 pad-lf0 ">
			<main class="page-content">
				<div class="row dataconfig d_v_d_c">
					<div class="col-xl-4 col-lg-4 col-md-12 col-12 pad-none display-flex">
						<span><a href="<?php echo base_url() . 'index.php/incubation_master/sectors'; ?>"><i class="fas fa-angle-left"></i> Back </a></span>
						<h4><?php echo $sector_name; ?></h4>
					</div>
				 
				</div>
				<div class="plan-structure-vital vital_windowScroll">
					<div class="tab-slider--container">
						<div id="tab1" class="tab-slider--body pad-none tabpanel-details config-wrapper dataconfig-content page-wrapper chiller-theme">
							<main class="page-content">
								<div class="inputplan-structureall plan-structure-new">
									<form method="post" id="insertSector" action="<?php echo base_url() . 'index.php/incubation_master/insertSector'; ?>" class="form" novalidate autocomplete="off">
										<div class="row leaveLabel">
											<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
												<div class="form-group">
													<label>Sector Name</label>
													<input type="text" class="form-control sector_name" name="sector_name" value="<?php echo $sector_name; ?>" />
													<input class="edit_cls" type="hidden" name="sector_id" id="sector_id" value="<?php echo $sector_id; ?>"/>
													<div id="sector_name_err"></div>
												</div>
												<div class="form-group">
													<label>Assigned Incharge<span></span></label>
													<select   name="associate_employee[]" class="form-control employeeInput select-ajax edit_cls" id="multiselect"  multiple="multiple">
													</select>
													<div id="associate_employee_err"></div>
												</div>

												<div class="form-group">
													<label>Sector Leads<span></span></label>
													<select   name="associate_sector_lead[]" class="form-control employeeInput select-ajaxs edit_cls" id="multiselect"  multiple="multiple">
													</select>
													<div id="associate_employee_errs"></div>
												</div>
												<input type="hidden" id="edit_status">
												<div id="submit_btn_cls" >
													<ul class="vitals-links">
														<li><input type="submit" id="submit_btn" class="vital_yellow_btn wdt_100" value="Save" ></input>

														</li>
														<li><a href="" class="wdt_100 vital_bordered_btn">Cancel</a></li>
													</ul>
												</div>
											</div>
										</div>
									</form>
								</div>
							</main>
						</div>
					</div>
				</div>
			</main>
		</div>
	</div>
</div>


<?php $this->load->view('vitals_footer.php', array('multi_select' => 'multiselect')); ?>

<script type="text/javascript">

    $('#insertSector').validate({
        rules: {
            sector_type: "required"
        },
        messages: {
            sector_type: "Select Sector Type"
        }
    });

    $(document).ready(function () {
        $('#multiselect').val('');
        var sectorid = $('#sector_id').val();
        var sector_type = '0';
        $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/incubation_master/getSectorIncharges',
            data: {id: sectorid, sector_type: sector_type},
            dataType: 'json',
            success: function (response) {
                $(".select-ajax").empty();
                sortedData = response.response;
                $.each(sortedData, function (i, item) {
                    if ($(".select-ajax option[value='" + item.emp_name + "']").length == 0) {
                        selected_val = '';
                        if (jQuery.inArray(item.id, response.incharge_id) !== -1) {
                            console.log(item.id);
                            selected_val = "selected";
                        }
                        if (sector_type == '') {
                            selected_val = '';
                        }
                        $('.select-ajax').append('<option ' + selected_val + ' value="' + item.id + '">' + item.emp_name + '</option>');
                    }
                });
                $('.select-ajax').multiselect('rebuild');
                multiselect_len = $('#multiselect :selected').length;
                if (multiselect_len != '0') {
                    $("#associate_employee_err").html('');
                }

                if ($("#edit_status").val() != '1') {
                    //$(".multiselect").attr("disabled", true);
                }

            },
        });


        $('#multiselect').val('');
        var sectorid = $('#sector_id').val();
        var sector_type = '1';
         $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/incubation_master/getSectorIncharges',
            data: {id: sectorid, sector_type: sector_type},
            dataType: 'json',
            success: function (response) { //console.log(response);
                $(".select-ajaxs").empty();
                sortedData = response.response;
                $.each(sortedData, function (i, item) {
                    if ($(".select-ajaxs option[value='" + item.emp_name + "']").length == 0) {
                        selected_val = '';
                        if (jQuery.inArray(item.id, response.incharge_id) !== -1) {
                            console.log(item.id);
                            selected_val = "selected";
                        }
                        if (sector_type == '') {
                            selected_val = '';
                        }
                        $('.select-ajaxs').append('<option ' + selected_val + ' value="' + item.id + '">' + item.emp_name + '</option>');
                    }
                });
                $('.select-ajaxs').multiselect('rebuild');
                multiselect_len = $('#multiselect :selected').length;
                if (multiselect_len != '0') {
                    $("#associate_employee_errs").html('');
                }

                if ($("#edit_status").val() != '1') {
                   //$(".multiselect").attr("disabled", true);
                }

            },
        });
    });

    $(document).on('click', '.summaryEdit', function (e) {
		
		
        $("#edit_status").val("1");
        $(".edit_cls").attr("disabled", false);
        $(".multiselect").attr("disabled", false);
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').removeClass("disabled");
        $('.btn-group .multiselect.dropdown-toggle.btn.btn-default ').attr("disabled", false);
        $("#submit_btn_cls").css("display", "block");
        $(".edit").addClass("activeTabs");
    });

    /* $(document).on('click', '#submit_btn', function (e) {
	
		 multiselect_len = $('#multiselect :selected').length;
		multiselect_lens = $('.select-ajaxs :selected').length;
		$("#associate_employee_err").html('');
		 $("#associate_employee_errs").html('');
		console.log(multiselect_len);
		 if (multiselect_len == '0' || multiselect_lens == '0') {
			if (multiselect_len == '0' && multiselect_lens == '0') {
				 $("#insertSector").valid();
				
				$("#associate_employee_err").html('<label style="text-align:end;color: #FF0000 !important;" id="assoc_err_lable" >Select Assigned Incharge</label>');
			}
		}
		var sectorName = $(".sector_name").val();
		 $("#sector_name_err").html('');
		if(sectorName == ''){
			 //e.preventDefault();
             $("#sector_name_err").html('<label style="text-align:end;color: #FF0000 !important;" id="assoc_err_lable" >Please enter the sector</label>');
		}else{
			$.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>index.php/incubation_master/checkSectorName',
            data: {sectorName: sectorName},
            dataType: 'json',
            success: function (response) { 
					if(response.status=='1'){
						e.preventDefault();
					}else{
						console.log(' checkSectorName ');
						return true;
					}
				},
			});			
		} 
    }); */
	
$(document).on('click', '#submit_btn', function (e) {
	
    e.preventDefault(); 
    var multiselect_len = $('#multiselect :selected').length;
    var multiselect_lens = $('.select-ajaxs :selected').length;
	var sectorName = $(".sector_name").val();
	
    $("#associate_employee_err").html('');
    $("#associate_employee_errs").html();
	$("#sector_name_err").html('');
	
    if (multiselect_len == 0 || multiselect_lens == 0) {
        if (multiselect_len == 0 && multiselect_lens == 0) {
            $("#insertSector").valid();
            $("#associate_employee_err").html('<label style="text-align:end;color: #FF0000 !important;" id="assoc_err_lable" >Select Assigned Incharge</label>');
			if (sectorName === '') {
				$("#sector_name_err").html('<label style="text-align:end;color: #FF0000 !important;" id="assoc_err_lable" >Please enter the sector</label>');
			}
            return; // Stop further execution if conditions are not met
        }
    }
	
    if (sectorName === '') {
        $("#sector_name_err").html('<label style="text-align:end;color: #FF0000 !important;" id="assoc_err_lable" >Please enter the sector</label>');
        return;
    }
    var isFormValid = true; 

    $.ajax({
        type: "POST",
        url: '<?php echo base_url(); ?>index.php/incubation_master/checkSectorName',
        data: { sectorName: sectorName },
        dataType: 'json',
        async: false,
        success: function (response) {
            if (response.status == '1') {
                $("#sector_name_err").html('<label style="text-align:end;color: #FF0000 !important;" id="assoc_err_lable" >Sector name already exists</label>');
                isFormValid = false; // Set the flag to false if sector name already exists
            } else {
                console.log(' checkSectorName ');
            }
        },
    });
    if (isFormValid) {
        $("#insertSector").submit();
    }
});



    
    function submit_fields() {
        $('#master_form').submit();
    }

    $(document).ready(function () {
        $('#multiselect, #accessibleTo').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });
    });

    function getSelectedValues() {
        var selectedVal = $("#multiselect, #accessibleTo").val();
        for (var i = 0; i < selectedVal.length; i++) {
            if (window.CP.shouldStopExecution(0))
                break;

            function innerFunc(i) {
                setTimeout(function () {
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